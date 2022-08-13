
<block name="b1" p-foreach="[1,2] as $k" :k="$k">
    <b11>{{ $k }}</b11>
</block>

-----


<template is="block/a">
    <a22 slot="a2" _index="99">a22</a22>
</template>

-----


<template is="block/a">
    <a22 slot="a2" p-foreach="[1,2] as $a" _index="99">a22</a22>
</template>

-----



<template is="block/b">
    <b12 slot="b1" _index="2.5"></b12>
    <b122 slot="b12" _index="2.5"></b122>
    <b1222 slot="b122" _index="99"></b1222>
</template>

-----



<template is="comp/comp_slot">
    <block name="b1">
        <b11>123</b11>
    </block>
</template>

-----



<template is="comp/comp_slot">
    <div>
        <block name="b1">
            <b11>123</b11>
        </block>
    </div>
</template>

-----





<block name="b1" p-foreach="[1,2] as $k" :k="$k">
    <template is="comp/simple"></template>
</block>

-----
