<?php 

namespace html;
/**
* 
*/
class collection
{
  protected $childs = array();

  
  function __construct()
  {   
  }


  public function clear()
  {
    $this->childs = array();
  }


  public function append($child)
  {
          if ($child instanceof collection) $childs = $child->get_all();
    else  if (is_array($child))             $childs = $child;

    if ($childs)
    {
      foreach ($childs as $_child) 
      {
        $this->append($_child);
      } 
    }
    else $this->childs[] = $child;
  }


  public function prepend($child)
  {
          if ($child instanceof collection) $childs = $child->get_all();
    else  if (is_array($child))             $childs = $child;

    if ($childs)
    {
      foreach ($childs as $_child) 
      {
        $this->prepend($_child);
      } 
    }
    else array_unshift($this->childs, $child);
  }


  public function length()
  {
    return count($this->childs);
  }


  public function last()
  {
    return $this->childs[($last = count($this->childs))? $last - 1: 0];
  }


  public function remove_last()
  {
    return array_pop($this->childs);
  }


  public function get_all()
  {
    return $this->childs;
  }


  public function get_list()
  {
    $output = array();

    foreach ($this->get_all() as $child) 
    {
      if (!($child instanceof tag)) continue;

      $output[] = $child->get_selector()."\n";
    }

    return $output;
  }


  public function find($selector)
  {
    $result = new collection();

    foreach ($this->childs as $child) 
    {
      if (!($child instanceof tag)) continue;
      if ($child->match($selector)) $result->append($child);
                                    $result->append($child->find($selector));
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


  //------------------------------- childs functions -------------------------------//

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


  public function attr($key, $value)
  {
    foreach ($this->childs as $child) 
    {
      if ($child instanceof tag) $child->attr($key, $value);
    }
  }


  public function __toString()
  {
    $output = "";

    foreach ($this->childs as $child) 
    {
           if ($child instanceof tag) $output .= $child->render();
      else if (is_string($child))     $output .= $child;
    }

    return $output;
  }

}

?>