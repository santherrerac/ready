<?php

namespace core\Sql;

class Select
{

  public function fields()
  {
    $args = func_get_args();

    if (is_array($args[0])) $this->fields = $args[0];
    else                    $this->fields = $args;

    return $this;
  }


  public function from()
  {
    $args = func_get_args();

    if (is_array($args[0])) $this->tables = $args[0];
    else                    $this->tables = $args;

    return $this;
  }


  public function where(condition $condition)
  {
    $this->condition = $condition;
    return $this;
  }


  public function orderBy()
  {
    return $this;
  }


  public function __toString()
  {
    $fields = empty($this->fields)? "*": implode(", ", $this->fields);

    $sql = "SELECT {$fields} \nFROM   ".implode(", ", $this->tables);

    if ($this->condition) $sql .= "\nWHERE $this->condition"; 

    return $sql;
  }
}

?>