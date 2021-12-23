<component is="comp/simple" p-foreach="[1,2] as $a"></component>
<div class="comp/composed" p-foreach="[1,2] as $a">
    <component is="comp/simple"></component>
    comp/simple
    <span>
        <component is="comp/simple" p-foreach="[1,2] as $a"></component>
    </span>
</div>