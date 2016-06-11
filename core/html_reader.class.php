<?php 

namespace html;

/**
*  
*/
class html_reader
{  
  function __construct($html)
  {
    $this->html  = $html;
    $this->queue = array();
  }


  private function top()
  {
    return $this->queue[($last = count($this->queue))? $last - 1: 0];
  }


  private function pop()
  {
    return array_pop($this->queue);
  }


  private function push(&$el)
  {
    if (is_string($el))
    {
      if ($el = trim($el)) $this->queue[] = $el;
    }
    else $this->queue[] = $el;
  }


  public function get_tags()
  {
    $txt = "";

    for ($i = 0; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];

      if ($char == "<")
      {
        $txt = $this->push($txt);
        $tag = $this->tag($i, $end_tag);        

        if ($end_tag)
        {
          $top    = $this->top();
          $childs = array();          

          while ($top->tag_name != $tag->tag_name)
          {
            array_unshift($childs, $this->pop());
            $top = $this->top();
          }

          $top->childs = $childs;
        }
        else $this->push($tag);        
      }
      else $txt .= $char;
    }

    print_r($this->queue);  
  }


  private function tag(&$i, &$end_tag)
  {
    $end_tag  = $this->is_end_tag($i);
    $tag_name = $this->tag_name($i);
    $tag      = new \StdClass();

    $tag->tag_name = $tag_name;

    for ( ; $i < strlen($this->html); $i++) 
    {
      $char = $this->html[$i];

      if ($char == ">")  break;

      $attr = $this->attr($i);
      if ($attr) $tag->attrs[$attr['name']] = $attr['value'];     
    }

    print_r($tag); exit;

    return $tag;
  }


  private function is_end_tag(&$i)
  {
    for ($i++; $i < strlen($this->html); $i++)
    { 
      $char = $this->html[$i];

      if ($char == "/") { $i++; return true; }
      if ($char == " ") { continue; }

      break; 
    }

    return false;
  }


  private function tag_name(&$i)
  {
    $tag_name = "";

    for ( ; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];

      if (!$tag_name && $char == " ")          continue;
      if (!preg_match("/[a-zA-Z0-9]/", $char)) break;

      $tag_name .= $char;
    }

    return $tag_name;
  }


  private function attr(&$i)
  {
    for ( ; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];

      if (!isset($attr['name'])) // find attr
      {
        if (preg_match("/[\s\"'>\/=]/", $char))
        {
          if ($name)
          {
            if ($char == "=") $finding_value = true;
            $attr['name'] = $name;
          } 
        }
        else $name .= $char;
      }
      else // find value
      {
        if ($finding_value)
        {
          if (preg_match("/[\s\"'<>\/=`]/", $char))
          {
            if (!$unquoted_value)
            {
              if ($char == '"' || $char == "'") 
              { 
                $quoted_value = $this->quotes($i, $char);

                if ($quoted_value)
                {
                  $attr['value'] = $quoted_value;
                  break;
                }        
              }
            }
            else
            {
              $attr['value'] = $unquoted_value;
              break;
            }
          }
          else $unquoted_value .= $char;
        }
        else
        {
          if ($char == "=") $finding_value = true;          
        }
      }
    }

    return $attr;
  }


  private function quotes(&$i, $quote)
  {
    $txt = "";
    $j   = $i; 

    for ($i++; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];
      if ($char == $quote) { $closed = true; break; }
      $txt .= $char;
    }

    if (!$closed) { $txt = ""; $i = $j; } 

    return $txt;
  }

}

 ?>