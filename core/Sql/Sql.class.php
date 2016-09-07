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

  public static function equal       ($field, $value) { return SQL::condition($field, "=",        $value); }
  public static function greater     ($field, $value) { return SQL::condition($field, ">",        $value); }
  public static function less        ($field, $value) { return SQL::condition($field, "<",        $value); }
  public static function greaterEqual($field, $value) { return SQL::condition($field, ">=",       $value); }
  public static function lessEqual   ($field, $value) { return SQL::condition($field, "<=",       $value); }
  public static function between     ($field, $value) { return SQL::condition($field, "BETWEEN",  $value); }
  public static function like        ($field, $value) { return SQL::condition($field, "LIKE",     $value); }
  public static function in          ($field, $value) { return SQL::condition($field, "IN",       $value); }

  public static function notEqual    ($field, $value) { return SQL::condition($field, "<>",          $value); }
  public static function notBetween  ($field, $value) { return SQL::condition($field, "NOT BETWEEN", $value); }
  public static function notLike     ($field, $value) { return SQL::condition($field, "NOT LIKE",    $value); }
  public static function notIn       ($field, $value) { return SQL::condition($field, "NOT IN",      $value); }
}

use core\Sql\Sql;
use core\Sql\condition;

$sql = SQL::select("station_key", "iata_code.da as ds", "city_name", "station_name", 
                   "concat('(',iata_code,') ', station_name) as station_des",
                   "concat('(',iata_code,') ', city_name) as city_des")
          ->from("table1")
          ->where(SQL::like("iata_code", "like_iata_code%") 
                  ->andLike("station_name", "like_iata_code%")
                  ->orLessEqual("city_name", "like_iata_code%")
                  ->orLike("concat('(',iata_code,') ', station_name)", "like_iata_code%")
                  ->orNotLike("concat('(',iata_code,') ', city_name)", "like_iata_code%")
                  ->andEqual("is_projected", 1)
                  ->and_(SQL::in("key", array(1, 2, 3))
                         ->or_(SQL::equal("a", "b")
                               ->andIn("key", array(45, 56))
                               ->andNotEqual("dd",  "ff")
                               )
                         )
                  )
          ->orderBy();

print $sql;

exit;

/*
SELECT station_key, iata_code.da as ds, city_name, station_name, 
       concat('(',iata_code,') ', station_name) as station_des, 
       concat('(',iata_code,') ', city_name) as city_des 
FROM   table1
WHERE (iata_code LIKE 'like_iata_code%' 
       AND station_name LIKE 'like_iata_code%' 
       OR city_name <= 'like_iata_code%' 
       OR concat('(',iata_code,') ', station_name) LIKE 'like_iata_code%' 
       OR concat('(',iata_code,') ', city_name) NOT LIKE 'like_iata_code%' 
       AND is_projected = 1 
       AND (key IN ('1', '2', '3') 
            OR (a = 'b' 
                AND key IN ('45', '56') 
                AND dd <> 'ff'
               )
           )
      )


$sql = "select station_key, iata_code, city_name, station_name,  
        concat('(',iata_code,') ', station_name) as station_des,
        concat('(',iata_code,') ', city_name) as city_des
        from stations
            where iata_code like '$like_iata_code%' 
            or station_name like '$like_iata_code%'
            or city_name    like '$like_iata_code%'
            or concat('(',iata_code,') ', station_name)  like '$like_iata_code%'
            or concat('(',iata_code,') ', city_name)     like '$like_iata_code%'";


"SELECT component_moment_key, fuel_groups.fuel_group_name 
            FROM   component_moments
            LEFT JOIN fuel_groups ON  component_moments.component_moment_subcode = fuel_groups.fuel_group_key
            WHERE  ahm_key = '$ahm_key' 
            and    component_moment_code ='".component_moment::CODE_FUEL_FLIGHT."'
            group by component_moment_subcode
            ORDER BY component_moment_subcode"


SELECT fuel_groups.fuel_group_key, fuel_groups.fuel_group_name 
FROM component_moments 
LEFT JOIN fuel_groups ON component_moments.component_moment_subcode = fuel_groups.fuel_group_key 
WHERE ahm_key = '154' and component_moment_code ='FUEL_FLIGHT' 
group by fuel_groups.fuel_group_key
having  count(component_moment_key) >= 2
ORDER BY component_moment_subcode


 */

?>