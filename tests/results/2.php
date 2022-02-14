<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="comp_slot">
    <span>
<?php  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  ?></span>
</div> <?php 
};
Parsed::$templates['b1?slot=3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <b11>123</b11> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <div>
        
<?php ;
$this->comp[0] = Parsed::template("***block", [])->withName("b1")->setSlots($this->slots);
$this->comp[1] = $this->comp[0]->addSlot("b1", Parsed::template("b1?slot=3", ['_index' => '1'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?></div> <?php 
};
Parsed::$templates['./cases/2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <!DOCTYPE html>
<html><body>
<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=2", []));
$this->comp[0]->render($this->data);
 ?>

-----</body></html> <?php 
};