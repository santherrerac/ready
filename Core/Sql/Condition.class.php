<?php

namespace core\Sql;


class Condition 
{
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
    $pair = new \Stdclass();
    $pair->glue      = $glue;
    $pair->condition = $condition;

    $this->conditions[] = $pair;

    return $this;
  }


  public function __toString()
  {
    $output = "$this->field $this->operator $this->value";
    $joined = "";

    foreach ($this->conditions as $i => $condition) 
    {
      $joined .= ($i?" ":"")."\n$condition->glue $condition->condition";  
    }
    
    if ($joined) $output = "($output $joined)";

    return $output;
  }


  /***************************************** shortcuts ******************************************/

  public function and_(Condition $condition) { return $this->join("AND", $condition); }
  public function or_ (Condition $condition) { return $this->join("OR",  $condition); }

  public function andEqual       ($field, $value) { return $this->and_(SQL::equal       ($field, $value)); }
  public function andGreater     ($field, $value) { return $this->and_(SQL::greater     ($field, $value)); }
  public function andLess        ($field, $value) { return $this->and_(SQL::less        ($field, $value)); }
  public function andGreaterEqual($field, $value) { return $this->and_(SQL::greaterEqual($field, $value)); }
  public function andLessEqual   ($field, $value) { return $this->and_(SQL::lessEqual   ($field, $value)); }
  public function andBetween     ($field, $value) { return $this->and_(SQL::between     ($field, $value)); }
  public function andLike        ($field, $value) { return $this->and_(SQL::like        ($field, $value)); }
  public function andIn          ($field, $value) { return $this->and_(SQL::in          ($field, $value)); }

  public function andNotEqual  ($field, $value) { return $this->and_(SQL::notEqual  ($field, $value)); }
  public function andNotBetween($field, $value) { return $this->and_(SQL::notBetween($field, $value)); }
  public function andNotLike   ($field, $value) { return $this->and_(SQL::notLike   ($field, $value)); }
  public function andNotIn     ($field, $value) { return $this->and_(SQL::notIn     ($field, $value)); }

  public function orEqual       ($field, $value) { return $this->or_(SQL::equal       ($field, $value)); }
  public function orGreater     ($field, $value) { return $this->or_(SQL::greater     ($field, $value)); }
  public function orLess        ($field, $value) { return $this->or_(SQL::less        ($field, $value)); }
  public function orGreaterEqual($field, $value) { return $this->or_(SQL::greaterEqual($field, $value)); }
  public function orLessEqual   ($field, $value) { return $this->or_(SQL::lessEqual   ($field, $value)); }
  public function orBetween     ($field, $value) { return $this->or_(SQL::between     ($field, $value)); }
  public function orLike        ($field, $value) { return $this->or_(SQL::like        ($field, $value)); }
  public function orIn          ($field, $value) { return $this->or_(SQL::in          ($field, $value)); }

  public function orNotEqual  ($field, $value) { return $this->or_(SQL::notEqual  ($field, $value)); }
  public function orNotBetween($field, $value) { return $this->or_(SQL::notBetween($field, $value)); }
  public function orNotLike   ($field, $value) { return $this->or_(SQL::notLike   ($field, $value)); }
  public function orNotIn     ($field, $value) { return $this->or_(SQL::notIn     ($field, $value)); }


  public function __call($method, $args)
  {
    print $method;
  }
}

?>