<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['comp/d'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="form-group">
    <textarea class="form-control" <?php foreach($this->attrs as $k=>$v) echo "$k=\"$v\" "; ?>></textarea>
</div>

 <?php };
Parsed::$templates['./temp/10'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/d", ['rows' => '10']);  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };