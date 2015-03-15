<?php

print "ready framework first file, good look san!!<br>";

include_once("includes/annotations.class.php");
include_once("includes/html_tag.class.php");
include_once("includes/form.class.php");
include_once("model/user.php");


$user = new user();
$form = new form($user);

$form->render();

$form->name->render();


?>
<br>

