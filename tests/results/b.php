<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['block_b1_slot?id=61e6f9996b568'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b11></b11><?php 
};
Parsed::$templates['block_b12_slot?id=61e6f9996b794'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b121></b121><?php 
};
Parsed::$templates['block_b122_slot?id=61e6f9996b984'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b1221></b1221><?php 
};
Parsed::$templates['b122?id=61e6f9996b933'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b122'] = Parsed::raw('b122', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b122'])) {
                usort($this->slots['b122'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b122'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b122']->addSlot('b122', Parsed::template('block_b122_slot?id=61e6f9996b984', ['_index' => '1']))->setSlots($slots);
$this->block['b122']->render($data);  
};
Parsed::$templates['block_b12_slot?id=61e6f9996b8bf'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
     ?><n><?php Parsed::template('b122?id=61e6f9996b933', [])->setSlots($slots)->render($this->data); ?></n><?php 
};
Parsed::$templates['b12?id=61e6f9996b75f'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b12'] = Parsed::raw('b12', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b12'])) {
                usort($this->slots['b12'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b12'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61e6f9996b794', ['_index' => '1']))->setSlots($slots);
$this->block['b12']->addSlot('b12', Parsed::template('block_b12_slot?id=61e6f9996b8bf', ['_index' => '2']))->setSlots($slots);
$this->block['b12']->render($data);  
};
Parsed::$templates['b1?id=61e6f9996b51c'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b1'])) {
                usort($this->slots['b1'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b1'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61e6f9996b568', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->addSlot('b1', Parsed::template('b12?id=61e6f9996b75f', ['_index' => '2']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['block_b2_slot?id=61e6f9996be68'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b21></b21><?php 
};
Parsed::$templates['b2?id=61e6f9996be31'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','data','slots','a','b','i1','i2','slot',]));
      $this->block['b2'] = Parsed::raw('b2', function($data, $slots) {
            extract($data);
            if (isset($this->slots['b2'])) {
                usort($this->slots['b2'], function($a, $b) {
                    $i1 = isset($a->attrs['_index']) ? $a->attrs['_index'] : 0;
                    $i2 = isset($b->attrs['_index']) ? $b->attrs['_index'] : 0;
                    return $i1 - $i2;
                });
                foreach ($this->slots['b2'] as $slot) {
                    $slot->render($data);
                }
            }
        })->setSlots($slots);
$this->block['b2']->addSlot('b2', Parsed::template('block_b2_slot?id=61e6f9996be68', ['_index' => '1']))->setSlots($slots);
$this->block['b2']->render($data);  
};
Parsed::$templates['block/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
     ?><b>
    <?php Parsed::template('b1?id=61e6f9996b51c', [])->setSlots($slots)->render($this->data); ?></b><?php Parsed::template('b2?id=61e6f9996be31', [])->setSlots($slots)->render($this->data);  
};
Parsed::$templates['block/b_slot_b1?id=61e6f9996c6e4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b12></b12><?php 
};
Parsed::$templates['block/b_slot_b12?id=61e6f9996c853'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b122></b122><?php 
};
Parsed::$templates['block/b_slot_b122?id=61e6f9996ca06'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b1222></b1222><?php 
};
Parsed::$templates['./cases/b'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slots',]));
     ?><!DOCTYPE html>
<html><body><?php $this->comp[0] = Parsed::template('block/b', []);
$this->comp[1] = $this->comp[0]->addSlot('b1', Parsed::template('block/b_slot_b1?id=61e6f9996c6e4', ['_index' => '2.5']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('b12', Parsed::template('block/b_slot_b12?id=61e6f9996c853', ['_index' => '2.5']));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('b122', Parsed::template('block/b_slot_b122?id=61e6f9996ca06', ['_index' => '99']));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----</body></html><?php 
};