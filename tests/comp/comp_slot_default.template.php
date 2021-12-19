<div class="comp_slot_default">
    <span><slot><p>compslotdefault</p></slot></span>
    <div class=""><slot name="slot1">slot1</slot></div>
    <div><slot name="slot2"><component is="comp/comp_slot"></component></slot></div>
    <div><slot name="slot2"><component is="comp/comp_slot">foo</component></slot></div>
    <slot name="slot3"><component is="comp/comp_slot"><component is="comp/comp_slot">bar</component></component></slot>
</div>