<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['block_b1_slot?id=61e6f99942d99'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k',]));
     ?><b11><?php echo htmlspecialchars($k); ?></b11><?php 
};
Parsed::$templates['b1?id=61e6f99942cf6'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['k','this','data','slots','a','b','i1','i2','slot',]));
      
    foreach ([1,2] as $k) {$this->block['b1'] = Parsed::raw('b1', function($data, $slots) {
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
$this->block['b1']->addSlot('b1', Parsed::template('block_b1_slot?id=61e6f99942d99', ['k' => $k, '_index' => '1']))->setSlots($slots);
$this->block['b1']->render($data);
    }  
};
Parsed::$templates['./cases/3'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['slots','this',]));
     ?><!DOCTYPE html>
<html><body><?php Parsed::template('b1?id=61e6f99942cf6', [])->setSlots($slots)->render($this->data); ?>

-----</body></html><?php 
};