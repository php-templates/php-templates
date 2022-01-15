<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['./cases/entities'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['foo','bar',])));
     ?><!DOCTYPE html>
<html>
<body><div class="{phpt} echo $foo {phpt}"></div>

-----

>§é&"
<div class="$foo => $bar" x='""'></div>
©

-----


&lt;

-----</body></html><?php 
};