<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['block_a1_slot_61cc702d87942'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a11></a11><?php 
};
Parsed::$templates['a1?id=61cc702d87901'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_a1_slot_61cc702d87942', array_merge([], []))->setSlots($slots)->setIndex(0);
    if (isset($slots['a1'])) {
    foreach ($slots['a1'] as $slot) {
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
Parsed::$templates['block_a2_slot_61cc702d87d36'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a21></a21><?php 
};
Parsed::$templates['a2?id=61cc702d87cf6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_a2_slot_61cc702d87d36', array_merge([], []))->setSlots($slots)->setIndex(0);
    if (isset($slots['a2'])) {
    foreach ($slots['a2'] as $slot) {
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
Parsed::$templates['block/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><a>
    <?php Parsed::template('a1?id=61cc702d87901', [])->setSlots($slots)->render($data);  Parsed::template('a2?id=61cc702d87cf6', [])->setSlots($slots)->render($data); ?>
</a><?php 
};
Parsed::$templates['block/a_slot_a2_61cc702d887a1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a22>a22</a22><?php 
};
Parsed::$templates['block/a_slot_a2_61cc702d88cb8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a22>a22</a22><?php 
};
Parsed::$templates['block_b1_slot_61cc702d89f3a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot_61cc702d8a314'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot_61cc702d8a6e5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61cc702d8a68f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b122_slot_61cc702d8a6e5', array_merge([], []))->setSlots($slots)->setIndex(0);
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
Parsed::$templates['block_b12_slot_61cc702d8a5ec'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><n>
            <?php Parsed::template('b122?id=61cc702d8a68f', [])->setSlots($slots)->render($data); ?>
            </n><?php 
};
Parsed::$templates['b12?id=61cc702d8a2bb'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b12_slot_61cc702d8a314', array_merge([], []))->setSlots($slots)->setIndex(0);
    $blocks[] = Parsed::template('block_b12_slot_61cc702d8a5ec', array_merge([], []))->setSlots($slots)->setIndex(1);
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
Parsed::$templates['b1?id=61cc702d89ec6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot_61cc702d89f3a', array_merge([], []))->setSlots($slots)->setIndex(0);
    $blocks[] = Parsed::template('b12?id=61cc702d8a2bb', array_merge([], []))->setSlots($slots)->setIndex(1);
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
Parsed::$templates['block_b2_slot_61cc702d8b10f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61cc702d8b0ad'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b2_slot_61cc702d8b10f', array_merge([], []))->setSlots($slots)->setIndex(0);
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
    <?php Parsed::template('b1?id=61cc702d89ec6', [])->setSlots($slots)->render($data); ?>
</b><?php Parsed::template('b2?id=61cc702d8b0ad', [])->setSlots($slots)->render($data); ?><?php 
};
Parsed::$templates['block/b_slot_b1_61cc702d8bbe9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12_61cc702d8bef6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b122></b122><?php 
};
Parsed::$templates['block/b_slot_b122_61cc702d8c1d1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1222></b1222><?php 
};
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
Parsed::$templates['block_b1_slot_61cc702d8d15a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61cc702d8d102'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot_61cc702d8d15a', array_merge([], []))->setSlots($slots)->setIndex(0);
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
Parsed::$templates['block_b1_slot_61cc702d8d719'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61cc702d8d6cd'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot_61cc702d8d719', array_merge([], []))->setSlots($slots)->setIndex(0);
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
Parsed::$templates['comp/comp_slot_slot_default_61cc702d8d62c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><div>
        <?php Parsed::template('b1?id=61cc702d8d6cd', [])->setSlots($slots)->render($data); ?>
    </div><?php 
};
Parsed::$templates['block_b1_slot_61cc702d8e32d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['k',])));
     ?><b11><?php echo htmlspecialchars($k); ?></b11><?php 
};
Parsed::$templates['b1?id=61cc702d8e2a5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['k','blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    foreach ([1,2] as $k) {
    $blocks = [];
    $blocks[] = Parsed::template('block_b1_slot_61cc702d8e32d', array_merge(['k' => $k], []))->setSlots($slots)->setIndex(0);
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
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['b1?id=61cc702d8e983'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['k','blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    foreach ([1,2] as $k) {
    $blocks = [];
    $blocks[] = Parsed::template('comp/simple', array_merge(['k' => $k], []))->setSlots($slots)->setIndex(0);
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
Parsed::$templates['./cases/block'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data','a',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('block/a', []);
$comp1 = $comp0->addSlot('a2', Parsed::template('block/a_slot_a2_61cc702d887a1', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('block/a', []);

    foreach ([1,2] as $a) {$comp1 = $comp0->addSlot('a2', Parsed::template('block/a_slot_a2_61cc702d88cb8', []));

    $comp1->setSlots($slots);
    }
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('block/b', []);
$comp1 = $comp0->addSlot('b1', Parsed::template('block/b_slot_b1_61cc702d8bbe9', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b12', Parsed::template('block/b_slot_b12_61cc702d8bef6', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b122', Parsed::template('block/b_slot_b122_61cc702d8c1d1', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('b1?id=61cc702d8d102', []));

    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc702d8d62c', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----





<?php Parsed::template('b1?id=61cc702d8e2a5', [])->setSlots($slots)->render($data); ?>

-----



<?php Parsed::template('b1?id=61cc702d8e983', [])->setSlots($slots)->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/block', [])->render($data); ?>