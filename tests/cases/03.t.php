<div>
    <slot name="slot2">
        <tpl is="comp/comp_slot" p-foreach="[1,2] as $a"></tpl>
    </slot>
</div>
=====
<div>
    <div class="comp_slot">
        <span></span>
    </div>
    <div class="comp_slot">
        <span></span>
    </div>
</div>