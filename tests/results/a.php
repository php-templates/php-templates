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
Parsed::$templates['comp/comp_slot_slot_default?id=61e318ff7fc8f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default?id=61e318ff7ff0a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
        djdh
        <?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['slot_default?id=61e318ff80055'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','data',])));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e318ff7fe17'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slot','data','slots',])));
      
    if (!empty($this->slots["sn9"])) {
    foreach ($this->slots['sn9'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$this->comp[0] = Parsed::template('slot_default?id=61e318ff7ff0a', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);$this->comp[0] = Parsed::template('slot_default?id=61e318ff80055', []);

    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($data);
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61e318ff8101f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slots','data',])));
      $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e318ff7fc8f', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e318ff7fe17', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61e318ff8101f', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data);  
};
Parsed::$templates['comp/a_slot_sn9?id=61e318ff82116'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['this','slots','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $this->comp[0] = Parsed::template('comp/a', []);
$this->comp[1] = $this->comp[0]->addSlot('sn9', Parsed::template('comp/a_slot_sn9?id=61e318ff82116', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($data); ?>

-----</body></html><?php 
};