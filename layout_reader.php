<?php 

include "core/element.class.php";
include "core/tag.class.php";
include "core/input.class.php";
include "core/collection.class.php";
include "core/html_reader.class.php";

use html\element;
use html\tag;
use html\input;
use html\html_reader;

$html = file_get_contents("view/layout.php");

$html = '<e>ds<div class="navbar-header" disabled="">
<<<asdf asd="dsa"<    button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Ready Framework</a>
            </div>asdsadsa
        </div>
        </div>
        </a>
        ';

// $tag = new tag("content");
// $tag->html($html);

$html_reader = new html_reader();
$result = $html_reader->get_elements($html);

print $result;

print $tag;

 ?>