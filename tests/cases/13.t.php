
<tpl is="comp/cns">
    <span class="x" slot="sn" p-foreach="[0,1] as $i"></span>
    <span class="y" slot="sn1"></span>
    <p slot="sn3">3</p>
    <tpl is="comp/simple" slot="sn5"></tpl>
    <span slot="sn8">8</span>
    <p slot="sn9">9</p>
</tpl>
=====
<div class="sdefsdef">
    <span>
        <span class="x"></span>
        <span class="x"></span>
    </span>
</div>
<div class="sdefsdeff">
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
        <div class="x">
            <span>8</span>
        </div>
    </span>
</div>
<div class="comp_slot">
    <span>
        <p>xjd</p>
            <p>9</p>
        <p>hdhd</p>
    </span>
</div>