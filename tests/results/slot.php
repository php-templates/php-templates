<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="comp_slot">
    <span>
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
 ?></span>
</div>

 <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=56'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> foo <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=57'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> bar <?php 
};
Parsed::$templates['comp/comp_slot_default'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="comp_slot_default">
    <span>
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("default"))) {
 ?><p>compslotdefault</p>
<?php ;
}
 ?></span>
    <div class="">
<?php ;
foreach ($this->slots("slot1") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("slot1"))) {
 ?>slot1
<?php ;
}
 ?></div>
    <div>
<?php ;
foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("slot2"))) {
$this->comp[1] = Parsed::template("comp/comp_slot", []);
$this->comp[1]->render($this->data);
}
 ?></div>
    <div>
<?php ;
foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("slot2"))) {
$this->comp[1] = Parsed::template("comp/comp_slot", []);
$this->comp[2] = $this->comp[1]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=56", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));
$this->comp[1]->render($this->data);
}
 ?></div>
    
<?php ;
foreach ($this->slots("slot3") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("slot3"))) {
$this->comp[1] = Parsed::template("comp/comp_slot", []);
$this->comp[2] = $this->comp[1]->addSlot("default", Parsed::template("comp/comp_slot", []));
$this->comp[3] = $this->comp[2]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=57", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));
$this->comp[1]->render($this->data);
}
 ?>
</div>

 <?php 
};
Parsed::$templates['comp/comp_illegat_slot_in_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div>
    
<?php ;
foreach ($this->slots("bar") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("bar"))) {
}
 ?>
</div>

 <?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp/simple">
    comp/simple
</div>

 <?php 
};
Parsed::$templates['comp/slot_default_in_slot_default'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="sdefsdef">
    
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("default"))) {
 ?><span>
<?php ;
foreach ($this->slots("sn") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
 ?></span>
<?php ;
}
 ?>
</div>


<div class="sdefsdef">
    
<?php ;
foreach ($this->slots("sn1") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn1"))) {
 ?><span>
<?php ;
foreach ($this->slots("sn2") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn2"))) {
 ?>foo
<?php ;
}
 ?></span>
<?php ;
}
 ?>
</div>


<div class="sdefsdef">
    
<?php ;
foreach ($this->slots("sn3") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn3"))) {
 ?><span>
<?php ;
foreach ($this->slots("sn4") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn4"))) {
$this->comp[1] = Parsed::template("comp/simple", []);
$this->comp[1]->render($this->data);
}
 ?></span>
<?php ;
}
 ?>
</div>

 <?php 
};
Parsed::$templates['sn5?slot=default&id=58'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> 
<?php ;
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
 ?> <?php 
};
Parsed::$templates['sn6?slot=default&id=59'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> 
<?php ;
foreach ($this->slots("sn7") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
 ?> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=60'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="x">
        
<?php ;
foreach ($this->slots("sn8") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn8"))) {
$this->comp[1] = Parsed::template("comp/simple", []);
$this->comp[1]->render($this->data);
}
 ?>
    </div> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=61'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>xjd</p> <?php 
};
Parsed::$templates['sn9?slot=default&id=62'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> 
        djdh
         <?php 
};
Parsed::$templates['sn9?slot=default&id=63'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> 
<?php ;
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
 ?> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=64'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>hdhd</p> <?php 
};
Parsed::$templates['comp/nested_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="sdefsdef">
    
<?php ;
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("default"))) {
 ?><span>
<?php ;
foreach ($this->slots("sn") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
 ?></span>
<?php ;
}
 ?>
</div>


<div class="sdefsdef">
    
<?php ;
foreach ($this->slots("sn1") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn1"))) {
 ?><span>
<?php ;
foreach ($this->slots("sn2") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn2"))) {
 ?>foo
<?php ;
}
 ?></span>
<?php ;
}
 ?>
</div>


<div class="sdefsdef">
    
<?php ;
foreach ($this->slots("sn3") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn3"))) {
 ?><span>
<?php ;
foreach ($this->slots("sn4") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
if (empty($this->slots("sn4"))) {
$this->comp[1] = Parsed::template("comp/simple", []);
$this->comp[1]->render($this->data);
}
 ?></span>
<?php ;
}
 ?>
</div>


<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot", []);
foreach ($this->slots("sn5") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}
if (empty($this->slots("sn5"))) { ;
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn5?slot=default&id=58", []));
}

$this->comp[0]->render($this->data);
?>


<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot", []);
foreach ($this->slots("sn6") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}
if (empty($this->slots("sn6"))) { ;
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn6?slot=default&id=59", []));
}

$this->comp[0]->render($this->data);
?>


<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=60", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));

$this->comp[0]->render($this->data);
?>


<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=61", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));

foreach ($this->slots("sn9") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}
if (empty($this->slots("sn9"))) { ;
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn9?slot=default&id=62", []));
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn9?slot=default&id=63", []));
}

$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=64", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));

$this->comp[0]->render($this->data);
?>

 <?php 
};
Parsed::$templates['comp/nested_slot?slot=sn&id=65'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <span class="x"></span> <?php 
};
Parsed::$templates['comp/nested_slot?slot=sn1&id=66'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <span class="y"></span> <?php 
};
Parsed::$templates['comp/nested_slot?slot=sn3&id=67'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>3</p> <?php 
};
Parsed::$templates['comp/nested_slot?slot=sn8&id=68'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <span>8</span> <?php 
};
Parsed::$templates['comp/nested_slot?slot=sn9&id=69'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>9</p> <?php 
};
Parsed::$templates['./cases/slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
     ?> <!DOCTYPE html>
<html>
<body>
<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot", []);
$this->comp[0]->render($this->data);
 ?>

-----




<?php ;
$this->comp[0] = Parsed::template("comp/comp_slot_default", []);
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("comp/comp_illegat_slot_in_slot", []);
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("comp/slot_default_in_slot_default", []);
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("comp/nested_slot", []);
$this->comp[1] = $this->comp[0]->addSlot("sn", Parsed::template("comp/nested_slot?slot=sn&id=65", ['slot' => 'sn', '_index' => '0'])->setSlots($this->slots));
$this->comp[1] = $this->comp[0]->addSlot("sn1", Parsed::template("comp/nested_slot?slot=sn1&id=66", ['slot' => 'sn1', '_index' => '0'])->setSlots($this->slots));
$this->comp[1] = $this->comp[0]->addSlot("sn3", Parsed::template("comp/nested_slot?slot=sn3&id=67", ['slot' => 'sn3', '_index' => '0'])->setSlots($this->slots));
$this->comp[1] = $this->comp[0]->addSlot("sn5", Parsed::template("comp/simple", []));
$this->comp[1] = $this->comp[0]->addSlot("sn8", Parsed::template("comp/nested_slot?slot=sn8&id=68", ['slot' => 'sn8', '_index' => '0'])->setSlots($this->slots));
$this->comp[1] = $this->comp[0]->addSlot("sn9", Parsed::template("comp/nested_slot?slot=sn9&id=69", ['slot' => 'sn9', '_index' => '0'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>

-----</body></html> <?php 
};