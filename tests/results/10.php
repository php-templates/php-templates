<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/d'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><div class="form-group">
    <textarea class="form-control" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>></textarea></div><?php 
};
Parsed::$templates['./cases/10'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?><!DOCTYPE html>
<html><body><?php $this->comp[0] = Parsed::template('comp/d', ['rows' => '10']);

    $this->comp[0]->render($this->data); ?>

-----</body></html><?php 
};