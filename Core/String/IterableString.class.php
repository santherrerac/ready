<?php 

namespace Core\String;

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


  public function next($q = 1)
  {
    $next = $this->position + $q;

    if ($next < strlen($this->string))
    {
      $this->position = $next;
      return true;
    }

    return false;
  }


  public function prev($q = 1)
  {
    $prev = $this->position - $q;

    if ($prev >= 0)
    {
      $this->position = $prev;
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
    return $this->_position = $this->position;
  }


  public function rewind()
  {
    $this->position = $this->_position? $this->_position: 0;
  }


  public function walkOnMatch($regex, $minLen = 1)
  {
    $result = "";  
    $start  = $this->savePos();

    do
    {
      $result .= $this->current();

      if (strlen($result) >= $minLen)
      {
        if (!preg_match($regex, $result))
        {
          $result = substr($result, 0, -1);
          $this->prev();
          break;
        }        
      }
    }
    while ($this->next());

    if (!$result || strlen($result) < $minLen)
    {
      $result = "";
      $this->rewind();
    } 

    return $result;
  }

}


 ?>