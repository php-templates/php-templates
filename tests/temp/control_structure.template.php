@php
$array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
@endphp

<div class="x" p-foreach="$array as $a">
    <span></span>
</div>

-----


<div class="x" p-foreach="$array as $a">
    <template is="comp/simple"></template>
</div>

-----


<div class="x">
    <template is="comp/simple" p-foreach="$array as $a"></template>
</div>

-----


<template is="comp/simple" p-foreach="$array as $a">
    comp/simple
</template>

-----



<template is="comp/c"></template>

-----


<template is="comp/csf">x2</template>

-----


<template is="comp/csf"><p>1</p></template>

-----


<div p-if="$false"></div>
<div p-elseif="$false"></div>
<else p-else></else>

-----


<template is="comp/simple" p-if="$false"></template>
<elseif p-elseif="$true"></elseif>

-----


<div p-foreach="[1, 2] as $a" p-if="$a == 2">{{ $a }}</div>

-----


2<div p-if="$false" p-foreach="[1, 2] as $a" p-if="$a == 2">{{ $a }}</div>

-----
