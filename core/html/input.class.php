<?php

namespace core\html;

/**
* 
*/
class input extends tag
{  
  public $type;

  protected $value;


  function __construct($type = "text")
  {
    $this->type = $type; 

    switch ($this->type) 
    {
      case 'select':   parent::__construct("select");   break;
      case 'textarea': parent::__construct("textarea"); break;
      default:         
        parent::__construct("input");
        $this->attr("type", $this->type);

        if ($this->type == "checkbox") $this->value(1);
        break;
    }
  }

  //------------------------------- select related -------------------------------//

  public function options($options)
  {
    if ($this->type != "select") return;

    foreach ($options as $key => $value) 
    {
      $this->add_option($key, $value);
    }
  }


  public function add_option($key, $value)
  {
    if ($this->type != "select") return;

    $option = new tag("option");
    $option->attr("value", $key);
    $option->html($value);

    $this->append($option);
  }


  public function remove_option($key)
  {
    if ($this->type != "select") return;

    $this->find("option[value='$key']")->remove();
  }

  //------------------------------- checkbox and radio related -------------------------------//

  public function checked($checked)
  {
    if ($this->type != "checkbox" && $this->type != "radio") return;

    if ($checked) $this->attr("checked", "");
    else          $this->remove_attr("checked");
  }


  //------------------------------- general related -------------------------------//

  public function value($value)
  {
    if ($value === null) return $this->value;

    $this->value = $value;

    switch ($this->type) 
    {
      case 'select':
  
            $this->find("option")->each(function ($index, $option) use ($value)
            {
              if ($option->attr("value") == $value) $option->attr("selected");
              else                                  $option->remove_attr("selected");
            });

            break;
      
      case 'textarea': $this->html($value);          break;      
      default:         $this->attr("value", $value); break;
    }
  }

}


 ?>