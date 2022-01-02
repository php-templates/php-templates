<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
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
Parsed::$templates['./cases/4'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['data','comp0',])));
     ?><!DOCTYPE html>
<html>
<body><?php $data['bind_me'] = 'bound';  $comp0 = Parsed::template('extends/b', []);

    $comp0->render($data); ?>

-----</body></html><?php 
};
new DomEvent('rendering', 'extends/b', function($template, $data) {
            $comp = Parsed::template('extends/parent2', $data);
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });