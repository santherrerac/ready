<?php 

include "core/tag.class.php";
include "core/input.class.php";
include "core/collection.class.php";

use html\tag;
use html\input;

$div = new tag("div");
$div->attr("id", "test");
$div->add_class("parent");

$child_div = new tag("div");
$child_div->add_class("child1");
$div->append($child_div);

$child_div2 = new tag("div");
$child_div2->add_class("child4");
$child_div->append($child_div2);

$child_div3 = new tag("div");
$child_div3->add_class("child5");
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
$child_div->html($input);

$input = new input("text");
$input->value("hello2");
$child_div->append($input);

$input = new input("text");
$input->value("hello3");
$child_div->append($input);

// $child_div->append($div);

print $div;


 ?>