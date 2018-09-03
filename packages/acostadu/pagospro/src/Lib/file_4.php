<?php 
namespace fub;

include 'file_1.php';
//include 'file_2.php';
//include 'file_3.php';
use foo;
use bar as canine;
use animate;

echo \foo\Cat::says(). "<br />\n";
//echo \canine\Dog::says(). "<br />\n";
//echo \animate\Animal::breathes(). "<br />\n";  

?>