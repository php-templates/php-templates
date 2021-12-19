<div class="comp/simple">     comp/simple </div>
=====
<div class="comp/simple">
    comp/simple
</div>

-----

<!-- composed component, lvl1 -->
<component is="comp/composed"></component>
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