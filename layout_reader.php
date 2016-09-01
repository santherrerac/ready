<?php

require "core/autoload.php";

use core\html\element;
use core\html\tag;
use core\html\input;
use core\html\parser;
use core\html\Html;

$html = file_get_contents("view/layout.php");

// $html = '<input>ds<div class="navbar-header" disabled>
// <<<asdf asd="dsa"<    button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            
//                 <span class="sr-only">Toggle navigation</span>
//                 <span class="icon-bar"></span>
//                 <span class="icon-bar"></span>
//                 <span class="icon-bar"></span>
//             </button>
//             <a class="navbar-brand" href="#">Ready Framework</a>
//             </div>asdsadsa
//         </div>
//         </div>
//         </a>
//         ';

// $tag = new tag("content");
// $tag->html($html);

// $html_reader = new reader();
// $result = $html_reader->get_elements($html);

$result = Html::parse($html);

// print_r($result);

print $result;

 ?>