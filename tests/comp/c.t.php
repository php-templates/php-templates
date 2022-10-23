<tpl is="comp/simple" p-foreach="[1,2] as $a"></tpl>
<div class="comp/composed" p-foreach="[1,2] as $a">
    <tpl is="comp/simple"></tpl>
    comp/simple
    <span>
        <tpl is="comp/simple" p-foreach="[1,2] as $a"></tpl>
    </span>
</div>