<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><div class="comp_slot">
    <span><?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span>
</div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default_61cc2da3ef286'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default_61cc2da3ef71f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>djdh<?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default_61cc2da3f01e6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','slot','comp','data',])));
     ?><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc2da3ef286', []));

    $comp1->setSlots($slots);
    if (!empty($slots["sn9"])) {
    foreach ($slots['sn9'] as $slot) {
    $comp0->addSlot('default', $slot);
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc2da3ef71f', $data);
    $comp->setSlots($slots);
    $comp->render($data);$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc2da3f01e6', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/a_slot_sn9_61cc2da3f063c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('comp/a', []);
$comp1 = $comp0->addSlot('sn9', Parsed::template('comp/a_slot_sn9_61cc2da3f063c', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/a', $data)->render(); ?>