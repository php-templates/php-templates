<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['./cases/chars'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['foo','bar',])));
     ?><!DOCTYPE html>
<html><body><div class="{phpt} echo $foo {phpt}"></div>

-----


<div class="$foo => $bar"></div>

-----


&lt;

-----</body></html><?php 
};