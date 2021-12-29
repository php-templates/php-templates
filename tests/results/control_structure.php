<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/simple_slot_default_61cc2da541433'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>comp/simple<?php 
};
Parsed::$templates['comp/c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','comp0','data',])));
     ?><?php 
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }  foreach ([1,2] as $a) { ?><div class="comp/composed">
    <?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?>
    comp/simple
    <span>
        <?php 
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    } ?>
    </span>
</div><?php } ?><?php 
};
Parsed::$templates['comp/csf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['i','slots','slot','data',])));
     ?><div class="comp_slot">
    <?php 
    for ($i=0;$i<2;$i++) {
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    } ?>
</div><?php 
};
Parsed::$templates['comp/csf_slot_default_61cc2da544782'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>x2<?php 
};
Parsed::$templates['comp/csf_slot_default_61cc2da544b0b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>1</p><?php 
};
Parsed::$templates['slot_default_61cc2da545a88'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>compslotdefault</p><?php 
};
Parsed::$templates['slot_default_61cc2da545ec4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>slot1<?php 
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
Parsed::$templates['comp/comp_slot_slot_default_61cc2da5469a7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['comp/comp_slot_slot_default_61cc2da5470a5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>bar<?php 
};
Parsed::$templates['comp/csdf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','slots','slot','data','comp','comp0','comp1','comp2',])));
     ?><?php foreach ([2] as $a) { ?><div class="comp_slot_default">
    <span><?php 
    foreach ([1,2] as $a) {
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc2da545a88', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    }
    } ?></span>
    <div class=""><?php 
    foreach ([1,2] as $a) {
    if (!empty($slots["slot1"])) {
    foreach ($slots['slot1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc2da545ec4', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    }
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);

    $comp0->render($data);
    }
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc2da5469a7', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    }
    } ?></div>
    <?php 
    if (!empty($slots["slot3"])) {
    foreach ($slots['slot3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot', []));
$comp2 = $comp1->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc2da5470a5', []));

    $comp2->setSlots($slots);
    $comp0->render($data);
    }
    } ?>
</div><?php } ?><?php 
};
Parsed::$templates['slot_default_61cc2da548b7c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default_61cc2da548f90'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default_61cc2da548f29'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc2da548f90', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default_61cc2da549421'] = function ($data, $slots) {
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
Parsed::$templates['comp/comp_slot_slot_default_61cc2da549bd4'] = function ($data, $slots) {
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
Parsed::$templates['comp/comp_slot_slot_default_61cc2da54a182'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default_61cc2da54a4ec'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>djdh<?php 
};
Parsed::$templates['comp/comp_slot_slot_default_61cc2da54a7cf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/cns'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp','comp0','comp1','a',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc2da548b7c', $data);
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
    $comp = Parsed::template('slot_default_61cc2da548f29', $data);
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
    $comp = Parsed::template('slot_default_61cc2da549421', $data);
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
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc2da549bd4', ['class' => 'x']));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc2da54a182', []));

    $comp1->setSlots($slots);
    foreach ([1] as $a) {
    if (!empty($slots["sn9"])) {
    foreach ($slots['sn9'] as $slot) {
    $comp0->addSlot('default', $slot);
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc2da54a4ec', $data);
    $comp->setSlots($slots);
    $comp->render($data);$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }
    }$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default_61cc2da54a7cf', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/cns_slot_sn_61cc2da54d07f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="x"></span><?php 
};
Parsed::$templates['comp/cns_slot_sn1_61cc2da54d320'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="y"></span><?php 
};
Parsed::$templates['comp/cns_slot_sn3_61cc2da54d4fe'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>3</p><?php 
};
Parsed::$templates['comp/cns_slot_sn8_61cc2da54d710'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span>8</span><?php 
};
Parsed::$templates['comp/cns_slot_sn9_61cc2da54d8db'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/control_structure'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['array','array_map','true','false','a','comp0','data','comp1','slots','i',])));
     ?><!DOCTYPE html>
<html>
<body><?php $array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
 foreach ($array as $a) { ?><div class="x">
    <span></span>
</div><?php } ?>

-----


<?php foreach ($array as $a) { ?><div class="x">
    <?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?>
</div><?php } ?>

-----


<div class="x">
    <?php 
    foreach ($array as $a) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    } ?>
</div>

-----


<?php 
    foreach ($array as $a) {$comp0 = Parsed::template('comp/simple', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/simple_slot_default_61cc2da541433', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    } ?>

-----



<?php $comp0 = Parsed::template('comp/c', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/csf', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/csf_slot_default_61cc2da544782', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/csf', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/csf_slot_default_61cc2da544b0b', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('comp/csdf', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/cns', []);

    for ($i=0;$i<2;$i++) {$comp1 = $comp0->addSlot('sn', Parsed::template('comp/cns_slot_sn_61cc2da54d07f', ['class' => 'x']));

    $comp1->setSlots($slots);
    }$comp1 = $comp0->addSlot('sn1', Parsed::template('comp/cns_slot_sn1_61cc2da54d320', ['class' => 'y']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn3', Parsed::template('comp/cns_slot_sn3_61cc2da54d4fe', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn5', Parsed::template('comp/simple', []));
$comp1 = $comp0->addSlot('sn8', Parsed::template('comp/cns_slot_sn8_61cc2da54d710', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn9', Parsed::template('comp/cns_slot_sn9_61cc2da54d8db', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----


<?php if ($false) { ?><div></div><?php }  elseif ($false) { ?><div></div><?php }  else { ?><else></else><?php } ?>

-----


<?php 
    if ($true) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }  elseif ($true) { ?><elseif></elseif><?php } ?>

-----


<?php 
    if ($false) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    }  elseif ($true) { ?><elseif></elseif><?php } ?>

-----


<?php foreach ([1, 2] as $a) {  if ($a == 2) { ?><div><?php echo htmlspecialchars($a); ?></div><?php }  } ?>

-----


2<?php if ($false) {  foreach ([1, 2] as $a) { ?><div><?php echo htmlspecialchars($a); ?></div><?php }  } ?>

-----</body></html><?php 
};
Parsed::template('./cases/control_structure', $data)->render(); ?>