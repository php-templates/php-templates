<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <div class="comp/simple">
    comp/simple
</div>

 <?php 
};
Parsed::$templates['comp/simple?slot=default&id=51'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> 
    comp/simple
 <?php 
};
Parsed::$templates['comp/c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['a','this',]));
     ?> <?php ;
foreach ([1,2] as $a) {
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
}


foreach ([1,2] as $a) {
?>
<div class="comp/composed">
    
<?php ;
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
 ?>
    comp/simple
    <span>
        
<?php ;
foreach ([1,2] as $a) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
} 
 ?>
    </span>
</div>
<?php ;
}
?>

 <?php 
};
Parsed::$templates['comp/csf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['i','this','_slot',]));
     ?> <div class="comp_slot">
    
<?php ;
for ($i=0;$i<2;$i++) { 
foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
}
} 
 ?>
</div>

 <?php 
};
Parsed::$templates['comp/csf?slot=default&id=52'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> x2 <?php 
};
Parsed::$templates['comp/csf?slot=default&id=53'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?> <p>1</p> <?php 
};
Parsed::$templates['./cases/control_structure'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['array','array_map','true','false','a','this',]));
     ?> <!DOCTYPE html>
<html>
<body><?php $array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
?>


<?php ;
foreach ($array as $a) { 
 ?><div class="x">
    <span></span>
</div>
<?php ;
} 
 ?>

-----



<?php ;
foreach ($array as $a) { 
 ?><div class="x">
    
<?php ;
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
 ?>
</div>
<?php ;
} 
 ?>

-----


<div class="x">
    
<?php ;
foreach ($array as $a) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
} 
 ?>
</div>

-----



<?php ;
foreach ($array as $a) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/simple?slot=default&id=51", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
} 
 ?>

-----




<?php ;
$this->comp[0] = Parsed::template("comp/c", []);
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("comp/csf", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/csf?slot=default&id=52", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
$this->comp[0] = Parsed::template("comp/csf", []);
$this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/csf?slot=default&id=53", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));
$this->comp[0]->render($this->data);
 ?>

-----



<?php ;
if ($false) { 
 ?><div></div>
<?php ;
} 

elseif ($false) { 
 ?><div></div>
<?php ;
} 

else { 
 ?><else></else>
<?php ;
} 
 ?>

-----



<?php ;
if ($false) { 
$this->comp[0] = Parsed::template("comp/simple", []);
$this->comp[0]->render($this->data);
} 

elseif ($true) { 
 ?><elseif></elseif>
<?php ;
} 
 ?>

-----



<?php ;
foreach ([1, 2] as $a) { 
if ($a == 2) { 
 ?><div><?php echo htmlspecialchars($a); ?></div>
<?php ;
} 
} 
 ?>

-----


2
<?php ;
if ($false) { 
foreach ([1, 2] as $a) { 
 ?><div><?php echo htmlspecialchars($a); ?></div>
<?php ;
} 
} 
 ?>

-----</body></html> <?php 
};