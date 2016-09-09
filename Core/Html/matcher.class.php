<?php 

namespace Core\Html;
/**
*  
*/
class matcher
{

  function __construct()
  {
    # code...
  }


  public function match($selector)
  {
    if (!$selector) return true;

    // or selectors
    if (strpos($selector, ","))
    { 
      $selectors = explode(",", $selector);

      foreach ($selectors as $selector)
      {
        if ($this->match($selector)) return true;
      }

      return false;
    }

    // parent-child selector
    if (strpos($selector, " "))
    {
      list($parent_selector, $child_selector) = explode(" ", $selector);

      $parent_match = $this->parents($parent_selector)->length() || false;
      $child_match  = $this->match($child_selector);

      return $parent_match && $child_match;
    }

    // and selectors

    if (preg_match("/^([A-Za-z0-9]+)/", $selector, $match)) $by_tag = $match[1];

    if (preg_match_all("/\[([\w-]+)(=[\'\"](.*)[\'\"])*\]/", $selector, $matches))
    {
      foreach ($matches[1] as $index => $attr) 
      {
        $by_attr[$attr] = $matches[3][$index];
      }
    }

    if (preg_match("/#([\w-]+)/", $selector, $match)) $by_id = $match[1];

    if (preg_match_all("/\.(\w+)/", $selector, $matches))
    {
      foreach ($matches[1] as $class_name) 
      {
        $by_class[] = $class_name;
      }
    }

    // print $by_tag;

    if ($by_tag && $this->tag_name != $by_tag) return false;

    // print_r($by_attr);exit;

    // print_r($this->attrs);

    foreach ($by_attr as $attr => $value) 
    {
      // print "$attr:".$this->attr($attr)." [".$value." ".$this->attr('id')."\n";
      // if ($value == "" && $this->attr($attr) == "") continue;
      if ($this->attr(trim($attr)) != $value) return false;      
    }    

    if ($by_id && $this->attr("id") != $by_id) return false;

    foreach ($by_class as $class_name) 
    {
      if (!$this->has_class($class_name)) return false;   
    }
    
    return true;
  }

}

?>