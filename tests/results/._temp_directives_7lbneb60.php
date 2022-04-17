<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['./temp/directives'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  
    $var = 0;
?>

<input type="checkbox" <?php echo 1>$var ? "checked" : ""; ?>>

-----

<input type="checkbox" <?php echo 1<$var ? "checked" : ""; ?>>

-----

 <?php };