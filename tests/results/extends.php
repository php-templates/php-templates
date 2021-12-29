<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['slot_default_61ccae437b2c3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div>123</div><?php 
};
Parsed::$templates['extends/parent'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><parent>
    <?php 
    if (!empty($slots["d1"])) {
    foreach ($slots['d1'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61ccae437b2c3', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    }  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
</parent><?php 
};
Parsed::$templates['extends/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><a>
    <foo></foo>
</a><?php 
};
Parsed::$templates['extends/parent2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['bind_me','slots','slot','data',])));
     ?><parent2>
    <?php echo htmlspecialchars($bind_me); ?>
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
</parent2><?php 
};
Parsed::$templates['extends/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b></b><?php 
};
Parsed::$templates['extends/parent4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['bind_me','slots','slot','data',])));
     ?><parent4>
    parent4
    <?php echo htmlspecialchars($bind_me); ?>
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
</parent4><?php 
};
Parsed::$templates['extends/parent3'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['bind_me','slots','slot','data',])));
     ?><parent3>
    parent3
    <?php echo htmlspecialchars($bind_me); ?>
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
</parent3><?php 
};
Parsed::$templates['extends/c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><b></b><?php 
};
Parsed::$templates['./cases/extends'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><!DOCTYPE html>
<html>
<body><?php $comp0 = Parsed::template('extends/a', []);

    $comp0->render($data); ?>

-----



<?php $data['bind_me'] = 'bound';  $comp0 = Parsed::template('extends/b', []);

    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('extends/c', []);

    $comp0->render($data); ?>

-----</body></html><?php 
};
new DomEvent('rendering', 'extends/a', function($template, $data) {
            $comp = Parsed::template('extends/parent', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
new DomEvent('rendering', 'extends/b', function($template, $data) {
            $comp = Parsed::template('extends/parent2', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
new DomEvent('rendering', 'extends/parent3', function($template, $data) {
            $comp = Parsed::template('extends/parent4', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
new DomEvent('rendering', 'extends/c', function($template, $data) {
            $comp = Parsed::template('extends/parent3', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
Parsed::template('./cases/extends', [])->render($data); ?>