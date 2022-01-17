<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['./cases/directives'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['var',]));
     ?><!DOCTYPE html>
<html><body><?php $var = 0;
?><input type="checkbox" <?php echo 1>$var ? "checked" : ""; ?>>

-----


<input type="checkbox" <?php echo 1<$var ? "checked" : ""; ?>>

-----</body></html><?php 
};