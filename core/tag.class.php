<?php 

namespace html;

class tag 
{
  public $tag_name;

  protected $singleton_tags = array(
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
  protected $content = array();
  protected $attrs   = array();
  protected $style   = array();
  protected $classes = array();
  protected $content_collection;
  protected $parent;


  function __construct($tag_name)
  {
    $this->tag_name = $tag_name;
    $this->content_collection = new collection();
  }


  public function parent()
  {
    return $this->parent;
  }


  //------------------------------- attrs related -------------------------------//


  public function attr($key, $value = null)
  {
    if ($value === null)
    {
      if (!isset($this->attrs[$key])) $this->attrs[$key] = "";
    } 
    else
    {
      $this->attrs[$key] = $value;

      if ($key == "class") $this->set_classes($value);
      if ($key == "style") $this->set_style_properties($value);
    } 

    return $this->attrs[$key];
  }


  public function remove_attr($key)
  {
    unset($this->attrs[$key]);
  }


  public function data($key, $value = null)
  {
    return $this->attr("data-$key", $value);
  }


  //------------------------------- css classes related -------------------------------//


  public function add_class($class_name)
  {
    $this->classes[$class_name] = true; 
  }


  public function add_classes($classes)
  {
    foreach ($classes as $class_name) 
    {
      $this->add_class($class_name);
    }
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
      $key_value = explode(":", $style);
      $key       = trim($key_value[0]);
      $value     = trim($key_value[1]);

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
    if ($html instanceof tag) $html->parent = $this;

    $this->content_collection->clear();
    $this->content_collection->append($html);
  }


  public function append($html)
  {
    if ($html instanceof tag) $html->parent = $this;

    $this->content_collection->append($html);
  }


  public function prepend($html)
  {
    if ($html instanceof tag) $html->parent = $this;

    $this->content_collection->prepend($html);
  }


  public function remove_child(tag $child)
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

    foreach ($this->content_collection->get_all() as $child) 
    {
           if ($child instanceof tag) $output .= $child->render();
      else if(is_string($child))      $output .= $child;
    }

    return $output;
  }


  public function render()
  {
    $self_closing = $this->singleton_tags[$this->tag_name];

    $output = "<{$this->tag_name}".$this->render_attrs()."".($self_closing? "/>": ">");

    if ($self_closing) return $output;

    $output .= $this->render_content();
    $output .= "</{$this->tag_name}>";

    return $output;
  }

}

?>