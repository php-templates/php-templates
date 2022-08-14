<div class="comp_slot_default">
    <span><slot><p>compslotdefault</p></slot></span>
    <div class=""><slot name="slot1">slot1</slot></div>
    <div><slot name="slot2"><template is="comp/comp_slot"></template></slot></div>
    <div><slot name="slot2"><template is="comp/comp_slot">foo</template></slot></div>
    <slot name="slot3"><template is="comp/comp_slot"><template is="comp/comp_slot">bar</template></template></slot>
</div>