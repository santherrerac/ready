<?php 

namespace core\html;

class tag extends element
{
  static $singleton_tags = array(
                            'area'    => true,
                            'base'    => true,
                            'br'      => true,
                            'col'     => true,
                            'command' => true,
                            'embed'   => true,
                            'hr'      => true,
                            'img'     => true,
                            'input'   => true,
                            'keygen'  => true,
                            'link'    => true,
                            'meta'    => true,
                            'param'   => true,
                            'source'  => true,
                            'track'   => true,
                            'wbr'     => true,
                          );  

  public    $tag_name;
  protected $attrs   = array();
  protected $style   = array();
  protected $classes = array();
  protected $content_collection;


  function __construct($tag_name = "div")
  {
    $this->tag_name           = $tag_name;
    $this->content_collection = new collection();
  }


  public function parents($selector)
  {
    $result = new collection();

    if ($this->parent)
    {
      if ($this->parent->match($selector)) $result->append($this->parent);
                                           $result->append($this->parent->parents($selector));
    }

    return $result;
  }

  //------------------------------- attrs related -------------------------------//


  public function attr($key, $value = null)
  {
    if ($value !== null)
    {
      $this->attrs[$key] = $value;

      switch ($key)
      {
        case 'class': $this->set_classes($value);          break;
        case 'style': $this->set_style_properties($value); break;
      }

      return $this;
    } 

    return $this->attrs[$key];
  }


  public function attrs($attrs)
  {
    foreach ($attrs as $key => $value) 
    {
      $this->attr($key, $value);
    }
    
    return $this;
  }


  public function remove_attr($key)
  {
    unset($this->attrs[$key]);
  }


  public function data($key, $value)
  {
    return $this->attr("data-$key", $value);
  }


  //------------------------------- css classes related -------------------------------//


  public function add_class($class_name)
  {
    $this->classes[$class_name] = true; 
    return $this;
  }


  public function add_classes($classes)
  {
    foreach ($classes as $class_name) 
    {
      $this->add_class($class_name);
    }

    return $this;
  }


  public function remove_class($class_name)
  {
    unset($this->classes[$class_name]);
  }


  public function has_class($class_name)
  {
    return $this->classes[$class_name]? true: false;
  }


  private function set_classes($classes_txt)
  {
    $this->classes = array();
    $classes       = explode(" ", $classes_txt);

    foreach ($classes as $class) 
    {
      $class = trim($class);
      if ($class) $this->classes[$class] = true;
    }
  }


  private function get_classes_txt()
  {
    $output = "";
    $i      = 0;

    foreach ($this->classes as $class => $t) 
    {
      $output .= ($i++? " ": "")."$class";
    }

    return $output? $output: null;
  }


  //------------------------------- css styles related -------------------------------//

  /**
   * @param  $property 'width' | array('width' => '500px', 'display' => 'block')
   * @param  $value    '500px' optional 
   * @return           value
   */
  public function style($property, $value = null)
  {
    if (is_array($property))
    {
      foreach ($property as $key => $value) 
      {
        $this->style($key, $value);
      }

      return;
    }

    if ($value === null) return $this->style[$property]; 

    return $this->style[$property] = $value; 
  }


  public function remove_style($property)
  {
    unset($this->style[$property]);
  }


  private function set_style_properties($style_txt)
  {
    $this->style = array();
    $styles      = explode(";", $style_txt);

    foreach ($styles as $style) 
    {
      list($key, $value) = explode(":", $style);      
      if ($key && $value) $this->style[$key] = $value;
    }
  }


  private function get_style_properties_txt()
  {
    $output = "";
    $i      = 0;

    foreach ($this->style as $key => $value) 
    {
      $output .= ($i++? " ": "")."$key: $value;";
    }

    return $output? $output: null;
  }


  //------------------------------- content related -------------------------------//

  public function html($html)
  {
    if ($html instanceof tag) $html->set_parent($this);

    $this->content_collection->clear();
    $this->content_collection->append($html);

    return $this;
  }


  public function append($html)
  {
    if ($html instanceof tag) $html->set_parent($this);

    return $this->content_collection->append($html);
  }


  public function prepend($html)
  {
    if ($html instanceof tag) $html->set_parent($this);

    $this->content_collection->prepend($html);
  }


  public function remove_child(element $child)
  {
    $this->content_collection->remove_child($child);
  }


  public function remove()
  {
    if ($this->parent)
    {
      $this->parent->remove_child($this);
    } 
  }


  public function find($selector)
  {
    return $this->content_collection->find($selector);
  }

  //------------------------------- render related -------------------------------//

  protected function render_attrs()
  {
    if ($style = $this->get_style_properties_txt()) $this->attr("style", $style);
    if ($class = $this->get_classes_txt())          $this->attr("class", $class);

    $output = array();

    foreach ($this->attrs as $key => $value) 
    {
      if ($value === "") $output[] = $key;
      else               $output[] = "$key=\"$value\"";
    }

    return (count($output)? " ": "").implode(" ", $output);
  }

  
  protected function render_content()
  {
    $output = "";
    $indent = str_pad("", element::INDENT_SPACES);
    $lines  = explode("\n", $this->content_collection);

    foreach ($lines as $line) 
    {
      $output .= ($line)? "\n{$indent}{$line}": "";
    }

    return $output? ($output."\n"): "";
  }


  public function __toString()
  {
    $self_closing = tag::$singleton_tags[$this->tag_name];
    $attrs        = $this->render_attrs();
    $content      = $this->render_content();

    if ($self_closing) $output = "<{$this->tag_name}{$attrs}/>\n";
    else               $output = "<{$this->tag_name}{$attrs}>{$content}</{$this->tag_name}>\n";

    return $output;
  }


  public function get_selector()
  {
    $id       = $this->attr("id")? "#".$this->attr("id"): "";
    $classes  = count($this->classes)? ".".implode(".", array_keys($this->classes)): "";
    $selector = "{$this->tag_name}{$id}{$classes}";

    return $selector;
  }

}

?>