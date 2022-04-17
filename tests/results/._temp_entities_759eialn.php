<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['./temp/entities'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="{phpt} echo $foo {phpt}"></div>

-----

<div class="$foo = $bar" x='""'></div>

©

-----


&lt;

-----

 <?php };