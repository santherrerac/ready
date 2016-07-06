<?php 

namespace html;
/**
* 
*/
class collection
{
  protected $elements = array();

  
  function __construct()
  {
    $this->html_reader = new html_reader();   
  }


  public function clear()
  {
    $this->elements = array();
  }


  public function append($var)
  {
         if (is_string($var))            $var    = $this->html_reader->get_elements($var);
         if ($var instanceof collection) $childs = $var->get_all();
    else if (is_array($var))             $childs = $var;
    else if ($var instanceof element)    $child  = $var;

    if ($childs) 
    {
      foreach ($childs as $child) $this->append($child);
    }
    else if ($child) $this->elements[] = $child;
  }


  public function prepend($var)
  {
         if (is_string($var))            $var    = $this->html_reader->get_elements($var);    
         if ($var instanceof collection) $childs = $var->get_all();
    else if (is_array($var))             $childs = $var;
    else if ($var instanceof element)    $child  = $var;

    if ($childs) 
    {
      foreach ($childs as $child) $this->prepend($child);
    }
    else if ($child) array_unshift($this->elements, $child);
  }


  public function length()
  {
    return count($this->elements);
  }


  public function last()
  {
    return $this->elements[($last = count($this->elements))? $last - 1: 0];
  }


  public function remove_last()
  {
    return array_pop($this->elements);
  }


  public function get_all()
  {
    return $this->elements;
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

    foreach ($this->elements as $child) 
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
    foreach ($this->elements as $index => $_child) 
    {
      if ($child == $_child) { unset($this->elements[$index]); break; }
    }
  }


  //------------------------------- childs functions -------------------------------//

  public function remove()
  {
    foreach ($this->elements as $child) 
    {
      if ($child instanceof tag) $child->remove();
    }
  }


  public function value($value)
  {
    foreach ($this->elements as $child) 
    {
      if ($child instanceof input) $child->value($value);
    }
  }


  public function attr($key, $value)
  {
    foreach ($this->elements as $child) 
    {
      if ($child instanceof tag) $child->attr($key, $value);
    }
  }


  public function __toString()
  {
    $output = implode($this->elements);

    return $output;
  }

}

?>