<?php 

/**
* 
*/
class IterableString
{
  private $position = 0;
  private $string   = "";


  public function __construct($string)
  {
    $this->string = $string;
  }


  public function next()
  {
    $next = $this->position + 1;

    if ($next < strlen($this->string))
    {
      $this->position = $next;
      return true;
    }

    return false;
  }


  public function current()
  {
    return $this->string[$this->position];
  }


  public function pos()
  {
    return $this->position;
  }


  public function savePos()
  {
    $this->_position = $this->position;
  }


  public function rewind()
  {
    $this->position = $this->_position? $this->_position: 0;
  }


  public function walkOnMatch($regex)
  {
    $result = "";  
    $this->savePos();

    do
    {
      $result .= $this->current();

      if (!preg_match($regex, $result))
      {
        if ($result) return $result;
        else         break;
      }
    }
    while ($this->next());

    $this->rewind();

    return "";
  }

}


 ?>