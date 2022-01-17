<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['./cases/entities'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['foo','bar',]));
     ?><!DOCTYPE html>
<html><body><div class="{phpt} echo $foo {phpt}"></div>

-----

>§é&"
<div class="$foo => $bar" x='""'></div>
©

-----


&lt;

-----</body></html><?php 
};