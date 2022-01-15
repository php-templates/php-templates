<div class="comp_slot_default" p-foreach="[2] as $a">
    <span><slot p-foreach="[1,2] as $a"><p>compslotdefault</p></slot></span>
    <div class=""><slot name="slot1" p-foreach="[1,2] as $a">slot1</slot></div>
    <div><slot name="slot2"><template is="comp/comp_slot" p-foreach="[1,2] as $a"></template></slot></div>
    <div><slot name="slot2"><template is="comp/comp_slot" p-foreach="[1,2] as $a">foo</template></slot></div>
    <slot name="slot3"><template is="comp/comp_slot" p-foreach="[1,2] as $a"><template is="comp/comp_slot">bar</template></template></slot>
</div>