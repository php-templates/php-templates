<div class="comp_slot_default">
    <span><slot><p>compslotdefault</p></slot></span>
    <div class=""><slot name="slot1">slot1</slot></div>
    <div><slot name="slot2"><tpl is="comp/comp_slot"></tpl></slot></div>
    <div><slot name="slot2"><tpl is="comp/comp_slot">foo</tpl></slot></div>
    <slot name="slot3"><tpl is="comp/comp_slot"><tpl is="comp/comp_slot">bar</tpl></tpl></slot>
</div>