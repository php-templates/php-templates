<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['./temp/directives'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['var',]));
      
    $var = 0;
?>

<input type="checkbox" <?php echo 1>$var ? "checked" : ""; ?>>

-----

<input type="checkbox" <?php echo 1<$var ? "checked" : ""; ?>>

-----

 <?php 
};