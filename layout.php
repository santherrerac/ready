<?php 

include "core/tag.class.php";
include "core/input.class.php";
include "core/collection.class.php";

use html\tag;
use html\input;


$html = new tag("html");
$html->attr("lang", "en");

// head
$head = $html->add("head");

$head->add("meta")->attr("charset", "UTF-8");
$head->add("title")->html("Document");

$head->add("script")->attr("src", "plugins/jquery-1.11.2.min.js");
$head->add("link")->attr("rel", "stylesheet")->attr("href", "plugins/bootstrap-3.3.2-dist/css/bootstrap.min.css");
$head->add("link")->attr("rel", "stylesheet")->attr("href", "plugins/bootstrap-3.3.2-dist/css/bootstrap-theme.min.css");
$head->add("script")->attr("src", "plugins/bootstrap-3.3.2-dist/js/bootstrap.min.js");

// body
$body = $html->add("body");

    $nav = $body->add("nav");
    $nav->attr("role", "navigation");
    $nav->add_classes(array("navbar", "navbar-inverse"));

        $div = $nav->add("div")->attr("class", "navbar-header");

            $button = $div->add("button");
            $button->attr("type", "button");
            $button->add_class("navbar-toggle");
            $button->data("toggle", "collapse");
            $button->data("target", ".navbar-ex1-collapse");

                $button->add("span")->attr("class", "sr-only")->html("Toggle navigation");
                $button->add("span")->attr("class", "icon-bar");
                $button->add("span")->attr("class", "icon-bar");
                $button->add("span")->attr("class", "icon-bar");

            $a = $div->add("a");
            $a->add_class("navbar-brand");
            $a->attr("href", "#");
            $a->html("Ready Framework");

    $div = $nav->add("div")->attr("class", "collapse navbar-collapse navbar-ex1-collapse");

        $ul = $div->add("ul")->attr("class", "nav navbar-nav");

            $ul->add("li")->attr("class", "active")->add("a")->attr("href", "#")->html("Link");
            $ul->add("li")->add("a")->attr("href", "#")->html("Link");

        $form = $div->add("form")->attr("class", "navbar-form navbar-left")->attr("role", "search");

            $div2 = $form->add("div")->attr("class", "form-group");

                $input = $div2->add("input")->attrs(array("type" => "text", "class" => "form-control", "placeholder" => "Search"));

            $form->add("button")->attrs(array("type" => "submit", "class" => "btn btn-default"))->html("Submit");

        $ul = $div->add("ul")->attr("class", "nav navbar-nav navbar-right");

            $ul->add("li")->add("a")->attr("href", "#")->html("Link");
        
            $li = $ul->add("li")->attr("class", "dropdown");
                $a = $li->add("a")->attrs(array("href" => "#", "class" => "dropdown-toggle", "data-toggle" => "dropdown"))->html("Dropdown");
                    $a->add("b")->attr("class", "caret");      

                $ul = $li->add("ul")->attr("class", "dropdown-menu");
                    $ul->add("li")->add("a")->attr("href", "#")->html("Action");
                    $ul->add("li")->add("a")->attr("href", "#")->html("Another Action");
                    $ul->add("li")->add("a")->attr("href", "#")->html("Something else here");
                    $ul->add("li")->add("a")->attr("href", "#")->html("Separated link");
print $html;



?>