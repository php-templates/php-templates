<?php 
$foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = true;
$false = false;
?>

<simple :foo="$foo" bar="$bar"></simple>
=====
<simple foo="foo" bar="$bar"></simple>