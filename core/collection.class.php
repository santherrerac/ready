<?php 

namespace html;
/**
* 
*/
class collection
{
  protected $childs;

  
  function __construct()
  {   
  }


  public function clear()
  {
    $this->childs = array();
  }


  public function append($child)
  {
    $this->childs[] = $child;
  }


  public function prepend($child)
  {
    array_unshift($this->childs, $child);
  }


  public function get_all()
  {
    return $this->childs;
  }


  public function find($selector)
  {
    $result = new collection();

    if (preg_match("/^(\w+)/", $selector, $match)) $by_tag = $match[1];

    if (preg_match_all("/\[(\w+)(=[\'\"](.*)[\'\"])*\]/", $selector, $matches))
    {
      foreach ($matches[1] as $index => $attr) 
      {
        $by_attr[$attr] = $matches[3][$index];
      }
    }

    if (preg_match("/#(\w+)/", $selector, $match)) $by_id = $match[1];

    if (preg_match_all("/\.(\w+)/", $selector, $matches))
    {
      foreach ($matches[1] as $class_name) 
      {
        $by_class[] = $class_name;
      }
    }

    if (!$by_tag && empty($by_attr) && !$by_id && empty($by_class)) return $result;

    foreach ($this->childs as $index => $child) 
    {
      if (!($child instanceof tag)) continue;

      if ($by_tag && $child->tag_name != $by_tag) continue;

      foreach ($by_attr as $attr => $value) 
      {
        if ($child->attr($attr) != $value) continue 2;      
      }

      if ($by_id && $child->attr("id") != $by_id) continue;

      foreach ($by_class as $class_name) 
      {
        if (!$child->has_class($class_name)) continue 2;      
      }

      $result->append($child);
    }

    return $result;
  }


  public function each($function)
  {
    if (is_callable($function))
    {
      foreach ($this->get_all() as $index => $child) 
      {
        call_user_func($function, $index, $child);
      }
    }
  }


  public function remove_child(tag $child)
  {
    foreach ($this->childs as $index => $_child) 
    {
      if ($child == $_child) { unset($this->childs[$index]); break; }
    }
  }


  public function remove()
  {
    foreach ($this->childs as $child) 
    {
      if ($child instanceof tag) $child->remove();
    }
  }


  public function value($value)
  {
    foreach ($this->childs as $child) 
    {
      if ($child instanceof input) $child->value($value);
    }
  }

}

?>