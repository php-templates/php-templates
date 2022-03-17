<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['./temp/entities'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['foo','bar',]));
     ?> <div class="{phpt} echo $foo {phpt}"></div>

-----

<div class="$foo = $bar" x='""'></div>

©

-----


&lt;

-----

 <?php 
};