<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['props/c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot',]));
      $this->data['val'] = [1,2]; $this->data['name'] = "myname"; ?><c><?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    } ?></c><?php 
};
Parsed::$templates['props/c_slot_default?id=61e6f9995516d'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['val','v','name',]));
      foreach ($val as $v) { ?><div><?php echo htmlspecialchars($name.$v); ?></div><?php }  
};
Parsed::$templates['./cases/6'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slots',]));
     ?><!DOCTYPE html>
<html><body><?php $this->comp[0] = Parsed::template('props/c', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('props/c_slot_default?id=61e6f9995516d', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----</body></html><?php 
};