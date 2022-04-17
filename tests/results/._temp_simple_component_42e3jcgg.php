<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['comp/simple'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp/simple">
    comp/simple
</div>

 <?php };
Parsed::$templates['./temp/simple_component'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };