<?php

namespace core\Sql;


class Condition 
{
  public  $glue     = "";
  private $operator = "";
  private $field    = "";
  private $value    = "";


  function __construct($field, $operator, $value)
  {
    $this->setField($field);
    $this->setOperator($operator);
    $this->setValue($value);
  }


  public function setOperator($operator) { $this->operator = $operator; }

  
  public function setField($field)
  {
    $this->field = $field;
  }


  public function setValue($value)
  {
         if (is_array($value))    $value = "('".implode("', '", $value)."')";
    else if (!is_numeric($value)) $value = "'$value'";

    $this->value = $value;
  }


  public function join($glue, Condition $condition)
  {
    $condition->glue = $glue;
    $this->conditions[] = $condition;

    return $this;
  }


  public function __toString()
  {
    $group = $this->glue && count($this->conditions);

    $output  = $this->glue? "\n$this->glue ": "";
    $output .= $group? "(": "";
    $output .= "$this->field $this->operator $this->value";
    $output .= implode($this->conditions);
    $output .= $group? ")": "";

    return $output;
  }


  /***************************************** shortcuts ******************************************/

  public function and_(Condition $condition) { return $this->join("AND", $condition); }
  public function or_ (Condition $condition) { return $this->join("OR", $condition);  }

  public function andLike    ($field, $value) { return $this->and_(SQL::like     ($field, $value)); }
  public function orLike     ($field, $value) { return $this->or_ (SQL::like     ($field, $value)); }
  public function orNotLike  ($field, $value) { return $this->or_ (SQL::notLike  ($field, $value)); }  
  public function andEqual   ($field, $value) { return $this->and_(SQL::equal    ($field, $value)); }
  public function andNotEqual($field, $value) { return $this->and_(SQL::notEqual ($field, $value)); }  
  public function andIn      ($field, $value) { return $this->and_(SQL::in       ($field, $value)); }
  public function orIn       ($field, $value) { return $this->or_ (SQL::in       ($field, $value)); }
  public function orLessEqual($field, $value) { return $this->or_ (SQL::lessEqual($field, $value)); }
}

?>