<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
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
Parsed::$templates['slot_def_61c4242f7d4b5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>compslotdefault</p><?php 
};
Parsed::$templates['slot_def_61c4242f7d89d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>slot1<?php 
};
Parsed::$templates['slotOf_61c4242f7dc9e_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slotOf_61c4242f7dedb_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slotOf_61c4242f7e19f_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>bar<?php 
};
Parsed::$templates['slotOf_61c4242f7e401_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>bar<?php 
};
Parsed::$templates['comp/comp_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp','comp0','comp1','comp2',])));
     ?><div class="comp_slot_default">
    <span><?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f7d4b5', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?></span>
    <div class=""><?php 
    if (!empty($slots["slot1"])) {
    foreach ($slots['slot1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f7d89d', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('comp/comp_slot', []);

    $comp0->render($data);
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('slotOf_61c4242f7dc9e_slot_default', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    } ?></div>
    <?php 
    if (!empty($slots["slot3"])) {
    foreach ($slots['slot3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot', []));
$comp2 = $comp1->addSlot('default', Parsed::template('slotOf_61c4242f7e19f_slot_default', []));

    $comp2->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><?php 
};
Parsed::$templates['comp/comp_illegat_slot_in_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><div>
    <?php 
    if (!empty($slots["bar"])) {
    foreach ($slots['bar'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    } ?>
</div><?php 
};
Parsed::$templates['slot_def_61c4242f80b0a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_def_61c4242f80f5a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_def_61c4242f80edd'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f80f5a', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?></span><?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['slot_def_61c4242f81439'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn4"])) {
    foreach ($slots['sn4'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['comp/slot_default_in_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f80b0a', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn1"])) {
    foreach ($slots['sn1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f80edd', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn3"])) {
    foreach ($slots['sn3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f81439', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?>
</div><?php 
};
Parsed::$templates['slot_def_61c4242f83ba5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_def_61c4242f840c3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_def_61c4242f8402c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f840c3', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_def_61c4242f84647'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn4"])) {
    foreach ($slots['sn4'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['slotOf_61c4242f84cee_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><div class="x">
        <?php 
    if (!empty($slots["sn8"])) {
    foreach ($slots['sn8'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    } ?>
    </div><?php 
};
Parsed::$templates['slotOf_61c4242f8517e_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_def_61c4242f85419'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>djdh<?php 
};
Parsed::$templates['slotOf_61c4242f85666_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/nested_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp','comp0','this','comp1',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f83ba5', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn1"])) {
    foreach ($slots['sn1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f8402c', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn3"])) {
    foreach ($slots['sn3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_def_61c4242f84647', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?>
</div><?php $comp0 = Parsed::template('comp/comp_slot', []);

    foreach ($this->slots["sn5"] ?? [] as $slot) {
    $comp0->addSlot('default', $slot);
    }
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);

    foreach ($this->slots["sn6"] ?? [] as $slot) {
    $comp0->addSlot('default', $slot);
    }
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('slotOf_61c4242f84cee_slot_default', ['class' => 'x']));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('slotOf_61c4242f8517e_slot_default', []));

    $comp1->setSlots($slots);
    foreach ($this->slots["sn9"] ?? [] as $slot) {
    $comp0->addSlot('default', $slot);
    }$comp1 = $comp0->addSlot('default', Parsed::template('slotOf_61c4242f85666_slot_default', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['slotOf_61c4242f86a7f_slot_sn'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="x"></span><?php 
};
Parsed::$templates['slotOf_61c4242f86ce2_slot_sn1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="y"></span><?php 
};
Parsed::$templates['slotOf_61c4242f86f14_slot_sn3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>3</p><?php 
};
Parsed::$templates['slotOf_61c4242f8719e_slot_sn8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span>8</span><?php 
};
Parsed::$templates['slotOf_61c4242f873de_slot_sn9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data','comp1','slots',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('comp/comp_slot', []);

    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('comp/comp_slot_default', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/comp_illegat_slot_in_slot', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/slot_default_in_slot_default', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/nested_slot', []);
$comp1 = $comp0->addSlot('sn', Parsed::template('slotOf_61c4242f86a7f_slot_sn', ['class' => 'x']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn1', Parsed::template('slotOf_61c4242f86ce2_slot_sn1', ['class' => 'y']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn3', Parsed::template('slotOf_61c4242f86f14_slot_sn3', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn5', Parsed::template('comp/simple', []));
$comp1 = $comp0->addSlot('sn8', Parsed::template('slotOf_61c4242f8719e_slot_sn8', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn9', Parsed::template('slotOf_61c4242f873de_slot_sn9', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/slot', $data)->render(); ?>