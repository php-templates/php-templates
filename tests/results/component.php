<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><div class="'comp/simple'">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/composed'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?><template></template><?php $this->comp[0] = Parsed::template("comp/simple", []);$this->comp[1]->render($this->data); ?><div class="'comp/composed'">
    <template></template>
    comp/simple
    <?php $this->comp[0] = Parsed::template("comp/simple", []);$this->comp[1]->render($this->data); ?><span>
        <template></template>
    </span>
</div><?php 
};
Parsed::$templates['./cases/component'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?><!DOCTYPE html>
<html>
<?php $this->comp[0] = Parsed::template("comp/simple", []);$this->comp[1]->render($this->data);  $this->comp[0] = Parsed::template("comp/composed", []);$this->comp[1]->render($this->data); ?><body><template></template>

-----



<template></template>

-----</body></html><?php 
};