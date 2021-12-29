<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
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
Parsed::$templates['61cc4f65870f8'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['val','v','name',])));
     ?>
        <?php foreach ($val as $v) { ?><div><?php echo htmlspecialchars($name.$v); ?></div><?php } ?>
    <?php 
};
Parsed::$templates['./cases/props'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['foo','bar','arr','true','false','comp0','data','comp1',])));
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
$comp1 = $comp0->addSlot('default', Parsed::template('61cc4f65870f8', []));

    $comp0->render($data); ?>

-----</body></html><?php 
};
Parsed::template('./cases/props', $data)->render(); ?>