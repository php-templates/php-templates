<?php 
$foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = 1;
$false = 0;
?>

<simple :foo="$foo" bar="$bar"></simple>

-----



<template is="props/a" foo="$foo" :bar="$bar" :true="$true"></template>

-----



<template is="props/b" :true="$true" false="$false" foo="$foo"></template>

-----



<template is="props/c">
    <template>
        <div p-foreach="$val as $v">{{ $name.$v }}</div>
    </template>
</template>

-----



<template is="props/c">
    <template is="comp/comp_slot">{{ $name }}</template>
</template>

-----
