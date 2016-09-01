<?php

namespace core\html;

class Html
{
  public function parse($str)
  {
    $parser = new parser();
    return $parser->get_elements($str);
  }
}

?>