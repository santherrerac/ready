<?php 

require "Core/autoload.php";

// use core\html\tag;
// use core\html\input;
use Core\Html\Parser;
use Core\String\IterableString;

$selector = Parser::selector(".clase..#das+.clase2 dsa:disabled:");

print_r($selector);

// $result = parser::classSelector(new IterableString(".clase"));

// print_r($result);

// print preg_match("/^\.(?!(\d)|(--)|(-\d))[a-zA-Z0-9-_]*$/", ".-_clase", $match);
// print_r($match);


exit;

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

print $div; exit;

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