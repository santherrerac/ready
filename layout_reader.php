<?php 

include "core/tag.class.php";
include "core/input.class.php";
include "core/collection.class.php";
include "core/html_reader.class.php";

use html\tag;
use html\input;
use html\html_reader;

$html = file_get_contents("view/layout.php");

// print $html;exit;

$html = '<    button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <div class="navbar-header">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Ready Framework</a>
        </div>';

$reader = new html_reader($html);

$reader->get_tags();
// $reader->to_tags();

// $attr = $reader->get_attrs('button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"');
// print_r($attr);
// preg_match("/^<(\/?)([A-Za-z0-9]+)/", "</div>", $match);

// print_r($match);

// $end_tag = $match[1];
// $tag     = $match[2];

 ?>