<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot',]));
     ?><div class="comp_slot">
    <span><?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    } ?></span>
</div><?php 
};
Parsed::$templates['block_b1_slot?id=61fede1b11830'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61fede1b1181e'] = function ($data, $slots) {
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
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61fede1b11830', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b11694'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
      Parsed::template('b1?id=61fede1b1181e', [])->setSlots($slots)->render($this->data);  
};
Parsed::$templates['./cases/1'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slots',]));
     ?><!DOCTYPE html>
<html>
<body><?php $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b11694', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----</body></html><?php 
};