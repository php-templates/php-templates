@php
$foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = 1;
$false = 0;
@endphp

<!-- bindings in component -->
yoy
<template is="props/b" :true="$true" @false="'$false'" @foo="'$foo'"></template>
=====
yoy
<b true="1"><bind false="$false" foo="$foo"></bind></b>

-----

<simple :foo="$foo" bar="$bar"></simple>
=====
<simple foo="foo" bar="$bar"></simple>

-----

<!-- component with extra props -->
<template is="props/a" foo="$foo" :bar="$bar" :true="$true"></template>
=====
<a true="1"></a>

-----

<!-- bind from slot to surface -->
<template is="props/c" p-scope="$s">
    <template>
        <div p-foreach="$s->val as $v">{{ $s->name.$v }}</div>
    </template>
</template>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>