<?php

namespace Core\Html;

class Html
{
  public static function parse($str)
  {
    $parser = new parser();
    return $parser->get_elements($str);
  }
}

?>