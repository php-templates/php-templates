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
Parsed::$templates['comp/comp_slot_slot_default?id=61d044a102b31'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default?id=61d044a102ee8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
        djdh
        <?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['slot_default?id=61d044a103216'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d044a102d76'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><?php 
    if (!empty($slots["sn9"])) {
    foreach ($slots['sn9'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d044a102ee8', []);

    $comp0->setSlots($slots);
    $comp0->render($data);$comp0 = Parsed::template('slot_default?id=61d044a103216', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d044a105198'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d044a102b31', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d044a102d76', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d044a105198', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/a_slot_sn9?id=61d044a10574f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('comp/a', []);
$comp1 = $comp0->addSlot('sn9', Parsed::template('comp/a_slot_sn9?id=61d044a10574f', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/a', [])->render($data); ?>