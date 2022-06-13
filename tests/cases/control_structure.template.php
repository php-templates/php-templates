@php
$array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
@endphp

<div class="x" p-foreach="$array as $a">
    <span></span>
</div>
=====
<div class="x">
    <span></span>
</div>
<div class="x">
    <span></span>
</div>

-----

<div class="x" p-foreach="$array as $a">
    <template is="comp/simple"></template>
</div>
=====
<div class="x">
<div class="comp/simple">
    comp/simple
</div>
</div>
<div class="x">
<div class="comp/simple">
    comp/simple
</div>
</div>

-----

<div class="x">
    <template is="comp/simple" p-foreach="$array as $a"></template>
</div>
=====
<div class="x">
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/simple">
    comp/simple
</div>
</div>

-----

<template is="comp/simple" p-foreach="$array as $a">
    comp/simple
</template>
=====
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/simple">
    comp/simple
</div>

-----

<!-- composed component, lvl1 -->
<template is="comp/c"></template>
=====
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/composed">
    <div class="comp/simple">
        comp/simple
    </div>
    comp/simple
    <span>
        <div class="comp/simple">
            comp/simple
        </div>
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
</div>
<div class="comp/composed">
    <div class="comp/simple">
        comp/simple
    </div>
    comp/simple
    <span>
        <div class="comp/simple">
            comp/simple
        </div>
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
</div>

-----

<template is="comp/csf">x2</template>
=====
<div class="comp_slot">x2x2</div>

-----

<template is="comp/csf"><p>1</p></template>
=====
<div class="comp_slot"><p>1</p><p>1</p></div>

-----

<div p-if="$false"></div>
<div p-elseif="$false"></div>
<else p-else></else>
=====
<else></else>

-----

<template is="comp/simple" p-if="$false"></template>
<elseif p-elseif="$true"></elseif>
=====
<elseif></elseif>

-----

<div p-foreach="[1, 2] as $a" p-if="$a == 2">{{ $a }}</div>
=====
<div>2</div>

-----

2<div p-if="$false" p-foreach="[1, 2] as $a" p-if="$a == 2">{{ $a }}</div>
=====
2

<!-- foreach de block  -->

<!-- if block -->

<!-- foreach de block din block -->