<div class="comp_slot_default" p-foreach="[2] as $a">
    <span><slot p-foreach="[1,2] as $a"><p>compslotdefault</p></slot></span>
    <div class><slot name="slot1" p-foreach="[1,2] as $a">slot1</slot></div>
    <div><slot name="slot2"><tpl is="comp/comp_slot" p-foreach="[1,2] as $a"></tpl></slot></div>
    <div><slot name="slot2"><tpl is="comp/comp_slot" p-foreach="[2,3] as $a">foo</tpl></slot></div>
    <slot name="slot3"><tpl is="comp/comp_slot" p-foreach="[3,4] as $a"><tpl is="comp/comp_slot">bar</tpl></tpl></slot>
</div>