<!-- empty slot -->
<template is="comp/comp_slot"></template>
=====
<div class="comp_slot">
    <span></span>
</div>

-----

<!-- slot default -->
<template is="comp/comp_slot_default"></template>
=====
<div class="comp_slot_default">
    <span><p>compslotdefault</p></span>
    <div class>slot1</div>
    <div>
        <div class="comp_slot">
            <span></span>
        </div>
    </div>
    <div>
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
</div>

-----

<template is="comp/slot_default_in_slot_default"></template>
=====
<div class="sdefsdef">
    <span></span>
</div>
<div class="sdefsdef">
    <span>foo</span>
</div>
<div class="sdefsdef">
    <span>
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
</div>

-----

<template is="comp/nested_slot">
    <span class="x" slot="sn"></span>
    <span class="y" slot="sn1"></span>
    <p slot="sn3">3</p>
    <template is="comp/simple" slot="sn5"></template>
    <span slot="sn8">8</span>
    <p slot="sn9">9</p>
</template>
=====
<div class="sdefsdef">
    <span><span class="x"></span></span>
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