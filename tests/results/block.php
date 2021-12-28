<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['block_a1_slot_61cb009c16b2f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a11></a11><?php 
};
Parsed::$templates['a1?id=61cb009c16add'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_a1_slot_61cb009c16b2f', []);
    if (isset($slots['a1'])) {
    foreach ($slots['a1'] as $slot) {
    $blocks[] = $slot;
    }
    }
    usort($blocks, function($a, $b) {
            $i1 = isset($a->data["_index"]) ? $a->data["_index"] : 0;
            $i2 = isset($b->data["_index"]) ? $b->data["_index"] : 0;
            return $i1 - $i2;
        })
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['block_a2_slot_61cb009c16fb4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a21></a21><?php 
};
Parsed::$templates['a2?id=61cb009c16f73'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_a2_slot_61cb009c16fb4', []);
    if (isset($slots['a2'])) {
    foreach ($slots['a2'] as $slot) {
    $blocks[] = $slot;
    }
    }
    usort($blocks, function($a, $b) {
            $i1 = isset($a->data["_index"]) ? $a->data["_index"] : 0;
            $i2 = isset($b->data["_index"]) ? $b->data["_index"] : 0;
            return $i1 - $i2;
        })
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['block/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><a>
    <?php Parsed::template('a1?id=61cb009c16add', [])->setSlots($slots)->render($data);  Parsed::template('a2?id=61cb009c16f73', [])->setSlots($slots)->render($data); ?>
</a><?php 
};
Parsed::$templates['block/a_slot_a2_61cb009c17601'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a22>a22</a22><?php 
};
Parsed::$templates['block/a_slot_a2_61cb009c182a3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a22>a22</a22><?php 
};
Parsed::$templates['block_b1_slot_61cb009c19239'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot_61cb009c196c8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot_61cb009c19a14'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61cb009c199d2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b122_slot_61cb009c19a14', []);
    if (isset($slots['b122'])) {
    foreach ($slots['b122'] as $slot) {
    $blocks[] = $slot;
    }
    }
    usort($blocks, function($a, $b) {
            $i1 = isset($a->data["_index"]) ? $a->data["_index"] : 0;
            $i2 = isset($b->data["_index"]) ? $b->data["_index"] : 0;
            return $i1 - $i2;
        })
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['block_b12_slot_61cb009c19933'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><n>
            <?php Parsed::template('b122?id=61cb009c199d2', [])->setSlots($slots)->render($data); ?>
            </n><?php 
};
Parsed::$templates['b12?id=61cb009c19683'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b12_slot_61cb009c196c8', []);
    $blocks[] = Parsed::template('block_b12_slot_61cb009c19933', []);
    if (isset($slots['b12'])) {
    foreach ($slots['b12'] as $slot) {
    $blocks[] = $slot;
    }
    }
    usort($blocks, function($a, $b) {
            $i1 = isset($a->data["_index"]) ? $a->data["_index"] : 0;
            $i2 = isset($b->data["_index"]) ? $b->data["_index"] : 0;
            return $i1 - $i2;
        })
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['b1?id=61cb009c191f0'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot_61cb009c19239', []);
    $blocks[] = Parsed::template('b12?id=61cb009c19683', []);
    if (isset($slots['b1'])) {
    foreach ($slots['b1'] as $slot) {
    $blocks[] = $slot;
    }
    }
    usort($blocks, function($a, $b) {
            $i1 = isset($a->data["_index"]) ? $a->data["_index"] : 0;
            $i2 = isset($b->data["_index"]) ? $b->data["_index"] : 0;
            return $i1 - $i2;
        })
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['block_b2_slot_61cb009c1a356'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61cb009c1a315'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b2_slot_61cb009c1a356', []);
    if (isset($slots['b2'])) {
    foreach ($slots['b2'] as $slot) {
    $blocks[] = $slot;
    }
    }
    usort($blocks, function($a, $b) {
            $i1 = isset($a->data["_index"]) ? $a->data["_index"] : 0;
            $i2 = isset($b->data["_index"]) ? $b->data["_index"] : 0;
            return $i1 - $i2;
        })
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><b>
    <?php Parsed::template('b1?id=61cb009c191f0', [])->setSlots($slots)->render($data); ?>
</b><?php Parsed::template('b2?id=61cb009c1a315', [])->setSlots($slots)->render($data); ?><?php 
};
Parsed::$templates['block/b_slot_b1_61cb009c1aeaf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12_61cb009c1b13c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b122></b122><?php 
};
Parsed::$templates['block/b_slot_b122_61cb009c1b3b9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1222></b1222><?php 
};
Parsed::$templates['./cases/block'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data','a',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('block/a', []);
$comp1 = $comp0->addSlot('a2', Parsed::template('block/a_slot_a2_61cb009c17601', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('block/a', []);

    foreach ([1,2] as $a) {$comp1 = $comp0->addSlot('a2', Parsed::template('block/a_slot_a2_61cb009c182a3', []));

    $comp1->setSlots($slots);
    }
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('block/b', []);
$comp1 = $comp0->addSlot('b1', Parsed::template('block/b_slot_b1_61cb009c1aeaf', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b12', Parsed::template('block/b_slot_b12_61cb009c1b13c', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b122', Parsed::template('block/b_slot_b122_61cb009c1b3b9', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/block', $data)->render(); ?>