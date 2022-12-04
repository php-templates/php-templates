<div class="foo" :class="['bar' => 1]" p-bind="['class' => 'baz']" p-bind="['class' => 'bam']" @class="'ba'" p-raw="1 ? 'checked' : ''" p-raw="1 ? 'yes' : ''"></div>
=====
<div class="foo bar" @class="'ba'" checked yes></div>

-----

<x-form-group :label="'y'" class="foo" type="text" id="theid" value="123" p-bind="['label' => 'mylabel', 'value' => 1]" p-raw="1 ? 'checked' : ''" p-raw="1 ? 'yes' : ''" disabled/>
=====
<div class="form-group foo">
    <label class="form-label">y</label>
    <input type="text" class="form-control" placeholder="y" id="theid" value="123" checked yes disabled>
</div>