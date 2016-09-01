<?php 

namespace core\html;

/**
*  
*/
class parser
{
  
  function __construct()
  {    
  }


  public function get_elements($html)
  {
    $this->html = $html;
    $elements   = new collection();

    for ($i = 0, $txt = ""; $i < strlen($this->html); $i++) 
    { 
      $char = $this->html[$i];

      if ($char == "<" && $tag = $this->tag($i, $end_tag))
      {
        if ($txt) $txt = $elements->append(new element($txt));

        if ($end_tag)
        {          
          $childs = new collection();          

          do
          {
            $last = $elements->last();

            if ($last instanceof tag)
            {
              if ($last->_unclosed && $last->tag_name == $tag->tag_name)
              {
                unset($last->_unclosed);
                break;
              }
            }           

            $childs->prepend($elements->remove_last());
          }
          while($elements->length());

          if ($elements->length()) $last->append($childs);
          else                     $elements = $childs;
        }
        else $elements->append($tag);
      }
      else $txt .= $char;
    }

    if ($txt) $elements->append(new element($txt));

    return $elements;  
  }


  private function tag(&$i, &$end_tag)
  {
    $i_start  = $i;
    $end_tag  = $this->is_end_tag($i);
    $tag_name = $this->tag_name($i);

    if ($tag_name)
    {
      $tag = new tag($tag_name);
      $tag->_unclosed = true;

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
    for ($tag_name = ""; $i < strlen($this->html); $i++) 
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
    return "";
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
    return "";
  }

}

?>