<?php 
$array = [1, 2];
$array_map = ['foo' => 'f1', 'bar' => 'f2'];
$true = true;
$false = false;
?>

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

<!-- slot default csdf -->
<template is="comp/csdf"></template>
=====
<div class="comp_slot_default">
    <span>
        <p>compslotdefault</p>
        <p>compslotdefault</p>
    </span>
    <div class="">slot1slot1</div>
    <div>
        <div class="comp_slot">
            <span></span>
        </div>
        <div class="comp_slot">
            <span></span>
        </div>
    </div>
    <div>
        <div class="comp_slot">
            <span>foo</span>
        </div>
        <div class="comp_slot">
            <span>foo</span>
        </div>
    </div>
    <div class="comp_slot">
        <span>
            <div class="comp_slot">
                <span>bar</span>
            </div>
        </span>
    </div>
    <div class="comp_slot">
        <span>
            <div class="comp_slot">
                <span>bar</span>
            </div>
        </span>
    </div>
</div>

-----

<template is="comp/cns">
    <span class="x" slot="sn" p-for="$i=0;$i<2;$i++"></span>
    <span class="y" slot="sn1"></span>
    <p slot="sn3">3</p>
    <template is="comp/simple" slot="sn5"></template>
    <span slot="sn8">8</span>
    <p slot="sn9">9</p>
</template>
=====
<div class="sdefsdef">
    <span>
        <span class="x"></span>
        <span class="x"></span>
    </span>
</div>
<div class="sdefsdef">
    <span class="y"></span>
</div>
<div class="sdefsdef">
    <p>3</p>
</div>
<div class="comp_slot">
    <span>
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
</div>
<div class="comp_slot">
    <span></span>
</div>
<div class="comp_slot">
    <span>
        <div class="x">
            <span>8</span>
        </div>
    </span>
</div>
<div class="comp_slot">
    <span>
        <p>xjd</p>
            <p>9</p>
        <p>hdhd</p>
    </span>
</div>

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