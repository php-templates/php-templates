
<component is="block/a">
    <a22 slot="a2" _index="99">a22</a22>
</component>
=====
<a>
    <a11></a11>
    <a21></a21>
    <a22>a22</a22>
</a>

-----

<component is="block/a">
    <a22 slot="a2" p-foreach="[1,2] as $a" _index="99">a22</a22>
</component>
=====
<a>
    <a11></a11>
    <a21></a21>
    <a22>a22</a22>
    <a22>a22</a22>
</a>

-----

<!-- block in block la infinit -->
<component is="block/b">
    <b12 slot="b1" _index="1.5"></b12>
    <b122 slot="b12" _index="1.5"></b122>
    <b1222 slot="b122" _index="99"></b1222>
</component>
=====
<b>
    <b11></b11>
    <b12></b12>
    <b121></b121>
    <b122></b122>
    <n>
        <b1221></b1221>
        <b1222></b1222>
    </n>
</b>
<b21></b21>

-----

<!-- block as direct slot -->
<component is="comp/comp_slot">
    <block name="b1">
        <b11>123</b11>
    </block>
</component>
=====
<div class="comp_slot">
    <span><b11>123</b11></span>
</div>

-----

<!-- block as indirect slot -->
<component is="comp/comp_slot">
    <div>
        <block name="b1">
            <b11>123</b11>
        </block>
    </div>
</component>
=====
<div class="comp_slot">
    <span>
        <div>
            <b11>123</b11>
        </div>
    </span>
</div>

-----

<!-- slot in bloc --- nu am nevoie... de ce as face asta -->

<!-- cstruct pe block -->
<block name="b1" p-foreach="[1,2] as $k" :k="$k">
    <b11>{{ $k }}</b11>
</block>
=====
<b11>1</b11>
<b11>2</b11>

-----

<!-- component as block item -->
<block name="b1" p-foreach="[1,2] as $k" :k="$k">
    <component is="comp/simple"></component>
</block>
=====
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/simple">
    comp/simple
</div>