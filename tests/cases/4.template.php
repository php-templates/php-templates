<!-- pass data to extended template -->
@php $this->scopeData['bind_me'] = 'bound'; @endphp
<template is="extends/b"></template>
=====
<parent2>
    bound
    <b></b>
</parent2>