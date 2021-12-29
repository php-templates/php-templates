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
Parsed::$templates['slot_default_61cc70304a666'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>compslotdefault</p><?php 
};
Parsed::$templates['slot_default_61cc70304aacd'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>slot1<?php 
};
Parsed::$templates['comp/comp_slot_slot_default_61cc70304b0d3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['comp/comp_slot_slot_default_61cc70304b646'] = function ($data, $slots) {
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
    $comp = Parsed::template('slot_default_61cc70304a666', $data);
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
    $comp = Parsed::template('slot_default_61cc70304aacd', $data);
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
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc70304b0d3', []));

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
$comp2 = $comp1->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc70304b646', []));

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
Parsed::$templates['slot_default_61cc70304ecd6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default_61cc70304f96f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default_61cc70304f869'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc70304f96f', $data);
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
Parsed::$templates['slot_default_61cc70305067b'] = function ($data, $slots) {
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
    $comp = Parsed::template('slot_default_61cc70304ecd6', $data);
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
    $comp = Parsed::template('slot_default_61cc70304f869', $data);
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
    $comp = Parsed::template('slot_default_61cc70305067b', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?>
</div><?php 
};
Parsed::$templates['slot_default_61cc703054600'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default_61cc7030554d2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default_61cc703055284'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc7030554d2', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default_61cc703056162'] = function ($data, $slots) {
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
Parsed::$templates['comp/comp_slot_slot_default_61cc7030569d6'] = function ($data, $slots) {
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
Parsed::$templates['comp/comp_slot_slot_default_61cc703057739'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default_61cc703058276'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>djdh<?php 
};
Parsed::$templates['comp/comp_slot_slot_default_61cc703058579'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/nested_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp','comp0','comp1',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc703054600', $data);
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
    $comp = Parsed::template('slot_default_61cc703055284', $data);
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
    $comp = Parsed::template('slot_default_61cc703056162', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?>
</div><?php $comp0 = Parsed::template('comp/comp_slot', []);

    if (!empty($slots["sn5"])) {
    foreach ($slots['sn5'] as $slot) {
    $comp0->addSlot('default', $slot);
    }
    }
    else  {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);

    if (!empty($slots["sn6"])) {
    foreach ($slots['sn6'] as $slot) {
    $comp0->addSlot('default', $slot);
    }
    }
    else  {
    }
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc7030569d6', ['class' => 'x']));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc703057739', []));

    $comp1->setSlots($slots);
    if (!empty($slots["sn9"])) {
    foreach ($slots['sn9'] as $slot) {
    $comp0->addSlot('default', $slot);
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc703058276', $data);
    $comp->setSlots($slots);
    $comp->render($data);$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc703058579', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn_61cc70305c01f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="x"></span><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn1_61cc70305c3ff'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="y"></span><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn3_61cc70305c6c5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>3</p><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn8_61cc70305d4e1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span>8</span><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn9_61cc70305df3a'] = function ($data, $slots) {
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
$comp1 = $comp0->addSlot('sn', Parsed::template('comp/nested_slot_slot_sn_61cc70305c01f', ['class' => 'x']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn1', Parsed::template('comp/nested_slot_slot_sn1_61cc70305c3ff', ['class' => 'y']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn3', Parsed::template('comp/nested_slot_slot_sn3_61cc70305c6c5', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn5', Parsed::template('comp/simple', []));
$comp1 = $comp0->addSlot('sn8', Parsed::template('comp/nested_slot_slot_sn8_61cc70305d4e1', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn9', Parsed::template('comp/nested_slot_slot_sn9_61cc70305df3a', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/slot', [])->render($data); ?>