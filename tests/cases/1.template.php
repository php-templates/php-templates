<!-- block as direct slot -->
<template is="comp/comp_slot" foo>
    <block name="b1">
        <b11>123</b11>
    </block>
</template>
=====
<div class="comp_slot">
    <span><b11>123</b11></span>
</div>