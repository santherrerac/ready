<?php 

require "core/autoload.php";

use html\tag;
use html\input;


$html = new tag("html");
$html->attr("lang", "en");

// head
$head = $html->append("<head>");

$head->append("<meta>")->attr("charset", "UTF-8");
$head->append("<title>")->html("Document");

$head->append("<script>")->attr("src", "plugins/jquery-1.11.2.min.js");
$head->append("<link>")->attr("rel", "stylesheet")->attr("href", "plugins/bootstrap-3.3.2-dist/css/bootstrap.min.css");
$head->append("<link>")->attr("rel", "stylesheet")->attr("href", "plugins/bootstrap-3.3.2-dist/css/bootstrap-theme.min.css");
$head->append("<script>")->attr("src", "plugins/bootstrap-3.3.2-dist/js/bootstrap.min.js");

// body
$body = $html->append("<body>");

    $nav = $body->append("<nav>");
    $nav->attr("role", "navigation");
    $nav->add_classes(array("navbar", "navbar-inverse"));

        $div = $nav->append("<div>")->attr("class", "navbar-header");

            $button = $div->append("<button>");
            $button->attr("type", "button");
            $button->add_class("navbar-toggle");
            $button->data("toggle", "collapse");
            $button->data("target", ".navbar-ex1-collapse");

                $button->append("<span>")->attr("class", "sr-only")->html("Toggle navigation");
                $button->append("<span>")->attr("class", "icon-bar");
                $button->append("<span>")->attr("class", "icon-bar");
                $button->append("<span>")->attr("class", "icon-bar");

            $a = $div->append("<a>");
            $a->add_class("navbar-brand");
            $a->attr("href", "#");
            $a->html("Ready Framework");

    $div = $nav->append("<div>")->attr("class", "collapse navbar-collapse navbar-ex1-collapse");

        $ul = $div->append("<ul>")->attr("class", "nav navbar-nav");

            $ul->append("<li>")->attr("class", "active")->append("<a>")->attr("href", "#")->html("Link");
            $ul->append("<li>")->append("<a>")->attr("href", "#")->html("Link");

        $form = $div->append("<form>")->attr("class", "navbar-form navbar-left")->attr("role", "search");

            $div2 = $form->append("<div>")->attr("class", "form-group");

                $input = $div2->append("<input>")->attrs(array("type" => "text", "class" => "form-control", "placeholder" => "Search"));

            $form->append("<button>")->attrs(array("type" => "submit", "class" => "btn btn-default"))->html("Submit");

        $ul = $div->append("<ul>")->attr("class", "nav navbar-nav navbar-right");

            $ul->append("<li>")->append("<a>")->attr("href", "#")->html("Link");
        
            $li = $ul->append("<li>")->attr("class", "dropdown");
                $a = $li->append("<a>")->attrs(array("href" => "#", "class" => "dropdown-toggle", "data-toggle" => "dropdown"))->html("Dropdown");
                    $a->append("<b>")->attr("class", "caret");      

                $ul = $li->append("<ul>")->attr("class", "dropdown-menu");
                    $ul->append("<li>")->append("<a>")->attr("href", "#")->html("Action");
                    $ul->append("<li>")->append("<a>")->attr("href", "#")->html("Another Action");
                    $ul->append("<li>")->append("<a>")->attr("href", "#")->html("Something else here");
                    $ul->append("<li>")->append("<a>")->attr("href", "#")->html("Separated link");
print $html;



?>