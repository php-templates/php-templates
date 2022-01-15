<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['block_b1_slot?id=61e31e43b7412'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot?id=61e31e43b7661'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot?id=61e31e43b78db'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61e31e43b7888'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b122'] = Parsed::raw('b122', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b122'])) {
                usort($this->slots['b122'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b122'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b122']->addSlot('b122', Parsed::template('block_b122_slot?id=61e31e43b78db', ['_index' => '1']))->setSlots($slots);
$this->block['b122']->render($data);  
};
Parsed::$templates['block_b12_slot?id=61e31e43b77c3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><n>
            <?php Parsed::template('b122?id=61e31e43b7888', [])->setSlots($slots)->render($data); ?>
            </n><?php 
};
Parsed::$templates['b12?id=61e31e43b75fd'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b12'] = Parsed::raw('b12', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b12'])) {
                usort($this->slots['b12'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b12'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61e31e43b7661', ['_index' => '1']))->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61e31e43b77c3', ['_index' => '2']))->setSlots($slots);
$this->block['b12']->render($data);  
};
Parsed::$templates['b1?id=61e31e43b73b5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b1'])) {
                usort($this->slots['b1'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61e31e43b7412', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('b12?id=61e31e43b75fd', ['_index' => '2']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['block_b2_slot?id=61e31e43b7f21'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61e31e43b7ed1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data','slots','a','b','i1','i2','slot',])));
      $this->block['b2'] = Parsed::raw('b2', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b2'])) {
                usort($this->slots['b2'], function($a, $b) {
                    $i1 = isset($a->data['_index']) ? $a->data['_index'] : 0;
                    $i2 = isset($b->data['_index']) ? $b->data['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b2'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b2']->addSlot('b2', Parsed::template('block_b2_slot?id=61e31e43b7f21', ['_index' => '1']))->setSlots($slots);
$this->block['b2']->render($data);  
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
     ?><b>
    <?php Parsed::template('b1?id=61e31e43b73b5', [])->setSlots($slots)->render($data); ?>
</b><?php Parsed::template('b2?id=61e31e43b7ed1', [])->setSlots($slots)->render($data);  
};
Parsed::$templates['block/b_slot_b1?id=61e31e43b8ba3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12?id=61e31e43b8d27'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b122></b122><?php 
};
Parsed::$templates['block/b_slot_b122?id=61e31e43b8e86'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b1222></b1222><?php 
};
Parsed::$templates['./cases/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $this->comp[0] = Parsed::template('block/b', []);
$this->comp[1] = $this->comp[0]->addSlot('b1', Parsed::template('block/b_slot_b1?id=61e31e43b8ba3', ['_index' => '2.5']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('b12', Parsed::template('block/b_slot_b12?id=61e31e43b8d27', ['_index' => '2.5']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('b122', Parsed::template('block/b_slot_b122?id=61e31e43b8e86', ['_index' => '99']));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data); ?>

-----</body></html><?php 
};