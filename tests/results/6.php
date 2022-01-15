<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['props/c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['data','this','slot',])));
      $data['val'] = [1,2]; $data['name'] = "myname"; ?><c>
    <?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
</c><?php 
};
Parsed::$templates['props/c_slot_default?id=61e31e42c1ef2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['val','v','name',])));
      foreach ($val as $v) { ?><div><?php echo htmlspecialchars($name.$v); ?></div><?php }  
};
Parsed::$templates['./cases/6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $this->comp[0] = Parsed::template('props/c', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('props/c_slot_default?id=61e31e42c1ef2', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data); ?>

-----</body></html><?php 
};