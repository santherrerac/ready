<?php 

$post = new stdClass();

foreach ($_POST as $key => $value) 
{   
    $post->{$key} = $value;
}

$get = new stdClass();

foreach ($_GET as $key => $value) 
{   
    $get->{$key} = $value;
}


?>