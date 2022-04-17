<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['comp/simple'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp/simple">
    comp/simple
</div>

 <?php };
Parsed::$templates['comp/simple?slot=default&id=51'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> 
    comp/simple
 <?php };
Parsed::$templates['comp/c'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  foreach ([1,2] as $a) {   $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData);  }   foreach ([1,2] as $a) {  ?>
<div class="comp/composed">
    
<?php $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData); ?>
    comp/simple
    <span>
        
<?php foreach ([1,2] as $a) {   $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData);  }  ?>
    </span>
</div>
<?php }   };
Parsed::$templates['comp/csf'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp_slot">
    
<?php for ($i=0;$i<2;$i++) {   foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  }  ?>
</div>

 <?php };
Parsed::$templates['comp/csf?slot=default&id=52'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> x2 <?php };
Parsed::$templates['comp/csf?slot=default&id=53'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <p>1</p> <?php };
Parsed::$templates['./temp/control_structure'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  
$array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
 foreach ($array as $a) {  ?>
<div class="x">
    <span></span>
</div>
<?php }  ?>

-----

<?php foreach ($array as $a) {  ?>
<div class="x">
    
<?php $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData); ?>
</div>
<?php }  ?>

-----

<div class="x">
    
<?php foreach ($array as $a) {   $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData);  }  ?>
</div>

-----

<?php foreach ($array as $a) {   $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/simple?slot=default&id=51", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData);  }  ?>

-----

<?php $this->comp[0] = Parsed::template("comp/c", []);  $this->comp[0]->render($this->scopeData); ?>

-----

<?php $this->comp[0] = Parsed::template("comp/csf", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/csf?slot=default&id=52", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

<?php $this->comp[0] = Parsed::template("comp/csf", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/csf?slot=default&id=53", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

<?php if ($false) {  ?>
<div></div>
<?php }   elseif ($false) {  ?>
<div></div>
<?php }   else {  ?>
<else></else>
<?php }  ?>

-----

<?php if ($false) {   $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData);  }   elseif ($true) {  ?>
<elseif></elseif>
<?php }  ?>

-----

<?php foreach ([1, 2] as $a) { 
if ($a == 2) {  ?>
<div><?php echo htmlspecialchars($a); ?></div>
<?php } 
}  ?>

-----


2

<?php if ($false) { 
foreach ([1, 2] as $a) {  ?>
<div><?php echo htmlspecialchars($a); ?></div>
<?php } 
}  ?>

-----

 <?php };