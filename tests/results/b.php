<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['block_b1_slot?id=61d9d558d55df'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot?id=61d9d558d586d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot?id=61d9d558d5bf4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61d9d558d5b87'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b122'] = Parsed::raw('b122', function($data, $slots) {
            extract($data);
            if (isset($slots['b122'])) {
                usort($slots['b122'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b122'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b122']->addSlot('b122', Parsed::template('block_b122_slot?id=61d9d558d5bf4', ['_index' => '0']))->setSlots($slots);
$this->block['b122']->render($data);  
};
Parsed::$templates['block_b12_slot?id=61d9d558d5a7d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><n><?php Parsed::template('b122?id=61d9d558d5b87', [])->setSlots($slots)->render($data); ?></n><?php 
};
Parsed::$templates['b12?id=61d9d558d581b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b12'] = Parsed::raw('b12', function($data, $slots) {
            extract($data);
            if (isset($slots['b12'])) {
                usort($slots['b12'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b12'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61d9d558d586d', ['_index' => '0']))->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61d9d558d5a7d', ['_index' => '1']))->setSlots($slots);
$this->block['b12']->render($data);  
};
Parsed::$templates['b1?id=61d9d558d557a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($slots['b1'])) {
                usort($slots['b1'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61d9d558d55df', ['_index' => '0']))->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('b12?id=61d9d558d581b', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['block_b2_slot?id=61d9d558d61c7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61d9d558d618e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b2'] = Parsed::raw('b2', function($data, $slots) {
            extract($data);
            if (isset($slots['b2'])) {
                usort($slots['b2'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($slots['b2'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b2']->addSlot('b2', Parsed::template('block_b2_slot?id=61d9d558d61c7', ['_index' => '0']))->setSlots($slots);
$this->block['b2']->render($data);  
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><b>
    <?php Parsed::template('b1?id=61d9d558d557a', [])->setSlots($slots)->render($data); ?></b><?php Parsed::template('b2?id=61d9d558d618e', [])->setSlots($slots)->render($data);  
};
Parsed::$templates['block/b_slot_b1?id=61d9d558d6989'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12?id=61d9d558d6ac9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b122></b122><?php 
};
Parsed::$templates['block/b_slot_b122?id=61d9d558d6c36'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1222></b1222><?php 
};
Parsed::$templates['./cases/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html><body><?php $comp0 = Parsed::template('block/b', []);
$comp1 = $comp0->addSlot('b1', Parsed::template('block/b_slot_b1?id=61d9d558d6989', ['_index' => '1.5']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b12', Parsed::template('block/b_slot_b12?id=61d9d558d6ac9', ['_index' => '1.5']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('b122', Parsed::template('block/b_slot_b122?id=61d9d558d6c36', ['_index' => '99']));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};