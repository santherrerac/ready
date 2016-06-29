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
    for ($i = 0, $txt = ""; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];

      if ($char == "<" && $tag = $this->tag($i, $end_tag))
      {
        $txt = $this->push($txt);

        if ($end_tag)
        {
          $top    = $this->top();
          $childs = new collection();          

          while ($top->tag_name != $tag->tag_name)
          {
            $childs->prepend($this->pop());
            $top = $this->top();
          }

          $top->append($childs);
        }
        else $this->push($tag);
      }
      else $txt .= $char;
    }

    if ($txt) $this->push($txt);

    $childs = new collection();
    $childs->append($this->queue);

    return $childs;  
  }


  private function tag(&$i, &$end_tag)
  {
    $i_start  = $i;
    $end_tag  = $this->is_end_tag($i);
    $tag_name = $this->tag_name($i);

    if ($tag_name)
    {
      $tag = new tag($tag_name);

      for ( ; $i < strlen($this->html); $i++) 
      {
        if ($attr = $this->attr($i))
        {
          $tag->attr($attr['name'], $attr['value']);
        }      

        $char = $this->html[$i];

        if ($char == ">") { return $tag; }
        if ($char == "<") { break; }  
      }
    }

    $i = $i_start;
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
    if ($name = $this->attr_name($i))
    {      
      $attr['name']  = $name;
      $attr['value'] = $this->attr_value($i);
    }

    return $attr;
  }


  private function attr_name(&$i)
  {
    for ($name = ""; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];

      if (!preg_match("/[\s\"'<>\/=]/", $char))
      {
        $name .= $char;
      }
      else break;
    }

    return $name;
  }


  private function attr_value(&$i)
  {
    for ($i_start = $i; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];

      if (preg_match("/[\s\"'<>\/=`]/", $char))
      {
        if ($unquoted_value) return $unquoted_value;

        if ($finding_value)
        {
          $is_quote = $char == '"' || $char == "'";

          if ($is_quote && $quoted_value = $this->quotes($i, $char))
          {
            return $quoted_value;
          }
        }
        else if ($char == "=") $finding_value = true;
             
             if ($char == ">") break;
        else if ($char == "<") break;
      }
      else
      {
        if ($finding_value) $unquoted_value .= $char;
        else                break;
      }      
    }

    $i = $i_start;
  }


  private function quotes(&$i, $quote)
  {
    for ($i_start = $i, $i++, $txt = ""; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];

      if ($char == $quote) return $txt;
      else                 $txt .= $char;
    }

    $i = $i_start;
  }

}

?>