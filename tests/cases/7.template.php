<x-form-group type="checkbox" :options="['o1' => 'A', 'o2' => 'B']"
    name="options"
    label="Options"
    :values="['o1']"
/>
=====
<div class="form-group">
    <label class="form-label">Options</label>
    <label><input type="checkbox" value="1" checked>A</label>
    <label><input type="checkbox" value="1">B</label>
</div>