<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp/simple">
    comp/simple
</div> <?php 
};
Parsed::$templates['comp/simple?slot=default&id=1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> comp/simple <?php 
};
Parsed::$templates['comp/c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this',]));
     ?> <?php ;foreach ([1,2] as $a) {$this->comp[0] = Parsed::template("comp/simple", []);$this->comp[0]->render($this->data);}?><?php ; foreach ([1,2] as $a) {?><div class="comp/composed">
    
<?php ;
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
 ?>
    comp/simple
    <span>
        
<?php ; foreach ([1,2] as $a) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data); } 
 ?></span>
</div><?php ;} ; ?> <?php 
};
Parsed::$templates['comp/csf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['i','this','_slot',]));
     ?> <div class="comp_slot">
     for ($i=0;$i<2;$i++) { 
 foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  } </div> <?php 
};
Parsed::$templates['comp/csf?slot=default&id=2'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> x2 <?php 
};
Parsed::$templates['comp/csf?slot=default&id=3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>1</p> <?php 
};
Parsed::$templates['comp/csdf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this','_slot',]));
     ?> <?php ; foreach ([2] as $a) {?><div class="comp_slot_default">
    <span> foreach ([1,2] as $a) { 
 foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("default"))) {
; ?><p>compslotdefault</p>SimpleNode
<?php ;
}  } </span>
    <div class=""> foreach ([1,2] as $a) { 
 foreach ($this->slots("slot1") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("slot1"))) {
; ?>slot1SimpleNode
<?php ;
}  } </div>
    <div>
<?php  foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("slot2"))) {Component
}  ?></div>
    <div>
<?php  foreach ($this->slots("slot2") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("slot2"))) {Component
}  ?></div>
    
<?php  foreach ($this->slots("slot3") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("slot3"))) {Component
}  ?></div><?php ;} ; ?> <?php 
};
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div class="comp_slot">
    <span>
<?php  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  ?></span>
</div> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot',]));
     ?> <div>
        
<?php  foreach ($this->slots("sn8") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("sn8"))) {Component
}  ?></div> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=5'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>xjd</p> <?php 
};
Parsed::$templates['comp/comp_slot?slot=default&id=6'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>hdhd</p> <?php 
};
Parsed::$templates['comp/cns'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','_slot','a',]));
     ?> <div class="sdefsdef">
    
<?php  foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("default"))) {
; ?><span>
<?php  foreach ($this->slots("sn") as $_slot) {
$_slot->render(array_merge($this->data, []));
}  ?></span>SimpleNode
<?php ;
}  ?></div><div class="sdefsdef">
    
<?php  foreach ($this->slots("sn1") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("sn1"))) {
; ?><span>
<?php  foreach ($this->slots("sn2") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("sn2"))) {
; ?>fooSimpleNode
<?php ;
}  ?></span>SimpleNode
<?php ;
}  ?></div><div class="sdefsdef">
    
<?php  foreach ($this->slots("sn3") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("sn3"))) {
; ?><span>
<?php  foreach ($this->slots("sn4") as $_slot) {
$_slot->render(array_merge($this->data, []));
} 
if (empty($this->slots("sn4"))) {Component
}  ?></span>SimpleNode
<?php ;
}  ?></div><?php ;$this->comp[0] = Parsed::template("comp/comp_slot", []);foreach ($this->slots("sn5") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}if (empty($this->slots("sn5"))) {Component}Slot$this->comp[0]->render($this->data);?><?php ;$this->comp[0] = Parsed::template("comp/comp_slot", []);foreach ($this->slots("sn6") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}if (empty($this->slots("sn6"))) {Slot}Slot$this->comp[0]->render($this->data);?><?php ;$this->comp[0] = Parsed::template("comp/comp_slot", []);$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=4", ['class' => 'x']));SimpleNode$this->comp[0]->render($this->data);?><?php ;$this->comp[0] = Parsed::template("comp/comp_slot", []);$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=5", []));SimpleNodeforeach ([1] as $a) {foreach ($this->slots("sn9") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}if (empty($this->slots("sn9"))) {; ?>djdhSimpleNode<?php ;Component}Slot}$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=6", []));SimpleNode$this->comp[0]->render($this->data);?> <?php 
};
Parsed::$templates['comp/cns?slot=sn&id=7'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <span></span> <?php 
};
Parsed::$templates['comp/cns?slot=sn1&id=8'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <span></span> <?php 
};
Parsed::$templates['comp/cns?slot=sn3&id=9'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>3</p> <?php 
};
Parsed::$templates['comp/cns?slot=sn8&id=10'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <span>8</span> <?php 
};
Parsed::$templates['comp/cns?slot=sn9&id=11'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>9</p> <?php 
};
Parsed::$templates['./cases/control_structure'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['array','array_map','true','false','a','this','i',]));
     ?> <!DOCTYPE html>
<html><body><?php $array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
?>

<?php ; foreach ($array as $a) {  ?><div class="x">
    <span></span>
</div><?php ; } ; ?>

-----


<?php ; foreach ($array as $a) {  ?><div class="x">
    
<?php ;
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
 ?></div><?php ; } ; ?>

-----


<div class="x">
    
<?php ; foreach ($array as $a) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data); } 
 ?></div>

-----



<?php ; foreach ($array as $a) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/simple?slot=default&id=1", []));SimpleNode
$this->comp[0]->render($this->data); } 
 ?>

-----




<?php ;
$this->comp[0] = Parsed::template("comp/c", []);
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("comp/csf", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/csf?slot=default&id=2", []));SimpleNode
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("comp/csf", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/csf?slot=default&id=3", []));SimpleNode
$this->comp[0]->render($this->data);
 ?>

-----




<?php ;
$this->comp[0] = Parsed::template("comp/csdf", []);
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("comp/cns", []); for ($i=0;$i<2;$i++) { 
$this->comp[1] = $this->comp[0]->addSlot("sn", Parsed::template("comp/cns?slot=sn&id=7", ['class' => 'x']));SimpleNode } 
$this->comp[1] = $this->comp[0]->addSlot("sn1", Parsed::template("comp/cns?slot=sn1&id=8", ['class' => 'y']));SimpleNode
$this->comp[1] = $this->comp[0]->addSlot("sn3", Parsed::template("comp/cns?slot=sn3&id=9", []));SimpleNode
$this->comp[1] = $this->comp[0]->addSlot("sn5", Parsed::template("comp/simple", []));Component
$this->comp[1] = $this->comp[0]->addSlot("sn8", Parsed::template("comp/cns?slot=sn8&id=10", []));SimpleNode
$this->comp[1] = $this->comp[0]->addSlot("sn9", Parsed::template("comp/cns?slot=sn9&id=11", []));SimpleNode
$this->comp[0]->render($this->data);
 ?>

-----


<?php ; if ($false) {  ?><div></div><?php ; } ; elseif ($false) {  ?><div></div><?php ; } ; else {  ?><else></else><?php ; } ; ?>

-----



<?php ; if ($false) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data); } 
 elseif ($true) {  ?><elseif></elseif><?php ; } ; ?>

-----


<?php ; foreach ([1, 2] as $a) {  if ($a == 2) {  ?><div><?php echo htmlspecialchars($a); ?></div><?php ; }  } ; ?>

-----


2<?php ; if ($false) {  foreach ([1, 2] as $a) {  ?><div><?php echo htmlspecialchars($a); ?></div><?php ; }  } ; ?>

-----</body></html> <?php 
};