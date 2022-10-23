<div class="sdefsdef">
    <slot><span><slot name="sn"></slot></span></slot>
</div>

<div class="sdefsdef">
    <slot name="sn1"><span><slot name="sn2">foo</slot></span></slot>
</div>

<div class="sdefsdef">
    <slot name="sn3"><span><slot name="sn4"><tpl is="comp/simple"></tpl></slot></span></slot>
</div>

<tpl is="comp/comp_slot">
    <slot name="sn5">
        <tpl is="comp/simple"></tpl>
    </slot>
</tpl>

<tpl is="comp/comp_slot">
    <slot name="sn6">
        <slot name="sn7"></slot>
    </slot>
</tpl>

<tpl is="comp/comp_slot">
    <div class="x">
        <slot name="sn8">
            <tpl is="comp/simple"></tpl>
        </slot>
    </div>
</tpl>

<tpl is="comp/comp_slot">
    <p>xjd</p>
    <slot name="sn9">
        djdh
        <tpl is="comp/simple"></tpl>
    </slot>
    <p>hdhd</p>
</tpl>
