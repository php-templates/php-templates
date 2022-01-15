<template is="comp/simple" p-foreach="[1,2] as $a"></template>
<div class="comp/composed" p-foreach="[1,2] as $a">
    <template is="comp/simple"></template>
    comp/simple
    <span>
        <template is="comp/simple" p-foreach="[1,2] as $a"></template>
    </span>
</div>