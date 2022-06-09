
<block name="b1" p-foreach="[1,2] as $k" :k="$k">
    <b11>{{ $k }}</b11>
</block>

-----


<template is="block/a">
    <a22 slot="a2" _index="99">a22</a22>
</template>

-----
