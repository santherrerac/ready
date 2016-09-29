<?php 

include('ganon.php');

$html = file_get_dom('http://code.google.com/');

// Find all the paragraph tags with a class attribute and print the
// value of the class attribute

// foreach($html('p[class]') as $element) 
// {   
//   echo $element->class, "<br>\n"; 
// }


// Find the first div with ID "gc-header" and print the plain text of
 // the parent element (plain text means no HTML tags, just the text)

 // echo $html('div#gc-header', 0)->parent->getPlainText();


 // Find out how many tags there are which are "ns:tag" or "div", but not
 // "a" and do not have a class attribute

 // echo count($html('(ns|tag, div + !a)[!class]'));


 // Find all paragraph tags which are nested inside a div tag, change
 // their ID attribute and print the new HTML code

 // foreach($html('div p') as $index => $element) 
 // {
 //   $element->id = "id$index";
 // }
 // echo $html;

// Center all the links inside a document which start with "http://"
// and print out the new HTML

// foreach($html('a[href ^= "http://"]') as $element) 
// {
//   $element->wrap('center');
// }
// echo $html;

// Find all odd indexed "td" elements and change the HTML to make them links

// foreach($html('table td:odd') as $element) 
// { 
//   $element->setInnerText('<a href="#">'.$element->getPlainText().'</a>');
// }
// echo $html;

// Beautify the old HTML code and print out the new, formatted code

// dom_format($html, array('attributes_case' => CASE_LOWER));
// echo $html;

// To use a CSS selector query on a node, you simply use the node as a function.
// The result will be stored in an array (of nodes).

$match_array = $node('.myclass');


// To iterate the result, you can use foreach

foreach($match_array as $element) 
{
  echo $element, "<br>\n"; 
}


// The above can be shortened to the following

foreach($node('.myclass') as $element) {

  echo $element, "<br>\n"; 

}


// Because $element is also a node, you can also perform a query on that node
// and nest queries

foreach($node('.myclass') as $element) {

  foreach($element('.myotherclass') as $new_element) {

    echo $new_element, "<br>\n"; 

  }

}

// If you know which element of the array you
// are going to need, you can pass an index to the function

$a = $node('a', 2);

// A negative index will start counting from the end of the array

$a = $node('a', -1);

// Iterate over childnodes

for ($i = 0; $i < $node->childCount(); $i++) {

  echo $node->getChild($i);

}


// Get parent
echo $node->parent;


// Get Siblings
$above = $node->getSibling(-1); //previous node

$beneath = $node->getSibling(1); //next node


// Attributes are very easy to access,
// just access it as if it were an attribute of the object
$href = $node->href;
$id = $node->id;

// Iterate over attributes
foreach($node->attributes as $attribute => $value) {

  echo $attribute, ' = ', $value, "<br>\n"; 

}

// Full Tag

echo $node->tag;

// Tag Type (without namespace)

echo $node->getTag();

// Namespace

echo $node->getNamespace();


// Get namespace of attribute

echo $node->getAttributeNS('href');

// Location

echo $node->dumpLocation();

// Full HTML of node

echo $node->html();

// Inner Text

echo $node->getInnerText();

// Plain Text

echo $node->getPlainText();

// Index of node (in Parent)

echo $node->index();

// Indent

echo $node->indent();


// First/Last child

echo $node->firstChild();

echo $node->lastChild();

//set tag without namespace

$node->setTag('title');

//set tag with namespace

$node->setTag('abc:title', true);

//set namespace

$node->setNamespace('abc');

//set namespace of attribute

$node->setAttributeNS('href', 'abc');

// Attributes are very easy to modify,
// just set it as if it were an attribute of the object

$node->id = 'myid';
$node->class = 'myclass';

//Add/Delete attributes

$node->addAttribute('href', 'www.test.com');
$node->href = 'www.test.com';

$node->deleteAttribute('href');
$node->href = null;

// Wrap node in new node

$node->wrap('center');

$node->wrap($otherNode);

$node->wrapInner('center');

$node->wrapInner($otherNode);

// Delete child

$node->deleteChild(2);

// Change Parent

$node->changeParent($otherNode);

// Detach

$node->detach();

// Detach and move children level up

$node->detach(true);

// Clear

$node->clear();

// Change HTML

$node->setOuterText('<a>New</a>');

$node->setInnerText('<a>New</a>');

$node->setPlainText('New Plain Text');


/*
Default CSS3 selector support:

| Pattern | Meaning | Supported | 
|:------------|:------------|:--------------| 
| * | any element | yes | 
| E | an element of type E | yes | 
| E[foo] | an E element with a "foo" attribute | yes | 
| E[foo="bar"] | an E element whose "foo" attribute value is exactly equal to "bar" | yes | 

| E[foo~="bar"] | an E element whose "foo" attribute value is a list of whitespace-separated values, one of which is exactly equal to "bar" | yes | 
| E[foo^="bar"] | an E element whose "foo" attribute value begins exactly with the string "bar" | yes | 
| E[foo$="bar"] | an E element whose "foo" attribute value ends exactly with the string "bar" | yes |
| E[foo*="bar"] | an E element whose "foo" attribute value contains the substring "bar" | yes | 
| E[foo|="en"] | an E element whose "foo" attribute has a hyphen-separated list of values beginning (from the left) with "en" | yes |
| E:root | an E element, root of the document | yes | 
| E:nth-child(n) | an E element, the n-th child of its parent | yes | 
| E:nth-last-child(n) | an E element, the n-th child of its parent, counting from the last one | yes | 
| E:nth-of-type(n) | an E element, the n-th sibling of its type | yes | 
| E:nth-last-of-type(n) | an E element, the n-th sibling of its type, counting from the last one | yes | 
| E:first-child | an E element, first child of its parent | yes | 
| E:last-child | an E element, last child of its parent | yes | | E:first-of-type | an E element, first sibling of its type | yes | | E:last-of-type | an E element, last sibling of its type | yes | | E:only-child | an E element, only child of its parent | yes | | E:only-of-type | an E element, only sibling of its type | yes | | E:empty | an E element that has no children (including text nodes) | yes | | E:link | | no | | E:visited | an E element being the source anchor of a hyperlink of which the target is not yet visited (:link) or already visited (:visited) | no | | E:active | | no | | E:hover | | no | | E:focus | an E element during certain user actions | no | | E:target | an E element being the target of the referring URI | no | | E:lang(fr) | an element of type E in language "fr" (the document language specifies how language is determined) | yes | | E:enabled | | no | | E:disabled | a user interface element E which is enabled or disabled | no | | E:checked | a user interface element E which is checked (for instance a radio-button or checkbox) | no | | E::first-line | the first formatted line of an E element | no | | E::first-letter | the first formatted letter of an E element | no | | E::before | generated content before an E element | no | | E::after | generated content after an E element | no | | E.warning | an E element whose class is "warning" (the document language specifies how class is determined). | yes | | E#myid | an E element with ID equal to "myid". | yes | | E:not(s) | an E element that does not match selector s | yes | | E F | an F element descendant of an E element | yes | | E > F | an F element child of an E element | yes | | E + F | an F element immediately preceded by an E element | yes | | E ~ F | an F element preceded by an E element | yes |


Added selectors:

Pattern Meaning (!E) an element of type other than E (E, F) an element of type E or F (!E + !F) an element of type other than E and F E[foo!="bar"] an E element whose "foo" attribute value is not equal to "bar" E[foo>="2"] an E element whose "foo" attribute value is bigger than "2" E[foo<="2"] an E element whose "foo" attribute value is smaller than "2" E[foo%="[^123]+"] an E element whose "foo" attribute value matches the regex "[^123]+" E[! foo] an E element without a "foo" attribute E[! foo$="bar"] E[foo, bar] an E element with either a "foo" attribute or a "bar" attribute E[foo="bar", foo="123"] E[foo + bar] an E element with a "foo" attribute and a "bar" attribute E[foo="bar" + bar="123"] E:eq(n) an E element, the n-th child of its parent E:gt(n) an E element, greater than the n-th child of its parent E:lt(n) an E element, lower than the n-th child of its parent E:odd an E element which has an odd index E:even an E element which has an even index E:every(n) every n-th child E element of its parent E:not-empty an E element that children (including text nodes) E:has-text an E element that has text nodes E:no-text an E element that has no text nodes E:contains(t) an E element which contains the text of t E:has(s) an E element which has children that match the selector s E:not(s) an E element that does not match the selector s :element element is an element node (that means no text, comments, doctype, etc.) :text element is a text node *:comment element is a comment node


 */



 ?>