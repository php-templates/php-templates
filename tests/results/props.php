<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['props/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><a true="<?php echo $true ;?>">

</a><?php 
};
Parsed::$templates['props/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b true="<?php echo $true ;?>">
    <bind <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>></bind>    
</b><?php 
};
Parsed::$templates['props/c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot',]));
      $this->data['val'] = [1,2]; $this->data['name'] = "myname"; ?><c>
    <?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    } ?>
</c><?php 
};
Parsed::$templates['61fede1b1d098'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['val','v','name',]));
      foreach ($val as $v) { ?><div><?php echo htmlspecialchars($name.$v); ?></div><?php }  
};
Parsed::$templates['props/c_slot_default?id=61fede1b1cf76'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
      $this->comp[0] = Parsed::template('61fede1b1d098', []);

    $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot',]));
     ?><div class="comp_slot">
    <span><?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    } ?></span>
</div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b1d33b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['name',]));
      echo htmlspecialchars($name);  
};
Parsed::$templates['props/c_slot_default?id=61fede1b1d14b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slots',]));
      $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b1d33b', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);  
};
Parsed::$templates['./cases/props'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['foo','bar','arr','true','false','this','slots',]));
     ?><!DOCTYPE html>
<html>
<body><?php $foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = 1;
$false = 0;
?>

<simple bar="$bar" foo="<?php echo $foo ;?>"></simple>

-----



<?php $this->comp[0] = Parsed::template('props/a', ['foo' => '$foo', 'bar' => $bar, 'true' => $true]);

    $this->comp[0]->render($this->data); ?>

-----



<?php $this->comp[0] = Parsed::template('props/b', ['true' => $true, 'false' => '$false', 'foo' => '$foo']);

    $this->comp[0]->render($this->data); ?>

-----



<?php $this->comp[0] = Parsed::template('props/c', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('props/c_slot_default?id=61fede1b1cf76', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----



<?php $this->comp[0] = Parsed::template('props/c', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('props/c_slot_default?id=61fede1b1d14b', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----</body></html><?php 
};