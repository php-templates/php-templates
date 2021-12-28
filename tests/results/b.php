<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['block_b1_slot_61cb20742ac69'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot_61cb20742b17a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot_61cb20742b9a2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61cb20742b8f1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b122_slot_61cb20742b9a2', [])->setIndex(0);
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
Parsed::$templates['block_b12_slot_61cb20742b839'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><n>
            <?php Parsed::template('b122?id=61cb20742b8f1', [])->setSlots($slots)->render($data); ?>
            </n><?php 
};
Parsed::$templates['b12?id=61cb20742b07b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b12_slot_61cb20742b17a', [])->setIndex(0);
    $blocks[] = Parsed::template('block_b12_slot_61cb20742b839', [])->setIndex(1);
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
Parsed::$templates['b1?id=61cb20742abf2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot_61cb20742ac69', [])->setIndex(0);
    $blocks[] = Parsed::template('b12?id=61cb20742b07b', [])->setSlots($slots)->setIndex(1);
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
Parsed::$templates['block_b2_slot_61cb20742c44f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61cb20742c3f3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b2_slot_61cb20742c44f', [])->setIndex(0);
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
    <?php Parsed::template('b1?id=61cb20742abf2', [])->setSlots($slots)->render($data); ?>
</b><?php Parsed::template('b2?id=61cb20742c3f3', [])->setSlots($slots)->render($data); ?><?php 
};
Parsed::$templates['block/b_slot_b1_61cb20742d17f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12_61cb20742d364'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b122 _index="0"></b122><?php 
};
Parsed::$templates['block/b_slot_b122_61cb20742d541'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1222></b1222><?php 
};
Parsed::$templates['./cases/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('block/b', []);
$comp1 = $comp0->addSlot('b1', Parsed::template('block/b_slot_b1_61cb20742d17f', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b12', Parsed::template('block/b_slot_b12_61cb20742d364', ['_index' => '0']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b122', Parsed::template('block/b_slot_b122_61cb20742d541', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/b', $data)->render(); ?>