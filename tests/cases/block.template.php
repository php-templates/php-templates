
<component is="block/a">
    <a22 slot="a2">a22</a22>
</component>
=====
<a>
    <a11></a11>
    <a21></a21>
    <a22>a22</a22>
</a>

-----

<component is="block/a">
    <a22 slot="a2" p-foreach="[1,2] as $a">a22</a22>
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
    <b12 slot="b1"></b12>
    <b122 slot="b12"></b122>
    <b1222 slot="b122"></b1222>
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

<!-- block as direct slot -->

<!-- block as indirect slot -->

<!-- slot in bloc -->

<!-- cstruct pe block -->