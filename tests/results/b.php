<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['block_b1_slot_61cc2da43e6b4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot_61cc2da43e902'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot_61cc2da43eb37'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61cc2da43eb08'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b122_slot_61cc2da43eb37', [])->setSlots($slots)->setIndex(0);
    if (isset($slots['b122'])) {
    foreach ($slots['b122'] as $slot) {
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
Parsed::$templates['block_b12_slot_61cc2da43eab6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><n>
            <?php Parsed::template('b122?id=61cc2da43eb08', [])->setSlots($slots)->render($data); ?>
            </n><?php 
};
Parsed::$templates['b12?id=61cc2da43e8d7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b12_slot_61cc2da43e902', [])->setSlots($slots)->setIndex(0);
    $blocks[] = Parsed::template('block_b12_slot_61cc2da43eab6', [])->setSlots($slots)->setIndex(1);
    if (isset($slots['b12'])) {
    foreach ($slots['b12'] as $slot) {
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
Parsed::$templates['b1?id=61cc2da43e66a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot_61cc2da43e6b4', [])->setSlots($slots)->setIndex(0);
    $blocks[] = Parsed::template('b12?id=61cc2da43e8d7', [])->setSlots($slots)->setIndex(1);
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
Parsed::$templates['block_b2_slot_61cc2da43f11b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61cc2da43f0f1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b2_slot_61cc2da43f11b', [])->setSlots($slots)->setIndex(0);
    if (isset($slots['b2'])) {
    foreach ($slots['b2'] as $slot) {
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
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><b>
    <?php Parsed::template('b1?id=61cc2da43e66a', [])->setSlots($slots)->render($data); ?>
</b><?php Parsed::template('b2?id=61cc2da43f0f1', [])->setSlots($slots)->render($data); ?><?php 
};
Parsed::$templates['block/b_slot_b1_61cc2da43fc54'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12_61cc2da43fe63'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b122></b122><?php 
};
Parsed::$templates['block/b_slot_b122_61cc2da440047'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1222></b1222><?php 
};
Parsed::$templates['./cases/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('block/b', []);
$comp1 = $comp0->addSlot('b1', Parsed::template('block/b_slot_b1_61cc2da43fc54', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b12', Parsed::template('block/b_slot_b12_61cc2da43fe63', ['_index' => '0']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b122', Parsed::template('block/b_slot_b122_61cc2da440047', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/b', $data)->render(); ?>