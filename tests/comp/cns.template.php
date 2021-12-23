<div class="sdefsdef">
    <slot><span><slot name="sn"></slot></span></slot>
</div>

<div class="sdefsdef">
    <slot name="sn1"><span><slot name="sn2">foo</slot></span></slot>
</div>

<div class="sdefsdef">
    <slot name="sn3"><span><slot name="sn4"><component is="comp/simple"></component></slot></span></slot>
</div>

<component is="comp/comp_slot">
    <slot name="sn5">
        <component is="comp/simple"></component>
    </slot>
</component>

<component is="comp/comp_slot">
    <slot name="sn6">
        <slot name="sn7"></slot>
    </slot>
</component>

<component is="comp/comp_slot">
    <div class="x">
        <slot name="sn8">
            <component is="comp/simple"></component>
        </slot>
    </div>
</component>

<component is="comp/comp_slot">
    <p>xjd</p>
    <slot name="sn9" p-foreach="[1] as $a">
        djdh
        <component is="comp/simple"></component>
    </slot>
    <p>hdhd</p>
</component>
