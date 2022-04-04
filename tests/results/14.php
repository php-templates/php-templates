<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp_slot">
    <span>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></span>
</div>

 <?php };
Parsed::$templates['comp/comp_slot?slot=default&id=14'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> foo <?php };
Parsed::$templates['comp/comp_slot?slot=default&id=15'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> bar <?php };
Parsed::$templates['comp/csdf'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  foreach ([2] as $a) {  ?>
<div class="comp_slot_default">
    <span>
<?php foreach ([1,2] as $a) {   foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("default"))) { ?><p>compslotdefault</p>
<?php }  }  ?></span>
    <div class="">
<?php foreach ([1,2] as $a) {   foreach ($this->slots("slot1") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("slot1"))) { ?>slot1
<?php }  }  ?></div>
    <div>
<?php foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("slot2"))) {  foreach ([1,2] as $a) {   $this->comp[1] = Parsed::template("comp/comp_slot", []);  $this->comp[1]->render($this->scopeData);  }   } ?></div>
    <div>
<?php foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("slot2"))) {  foreach ([2,3] as $a) {   $this->comp[1] = Parsed::template("comp/comp_slot", []);  $this->comp[2] = $this->comp[1]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=14", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[1]->render($this->scopeData);  }   } ?></div>
    
<?php foreach ($this->slots("slot3") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("slot3"))) {  foreach ([3,4] as $a) {   $this->comp[1] = Parsed::template("comp/comp_slot", []);  $this->comp[2] = $this->comp[1]->addSlot("default", Parsed::template("comp/comp_slot", []));  $this->comp[3] = $this->comp[2]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=15", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[1]->render($this->scopeData);  }   } ?></div>
<?php }   };
Parsed::$templates['./temp/14'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/csdf", []);  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };