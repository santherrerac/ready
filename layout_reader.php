<?php 

include "core/tag.class.php";
include "core/input.class.php";
include "core/collection.class.php";
include "core/html_reader.class.php";

use html\tag;
use html\input;
use html\html_reader;

$html = file_get_contents("view/layout.php");

// $html = '<div class="navbar-header">
// <<<asdf asd="dsa"<    button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            
//                 <span class="sr-only">Toggle navigation</span>
//                 <span class="icon-bar"></span>
//                 <span class="icon-bar"></span>
//                 <span class="icon-bar"></span>
//             </button>
//             <a class="navbar-brand" href="#">Ready Framework</a>
//         </div>';

$tag = new tag("content");
$tag->html($html);

print $tag;

// $reader = new html_reader($html);

// print $reader->get_tags();

 ?>