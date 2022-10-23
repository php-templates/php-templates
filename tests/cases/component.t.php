<tpl is="comp/simple"></tpl>
=====
<div class="comp/simple">
    comp/simple
</div>

-----

<!-- composed component, lvl1 -->
<tpl is="comp/composed"></tpl>
=====
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/composed">
    <div class="comp/simple">
        comp/simple
    </div>
    comp/simple
    <span>
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
</div>