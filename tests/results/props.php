<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['./cases/props'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['foo','bar','arr','true','false',])));
     ?><!DOCTYPE html>
<html>
<body><?php $foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = true;
$false = false;
?>

<simple bar="$bar" foo="<?php echo $foo ;?>"></simple>

-----</body></html><?php 
};
Parsed::template('./cases/props', $data)->render(); ?>