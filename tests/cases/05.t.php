<div class="foo" :class="['bar' => 1]" p-bind="['class' => 'baz']" p-bind="['class' => 'bam']" @class="'ba'" p-raw="1 ? 'checked' : ''" p-raw="1 ? 'yes' : ''"></div>
=====
<div class="foo bar baz bam" @class="'ba'" checked yes></div>

-----

<x-form-group :label="'y'" class="foo" @type="'text'" @id="'theid'" @value="123" p-bind="['label' => 'mylabel', 'value' => 1]" p-raw="1 ? 'checked' : ''" p-raw="1 ? 'yes' : ''"/>
=====
<div class="form-group foo">
    <label class="form-label">mylabel</label>
    <input type="text" class="form-control" id="theid" value="123" placeholder="mylabel">
</div>