<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><div class="comp_slot">
    <span>
<?php</span>
</div><?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      
};
Parsed::$templates['b1?slot=2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      
};
Parsed::$templates['b1?slot=3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?slot=4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      
};
Parsed::$templates['comp/comp_slot?slot=default&id=5'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      
};
Parsed::$templates['./cases/1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?><!DOCTYPE html>
<html>
<body>
<?php $this->comp[0] = Parsed::template("comp/comp_slot", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=1", []));
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("***block", [])->withName("b1")->setSlots($this->slots));
$this->comp[2] = $this->comp[1]->addSlot("b1", Parsed::template("b1?slot=2", []));
$this->comp[2] = $this->comp[1]->addSlot("b1", Parsed::template("b1?slot=3", []));
$this->comp[2] = $this->comp[1]->addSlot("b1", Parsed::template("b1?slot=4", []));
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=5", []));
$this->comp[0]->render($this->data); ?>

-----</body></html><?php 
};