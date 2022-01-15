<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['props/a'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['true',])));
     ?><a true="<?php echo $true ;?>">

</a><?php 
};
Parsed::$templates['props/b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['true','_attrs','k','v',])));
     ?><b true="<?php echo $true ;?>">
    <bind <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>></bind>    
</b><?php 
};
Parsed::$templates['props/c'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['data','slots','slot',])));
     ?><?php $data['val'] = [1,2]; $data['name'] = "myname"; ?><c>
    <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
</c><?php 
};
Parsed::$templates['61d18e5d5512e'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['val','v','name',])));
     ?>
        <?php foreach ($val as $v) { ?><div><?php echo htmlspecialchars($name.$v); ?></div><?php } ?>
    <?php 
};
Parsed::$templates['props/c_slot_default?id=61d18e5d53d17'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','data',])));
     ?><?php $comp0 = Parsed::template('61d18e5d5512e', []);

    $comp0->render($data); ?><?php 
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
Parsed::$templates['comp/comp_slot_slot_default?id=61d18e5d56a93'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['name',])));
     ?><?php echo htmlspecialchars($name); ?><?php 
};
Parsed::$templates['props/c_slot_default?id=61d18e5d559de'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><?php $comp0 = Parsed::template('comp/comp_slot', []);
$comp1 = $comp0->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61d18e5d56a93', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['./cases/props'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['foo','bar','arr','true','false','comp0','data','comp1','slots',])));
     ?><!DOCTYPE html>
<html>
<body><?php $foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = 1;
$false = 0;
?>

<simple bar="$bar" foo="<?php echo $foo ;?>"></simple>

-----



<?php $comp0 = Parsed::template('props/a', ['foo' => '$foo', 'bar' => $bar, 'true' => $true]);

    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('props/b', ['true' => $true, 'false' => '$false', 'foo' => '$foo']);

    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('props/c', []);
$comp1 = $comp0->addSlot('default', Parsed::template('props/c_slot_default?id=61d18e5d53d17', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----



<?php $comp0 = Parsed::template('props/c', []);
$comp1 = $comp0->addSlot('default', Parsed::template('props/c_slot_default?id=61d18e5d559de', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?>

-----</body></html><?php 
};