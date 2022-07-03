<!-- pass data to extended template -->
@php $this->scopeData['bind_me'] = 'bound'; @endphp
<template is="extends/b" :bind_me="$this->scopeData['bind_me']"></template>
=====
<parent2>
    bound
    <b></b>
</parent2>