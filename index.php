<?php 

require "core/autoload.php";

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


use html\tag;
use html\input;

$div = new tag("div");
$div->attr("id", "test");
// $div->add_class("parent");

$child_div = new tag("div");
$child_div->add_class("child1");
$child_div->add_class("asdf");
$child_div->attr("id", "foo");
$div->append($child_div);

$child_div2 = new tag("div");
$child_div2->add_class("child4");
$child_div->append($child_div2);

$child_div3 = new tag("div");
$child_div3->add_class("parent");
$child_div2->append($child_div3);

$child_div = new tag("div");
$child_div->add_class("child2");
$child_div->append("hellow world");
$child_div3->append($child_div);

$child_div = new tag("div");
$child_div->add_class("child3");
$div->append($child_div);

$input = new input("text");
$input->value("hello");
$input->attr("id", "i1");
$child_div->html($input);

$input = new input("text");
$input->value("hello2");
$input->attr("id", "i2");
$child_div->append($input);

$input = new input("checkbox");
$input->value("hello3");
$input->attr("id", "i3");
$child_div->append($input);

//  $result = $div->find('.child5,[type="text"]');//->attr("marked", "");
// $result->attr("marked", "");
$result = $div->find('.parent div');

// $result->attr("marked", "");

print_r($result->get_list());

// $parents = $input->parents();

// print_r($parents->get_list());

// $child_div->append($div);

print $div;


 ?>