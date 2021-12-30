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
Parsed::$templates['block_b1_slot_61cd94c34835e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61cd94c34830e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot_61cd94c34835e', array_merge([], []))->setSlots($slots)->setIndex(0);
    if (isset($slots['b1'])) {
    foreach ($slots['b1'] as $slot) {
    $blocks[] = $slot;
    }
    }
    usort($blocks, function($a, $b) {
                $i1 = isset($a->data["_index"]) ? $a->data["_index"] : 0;
                $i2 = isset($b->data["_index"]) ? $b->data["_index"] : 0;
                return $i1 - $i2;
            });
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default_61cd94c348254'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><div>
        <?php Parsed::template('b1?id=61cd94c34830e', [])->setSlots($slots)->render($data); ?>
    </div><?php 
};
Parsed::$templates['./cases/2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cd94c348254', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/2', [])->render($data); ?>