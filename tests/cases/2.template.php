<!-- block as indirect slot -->
<component is="comp/comp_slot">
    <div>
        <block name="b1">
            <b11>123</b11>
        </block>
    </div>
</component>
=====
<div class="comp_slot">
    <span>
        <div>
            <b11>123</b11>
        </div>
    </span>
</div>