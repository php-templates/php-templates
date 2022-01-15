<?php 
$foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = 1;
$false = 0;
?>

<simple :foo="$foo" bar="$bar"></simple>
=====
<simple bar="$bar" foo="foo"></simple>

-----

<!-- component with extra props -->
<template is="props/a" foo="$foo" :bar="$bar" :true="$true"></template>
=====
<a true="1"></a>

-----

<!-- bindings in component -->
<template is="props/b" :true="$true" false="$false" foo="$foo"></template>
=====
<b true="1"><bind false="$false" foo="$foo"></bind></b>

-----

<!-- bind from slot to surface -->
<template is="props/c">
    <template>
        <div p-foreach="$val as $v">{{ $name.$v }}</div>
    </template>
</template>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>

-----

<!-- bind data to a component slot -->
<template is="props/c">
    <template is="comp/comp_slot">{{ $name }}</template>
</template>
=====
<c>
    <div class="comp_slot">
        <span>myname</span>
    </div>
</c>