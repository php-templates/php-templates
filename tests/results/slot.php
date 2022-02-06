<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?><div class="comp_slot">
    <span><?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></span>
</div><?php 
};
Parsed::$templates['comp/comp_slot_default'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?><div class="comp_slot_default">
    <span><?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("default"))) {} ?></span>
    <div class=""><?php foreach ($this->slots("slot1") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("slot1"))) {} ?></div>
    <div><?php foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("slot2"))) {} ?></div>
    <div><?php foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("slot2"))) {} ?></div>
    <?php foreach ($this->slots("slot3") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("slot3"))) {} ?>
</div><?php 
};
Parsed::$templates['comp/comp_illegat_slot_in_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?><div>
    <?php foreach ($this->slots("bar") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("bar"))) {} ?>
</div><?php 
};
Parsed::$templates['comp/slot_default_in_slot_default'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?><div class="sdefsdef">
    <?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("default"))) {} ?>
</div><div class="sdefsdef">
    <?php foreach ($this->slots("sn1") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("sn1"))) {} ?>
</div><div class="sdefsdef">
    <?php foreach ($this->slots("sn3") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("sn3"))) {} ?>
</div><?php 
};
Parsed::$templates[''] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      
};
Parsed::$templates['comp/nested_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?><div class="sdefsdef">
    <?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("default"))) {} ?>
</div><div class="sdefsdef">
    <?php foreach ($this->slots("sn1") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("sn1"))) {} ?>
</div><div class="sdefsdef">
    <?php foreach ($this->slots("sn3") as $_slot) {
$_slot->render(array_merge($this->data, []));
} if (empty($this->slots("sn3"))) {} ?>
</div><?php $this->comp[0] = Parsed::template("comp/comp_slot", []);$this->comp[0]->render($this->data); ?>$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=1", []))<?php foreach ($this->slots("sn5") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}if (empty($this->slots("sn5"))) {} ?>$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=2", []))<?php $this->comp[0] = Parsed::template("comp/comp_slot", []);$this->comp[0]->render($this->data); ?>$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=3", []))<?php foreach ($this->slots("sn6") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}if (empty($this->slots("sn6"))) {} ?>$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=4", []))<?php $this->comp[0] = Parsed::template("comp/comp_slot", []);$this->comp[0]->render($this->data); ?>$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=5", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=6", ['class' => 'x']))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=7", []))<?php $this->comp[0] = Parsed::template("comp/comp_slot", []);$this->comp[0]->render($this->data); ?>$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=8", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=9", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=10", []))<?php foreach ($this->slots("sn9") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}if (empty($this->slots("sn9"))) {} ?>$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=11", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=12", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=13", []))<?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['./cases/slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?><!DOCTYPE html>
<html>
<body><?php $this->comp[0] = Parsed::template("comp/comp_slot", []);$this->comp[0]->render($this->data); ?>

-----



<?php $this->comp[0] = Parsed::template("comp/comp_slot_default", []);$this->comp[0]->render($this->data); ?>

-----


<?php $this->comp[0] = Parsed::template("comp/comp_illegat_slot_in_slot", []);$this->comp[0]->render($this->data); ?>

-----


<?php $this->comp[0] = Parsed::template("comp/slot_default_in_slot_default", []);$this->comp[0]->render($this->data); ?>

-----


<?php $this->comp[0] = Parsed::template("comp/nested_slot", []);$this->comp[0]->render($this->data); ?>$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=14", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=15", ['class' => 'x']))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=16", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=17", ['class' => 'y']))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=18", []))$this->comp[1] = $this->comp[0]->addSlot("sn3", Parsed::template("comp/nested_slot?slot=sn3&id=19", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=20", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/simple", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=21", []))$this->comp[1] = $this->comp[0]->addSlot("sn8", Parsed::template("comp/nested_slot?slot=sn8&id=22", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=23", []))$this->comp[1] = $this->comp[0]->addSlot("sn9", Parsed::template("comp/nested_slot?slot=sn9&id=24", []))$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/nested_slot?slot=default&id=25", []))

-----</body></html><?php 
};