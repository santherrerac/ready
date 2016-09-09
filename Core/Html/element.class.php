<?php

namespace core\html;

/**
*
*/
class element
{
  const INDENT_SPACES = 2;

  protected $text;
  protected $parent;


  function __construct($text)
  {
    $this->text = trim($text);
  }


  public function parent()
  {
    return $this->parent;
  }


  public function set_parent(tag $parent)
  {
    $this->parent = $parent;
  }


  public function __toString()
  {
    return $this->text."\n";
  }
}

?>