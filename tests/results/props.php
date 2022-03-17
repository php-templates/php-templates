<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;
Parsed::$templates['props/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['true',]));
     ?> <a true="<?php echo $true; ?>">

</a>

 <?php 
};
Parsed::$templates['props/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['true','_attrs','k','v',]));
     ?> <b true="<?php echo $true; ?>">
    <bind <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>></bind></b>

 <?php 
};
Parsed::$templates['props/c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
      $this->data['val'] = [1,2]; $this->data['name'] = "myname"; ?>

<c>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->data, []));
} ?></c>

 <?php 
};
Parsed::$templates['props/c?slot=default&id=54'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['name','v',]));
      foreach ($val as $v) {  ?><div><?php echo htmlspecialchars($name.$v); ?></div>
<?php }   
};
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
Parsed::$templates['comp/comp_slot?slot=default&id=55'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['name',]));
      echo htmlspecialchars($name);  
};
Parsed::$templates['./temp/props'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['bar','foo',]));
      
$foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = 1;
$false = 0;
?>

<simple bar="$bar" foo="<?php echo $foo; ?>"></simple>

-----

<?php $this->comp[0] = Parsed::template("props/a", ['foo' => '$foo', 'bar' => $bar, 'true' => $true]);  $this->comp[0]->render($this->data); ?>

-----

<?php $this->comp[0] = Parsed::template("props/b", ['false' => '$false', 'foo' => '$foo', 'true' => $true]);  $this->comp[0]->render($this->data); ?>

-----

<?php $this->comp[0] = Parsed::template("props/c", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("props/c?slot=default&id=54", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->data); ?>

-----

<?php $this->comp[0] = Parsed::template("props/c", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot", []));  $this->comp[2] = $this->comp[1]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=55", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->data); ?>

-----

 <?php 
};