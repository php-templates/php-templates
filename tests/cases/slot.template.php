<!-- empty slot -->
<component is="comp/comp_slot"></component>
=====
<div class="comp_slot">
    <span></span>
</div>

-----

<!-- slot default -->
<component is="comp/comp_slot_default"></component>
=====
<div class="comp_slot_default">
    <span><p>compslotdefault</p></span>
    <div class="">slot1</div>
    <div>
        <div class="comp_slot">
            <span></span>
        </div>
    </div>
    <div>
        <div class="comp_slot">
            <span>foo</span>
        </div>
    </div>
    <div class="comp_slot">
        <span>
            <div class="comp_slot">
                <span>bar</span>
            </div>
        </span>
    </div>
</div>

-----

<component is="comp/comp_illegat_slot_in_slot"></component>
=====
<div></div>

-----

<component is="comp/slot_default_in_slot_default"></component>
=====
<div class="sdefsdef">
    <span></span>
</div>
<div class="sdefsdef">
    <span>foo</span>
</div>
<div class="sdefsdef">
    <span>
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
</div>

-----

<component is="comp/nested_slot">
    <span class="x" slot="sn"></span>
    <span class="y" slot="sn1"></span>
    <p slot="sn3"></p>
    <component is="comp/simple" slot="sn5"></component>
    <span slot="sn8">8</span>
    <p slot="sn9">9</p>
</component>
=====
<div class="sdefsdef">
    <span><span class="x"></span></span>
</div>
<div class="sdefsdef">
    <span class="y"></span>
</div>
<div class="sdefsdef">
    <p>3</p>
</div>
<div class="comp_slot">
    <span>
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
</div>
<div class="comp_slot">
    <span></span>
</div>
<div class="comp_slot">
    <span>
        <div class="x"><span>8</span></div>
    </span>
</div>
<div class="comp_slot">
    <span>
        <p>xjd</p>
            <p>9</p>
        <p>hdhd</p>
    </span>
</div>