<tpl is="cases2:cfg2-1"></tpl>
<x-form-group type="text" label="x" value="y"></x-form-group>
=====
<div mydirective="2">
    <div mydirective="2">
        <div class="comp_slot cases2">
            <span>
                <div class="form-group cases2">
                    <label class="form-label">x</label>
                    <input type="text" class="form-control" value="y" placeholder="x">
                </div>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="form-label">x</label>
    <input type="text" class="form-control" placeholder="x" value="y">
</div>