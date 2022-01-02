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
Parsed::$templates['slot_default?id=61d18e5d5eb2f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>compslotdefault</p><?php 
};
Parsed::$templates['slot_default?id=61d18e5d5ed17'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>slot1<?php 
};
Parsed::$templates['slot_default?id=61d18e5d5eed1'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/comp_slot', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d5f177'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61d18e5d5f117'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d5f177', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d5f46c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>bar<?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d5f403'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d5f46c', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['slot_default?id=61d18e5d5f398'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d5f403', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><div class="comp_slot_default">
    <span><?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d5eb2f', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span>
    <div class=""><?php 
    if (!empty($slots["slot1"])) {
    foreach ($slots['slot1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d5ed17', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d5eed1', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div>
    <div><?php 
    if (!empty($slots["slot2"])) {
    foreach ($slots['slot2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d5f117', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></div>
    <?php 
    if (!empty($slots["slot3"])) {
    foreach ($slots['slot3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d5f398', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><?php 
};
Parsed::$templates['slot_default?id=61d18e5d60ca0'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?><?php 
};
Parsed::$templates['comp/comp_illegat_slot_in_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><div>
    <?php 
    if (!empty($slots["bar"])) {
    foreach ($slots['bar'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d60ca0', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><?php 
};
Parsed::$templates['slot_default?id=61d18e5d62570'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61d18e5d62cc2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61d18e5d62b87'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d62cc2', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['slot_default?id=61d18e5d633ea'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['slot_default?id=61d18e5d632a8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn4"])) {
    foreach ($slots['sn4'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d633ea', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['comp/slot_default_in_slot_default'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d62570', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn1"])) {
    foreach ($slots['sn1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d62b87', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn3"])) {
    foreach ($slots['sn3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d632a8', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><?php 
};
Parsed::$templates['slot_default?id=61d18e5d663aa'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><span><?php 
    if (!empty($slots["sn"])) {
    foreach ($slots['sn'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61d18e5d668a7'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>foo<?php 
};
Parsed::$templates['slot_default?id=61d18e5d667bd'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn2"])) {
    foreach ($slots['sn2'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d668a7', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61d18e5d66e33'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['slot_default?id=61d18e5d66d2e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><span><?php 
    if (!empty($slots["sn4"])) {
    foreach ($slots['sn4'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d66e33', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?></span><?php 
};
Parsed::$templates['slot_default?id=61d18e5d673e6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d672e0'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><?php 
    if (!empty($slots["sn5"])) {
    foreach ($slots['sn5'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d673e6', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['slot_default?id=61d18e5d678f8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><?php 
    if (!empty($slots["sn7"])) {
    foreach ($slots['sn7'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d67811'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><?php 
    if (!empty($slots["sn6"])) {
    foreach ($slots['sn6'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d678f8', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['slot_default?id=61d18e5d67f51'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d67d9b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><div class="x">
        <?php 
    if (!empty($slots["sn8"])) {
    foreach ($slots['sn8'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d67f51', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
    </div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d6841b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default?id=61d18e5d6867e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>
        djdh
        <?php 
};
Parsed::$templates['slot_default?id=61d18e5d687b6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d68582'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0',])));
     ?><?php 
    if (!empty($slots["sn9"])) {
    foreach ($slots['sn9'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d6867e', []);

    $comp0->setSlots($slots);
    $comp0->render($data);$comp0 = Parsed::template('slot_default?id=61d18e5d687b6', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d68af6'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/nested_slot'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0','comp1',])));
     ?><div class="sdefsdef">
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d663aa', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn1"])) {
    foreach ($slots['sn1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d667bd', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><div class="sdefsdef">
    <?php 
    if (!empty($slots["sn3"])) {
    foreach ($slots['sn3'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('slot_default?id=61d18e5d66d2e', []);

    $comp0->setSlots($slots);
    $comp0->render($data);
    } ?>
</div><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d672e0', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d67811', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d67d9b', []));

    $comp1->setSlots($slots);
    $comp0->render($data);  $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d6841b', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d68582', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d68af6', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn?id=61d18e5d6a477'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="x"></span><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn1?id=61d18e5d6a61f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span class="y"></span><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn3?id=61d18e5d6a7ab'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><p>3</p><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn5?id=61d18e5d6a906'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('comp/simple', []);

    $comp0->render($data); ?><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn8?id=61d18e5d6ab43'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><span>8</span><?php 
};
Parsed::$templates['comp/nested_slot_slot_sn9?id=61d18e5d6acf0'] = function ($data, $slots) {
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
$comp1 = $comp0->addSlot('sn', Parsed::template('comp/nested_slot_slot_sn?id=61d18e5d6a477', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn1', Parsed::template('comp/nested_slot_slot_sn1?id=61d18e5d6a61f', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn3', Parsed::template('comp/nested_slot_slot_sn3?id=61d18e5d6a7ab', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn5', Parsed::template('comp/nested_slot_slot_sn5?id=61d18e5d6a906', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn8', Parsed::template('comp/nested_slot_slot_sn8?id=61d18e5d6ab43', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('sn9', Parsed::template('comp/nested_slot_slot_sn9?id=61d18e5d6acf0', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};