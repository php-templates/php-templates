<!-- multi-extends -->
<template is="extends/c" :bind_me="'bound'"></template>
=====
<parent4>
    parent4
    bound
    <parent3>
        parent3
        bound
        <b></b>
    </parent3>
</parent4>

-----
@php $bind_me = 'bound'; @endphp
<template extends="extends/parent2">
    <div>123</div>
</template>
=====
<parent2>
    bound
    <div>123</div>
</parent2>