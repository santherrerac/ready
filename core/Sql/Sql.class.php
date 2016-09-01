<?php

namespace core\Sql;

class Sql
{
  public static function select()
  {
    $args   = func_get_args();
    $fields = is_array($args[0])? $args[0]: $args;
    $select = new Select();
    
    $select->fields($fields);
    
    return $select;
  }


  public static function condition($field, $operator, $value)
  {
    return new Condition($field, $operator, $value);
  }

  /***************************************** shortcuts ******************************************/

  public function equal       ($field, $value) { return SQL::condition($field, "=",        $value); }
  public function notEqual    ($field, $value) { return SQL::condition($field, "<>",       $value); }
  public function greater     ($field, $value) { return SQL::condition($field, ">",        $value); }
  public function less        ($field, $value) { return SQL::condition($field, "<",        $value); }
  public function greaterEqual($field, $value) { return SQL::condition($field, ">=",       $value); }
  public function lessEqual   ($field, $value) { return SQL::condition($field, "<=",       $value); }
  public function between     ($field, $value) { return SQL::condition($field, "BETWEEN",  $value); }
  public function like        ($field, $value) { return SQL::condition($field, "LIKE",     $value); }
  public function in          ($field, $value) { return SQL::condition($field, "IN",       $value); }

  public function notLike     ($field, $value) { return SQL::condition($field, "NOT LIKE", $value); }
  public function notIn       ($field, $value) { return SQL::condition($field, "NOT IN",   $value); }
}

?>