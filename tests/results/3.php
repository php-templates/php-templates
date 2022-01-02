<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['block_b1_slot?id=61d18e5ce050b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['k',])));
     ?><b11><?php echo htmlspecialchars($k); ?></b11><?php 
};
Parsed::$templates['b1?id=61d18e5ce032a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['k','blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    foreach ([1,2] as $k) {
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot?id=61d18e5ce050b', array_merge(['k' => $k], []))->setSlots($slots)->setIndex(0);
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
    }
    } ?><?php 
};
Parsed::$templates['./cases/3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php Parsed::template('b1?id=61d18e5ce032a', [])->setSlots($slots)->render($data); ?>

-----</body></html><?php 
};