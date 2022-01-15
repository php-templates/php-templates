<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['extends/parent4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['bind_me','slots','slot','data',])));
     ?><parent4>
    parent4
    <?php echo htmlspecialchars($bind_me);  
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
    <?php echo htmlspecialchars($bind_me);  
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
Parsed::$templates['./cases/5'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['data','comp0',])));
     ?><!DOCTYPE html>
<html>
<body><?php $data['bind_me'] = 'bound';  $comp0 = Parsed::template('extends/c', []);

    $comp0->render($data); ?>

-----</body></html><?php 
};
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