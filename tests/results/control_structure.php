<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['comp/simple_slot_default?id=61d95e3dc9ec5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
    comp/simple
<?php 
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
    } ?></span>
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
    } ?></div><?php 
};
Parsed::$templates['comp/csf_slot_default?id=61d95e3dcbd8d'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>x2<?php 
};
Parsed::$templates['comp/csf_slot_default?id=61d95e3dcbfc5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>1</p><?php 
};
Parsed::$templates['slot_default?id=61d95e3dccc25'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>compslotdefault</p><?php 
};
Parsed::$templates['slot_default?id=61d95e3dccdde'] = function ($data, $slots) {
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
Parsed::$templates['slot_default?id=61d95e3dccf16'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','comp0','data',])));
     ?><?php 
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);

    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dce18f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61d95e3dce0f4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','comp0','comp1','slots','data',])));
     ?><?php 
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dce18f', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dce4f5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>bar<?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dce49c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dce4f5', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['slot_default?id=61d95e3dce407'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','comp0','comp1','slots','data',])));
     ?><?php 
    foreach ([1,2] as $a) {$comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dce49c', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['comp/csdf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','slots','slot','data','comp0',])));
     ?><?php foreach ([2] as $a) { ?><div class="comp_slot_default">
    <span><?php 
    foreach ([1,2] as $a) {
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dccc25', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    } ?></span>
    <div class=""><?php 
    foreach ([1,2] as $a) {
    if (!empty($slots["slot1"])) {
    foreach ($slots['slot1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dccdde', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dccf16', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dce0f4', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div>
    <?php 
    if (!empty($slots["slot3"])) {
    foreach ($slots['slot3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dce407', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div><?php } ?><?php 
};
Parsed::$templates['slot_default?id=61d95e3dcf7cd'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61d95e3dcfaaf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61d95e3dcfa41'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dcfaaf', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61d95e3dcfd4c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['slot_default?id=61d95e3dcfcd1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn4"])) {
    foreach ($slots['sn4'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dcfd4c', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61d95e3dd0023'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dcffa9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><?php 
    if (!empty($slots["sn5"])) {
    foreach ($slots['sn5'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dd0023', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['slot_default?id=61d95e3dd030c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><?php 
    if (!empty($slots["sn7"])) {
    foreach ($slots['sn7'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dd028f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><?php 
    if (!empty($slots["sn6"])) {
    foreach ($slots['sn6'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dd030c', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['slot_default?id=61d95e3dd0635'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dd057e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><div class="x">
        <?php 
    if (!empty($slots["sn8"])) {
    foreach ($slots['sn8'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dd0635', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dd090a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default?id=61d95e3dd0aa8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
        djdh
        <?php 
};
Parsed::$templates['slot_default?id=61d95e3dd0b56'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dd0a11'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['a','slots','slot','data','comp0',])));
     ?><?php 
    foreach ([1] as $a) {
    if (!empty($slots["sn9"])) {
    foreach ($slots['sn9'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dd0aa8', []);

    $comp0->setSlots($slots);
    $comp0->render($data);$comp0 = Parsed::template('slot_default?id=61d95e3dd0b56', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    }
    } ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d95e3dd0d3b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/cns'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0','comp1',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dcf7cd', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn1"])) {
    foreach ($slots['sn1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dcfa41', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn3"])) {
    foreach ($slots['sn3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d95e3dcfcd1', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dcffa9', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dd028f', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dd057e', ['class' => 'x']));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dd090a', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dd0a11', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d95e3dd0d3b', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/cns_slot_sn?id=61d95e3dd1a4f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['i',])));
     ?><?php for ($i=0;$i<2;$i++) { ?><span class="x"></span><?php } ?><?php 
};
Parsed::$templates['comp/cns_slot_sn1?id=61d95e3dd1baf'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="y"></span><?php 
};
Parsed::$templates['comp/cns_slot_sn3?id=61d95e3dd1c85'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>3</p><?php 
};
Parsed::$templates['comp/cns_slot_sn5?id=61d95e3dd1d7c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/cns_slot_sn8?id=61d95e3dd1e95'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span>8</span><?php 
};
Parsed::$templates['comp/cns_slot_sn9?id=61d95e3dd1f65'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/control_structure'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['array','array_map','true','false','a','comp0','data','comp1','slots',])));
     ?><!DOCTYPE html>
<html><body><?php $array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
 foreach ($array as $a) { ?><div class="x">
    <span></span>
</div><?php } ?>

-----


<?php foreach ($array as $a) { ?><div class="x">
    <?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?></div><?php } ?>

-----


<div class="x">
    <?php 
    foreach ($array as $a) {$comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data);
    } ?></div>

-----


<?php 
    foreach ($array as $a) {$comp0 = Parsed::template('comp/simple', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/simple_slot_default?id=61d95e3dc9ec5', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    } ?>

-----



<?php $comp0 = Parsed::template('comp/c', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/csf', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/csf_slot_default?id=61d95e3dcbd8d', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/csf', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/csf_slot_default?id=61d95e3dcbfc5', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('comp/csdf', []);

    $comp0->render($data); ?>

-----


<?php $comp0 = Parsed::template('comp/cns', []);
$comp1 = $comp0->addSlot('sn', Parsed::template('comp/cns_slot_sn?id=61d95e3dd1a4f', ['class' => 'x']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn1', Parsed::template('comp/cns_slot_sn1?id=61d95e3dd1baf', ['class' => 'y']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn3', Parsed::template('comp/cns_slot_sn3?id=61d95e3dd1c85', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn5', Parsed::template('comp/cns_slot_sn5?id=61d95e3dd1d7c', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn8', Parsed::template('comp/cns_slot_sn8?id=61d95e3dd1e95', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn9', Parsed::template('comp/cns_slot_sn9?id=61d95e3dd1f65', []));

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