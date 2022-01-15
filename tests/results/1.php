<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data',])));
     ?><div class="comp_slot">
    <span><?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span>
</div><?php 
};
Parsed::$templates['block_b1_slot?id=61e31e422880e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b11>123</b11><?php 
};
Parsed::$templates['b1?id=61e31e422878e'] = function ($data, $slots) {
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
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61e31e422880e', ['_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e31e4227f8d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','data',])));
      Parsed::template('b1?id=61e31e422878e', [])->setSlots($slots)->render($data);  
};
Parsed::$templates['./cases/1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e31e4227f8d', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data); ?>

-----</body></html><?php 
};