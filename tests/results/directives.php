<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['./cases/directives'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['var',])));
     ?><!DOCTYPE html>
<html>
<body><?php $var = 0;
?>

<input type="checkbox" <?php echo 1>$var ? "checked" : ""; ?>>

-----


<input type="checkbox" <?php echo 1<$var ? "checked" : ""; ?>>

-----</body></html><?php 
};