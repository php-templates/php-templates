<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp_slot">
    <span>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></span>
</div>

 <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=14'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> foo <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=15'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> bar <?php 
};
Parsed::$templates['comp/csdf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      foreach ([2] as $a) {  ?>
<div class="comp_slot_default">
    <span>
<?php foreach ([1,2] as $a) {   foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  if (empty($this->slots("default"))) { ?><p>compslotdefault</p>
<?php }  }  ?></span>
    <div class="">
<?php foreach ([1,2] as $a) {   foreach ($this->slots("slot1") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  if (empty($this->slots("slot1"))) { ?>slot1
<?php }  }  ?></div>
    <div>
<?php foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  if (empty($this->slots("slot2"))) {  foreach ([1,2] as $a) {   $this->comp[1] = Parsed::template("comp/comp_slot", []);  $this->comp[1]->render($this->data);  }   } ?></div>
    <div>
<?php foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  if (empty($this->slots("slot2"))) {  foreach ([2,3] as $a) {   $this->comp[1] = Parsed::template("comp/comp_slot", []);  $this->comp[2] = $this->comp[1]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=14", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[1]->render($this->data);  }   } ?></div>
    
<?php foreach ($this->slots("slot3") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  if (empty($this->slots("slot3"))) {  foreach ([3,4] as $a) {   $this->comp[1] = Parsed::template("comp/comp_slot", []);  $this->comp[2] = $this->comp[1]->addSlot("default", Parsed::template("comp/comp_slot", []));  $this->comp[3] = $this->comp[2]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=15", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[1]->render($this->data);  }   } ?></div>
<?php }   
};
Parsed::$templates['./temp/14'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->comp[0] = Parsed::template("comp/csdf", []);  $this->comp[0]->render($this->data); ?>

-----

 <?php 
};