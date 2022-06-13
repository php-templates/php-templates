<!-- multi-extends -->
@php $this->scopeData['bind_me'] = 'bound'; @endphp
<template is="extends/c"></template>
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