<!-- multi-extends -->
@php $bind_me = 'bound'; @endphp
<template is="extends/c" :bind_me="$bind_me"></template>
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