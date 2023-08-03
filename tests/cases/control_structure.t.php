{% $array = [1, 2] %}
{% $array_map = ['foo' => 'f1', 'bar' => 'f2'] %}
{% $true = true %}
{% $false = false %}

<div class="x" p-foreach="$array as $a">
    <span></span>
</div>
=====
<div class="x">
    <span></span>
</div>
<div class="x">
    <span></span>
</div>

-----

<div class="x" p-foreach="$array as $a">
    <tpl is="comp/simple"></tpl>
</div>
=====
<div class="x">
<div class="comp/simple">
    comp/simple
</div>
</div>
<div class="x">
<div class="comp/simple">
    comp/simple
</div>
</div>

-----

<div class="x">
    <tpl is="comp/simple" p-foreach="$array as $a"></tpl>
</div>
=====
<div class="x">
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/simple">
    comp/simple
</div>
</div>

-----

<tpl is="comp/simple" p-foreach="$array as $a">
    comp/simple
</tpl>
=====
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/simple">
    comp/simple
</div>

-----

<!-- composed component, lvl1 -->
<tpl is="comp/c"></tpl>
=====
<div class="comp/simple">
    comp/simple
</div>
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
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
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
        <div class="comp/simple">
            comp/simple
        </div>
    </span>
</div>

-----

<tpl is="comp/csf">x2</tpl>
=====
<div class="comp_slot">x2x2</div>

-----

<tpl is="comp/csf"><p>1</p></tpl>
=====
<div class="comp_slot"><p>1</p><p>1</p></div>

-----

<div p-if="$false"></div>
<div p-elseif="$false"></div>
<else p-else></else>
=====
<else></else>

-----

<tpl is="comp/simple" p-if="$false"></tpl>
<elseif p-elseif="$true"></elseif>
=====
<elseif></elseif>

-----

<div p-foreach="[1, 2] as $a" p-if="$a == 2">{{ $a }}</div>
=====
<div>2</div>

-----

2<div p-if="$false && $a == 2" p-foreach="[1, 2] as $a">{{ $a }}</div>
=====
2

<!-- foreach de block  -->

<!-- if block -->

<!-- foreach de block din block -->