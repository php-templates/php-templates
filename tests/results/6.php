<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['props/c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['data','slots','slot',])));
      $data['val'] = [1,2]; $data['name'] = "myname"; ?><c><?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></c><?php 
};
Parsed::$templates['props/c_slot_default?id=61d9d558c9a21'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['val','v','name',])));
      foreach ($val as $v) { ?><div><?php echo htmlspecialchars($name.$v); ?></div><?php }  
};
Parsed::$templates['./cases/6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html><body><?php $comp0 = Parsed::template('props/c', []);
$comp1 = $comp0->addSlot('default', Parsed::template('props/c_slot_default?id=61d9d558c9a21', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};