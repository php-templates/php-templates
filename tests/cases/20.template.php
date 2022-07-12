<!-- cstruct pe block -->
<block name="b1" p-foreach="[1,2] as $k" :k="$k">
    <b11>{{ $k }}</b11>
</block>
=====
<b11>1</b11>
<b11>2</b11>

-----

<template is="block/a">
    <a22 slot="a2" _index="99">a22</a22>
</template>
=====
<a>
    <a11></a11>
    <a21></a21>
    <a22>a22</a22>
</a>
