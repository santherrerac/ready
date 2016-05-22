<?php 

include "core/tag.class.php";
include "core/input.class.php";
include "core/collection.class.php";

use html\tag;
use html\input;

$div = new tag("div");
$div->attr("id", "test");
$div->attr("name", "test_name");
$div->data("foo", "bar");

$span = new tag("span");
$span->attr("class", "text");
$span->html("hello world!!");

$input = new input("select");
$input->attr("name", "myselect");
$input->attr("id", "myselect");
$input->options(array("" => "", 1 => "option1", 2 => "option2"));
// $input->value(2);
$input->style(array("width"=>"500px"));

$input2 = new input("select");
$input2->attr("id", "myselect2");
$input2->options(array("" => "", 1 => "a", 2 => "b"));
$input2->add_class("dropdown");

$check = new input("checkbox");
$check->checked(true);
$check->value("asdf");

$span->add_classes(array("class2", "class3"));

$div->html($span);
$div->append($input);
$div->prepend($check);
$div->prepend("asdf");
$div->append($input2);

// $div->find("select")->remove();

print $div->render();


 ?>