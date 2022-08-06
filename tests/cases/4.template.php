<!-- pass data to extended template -->
@php $bind_me = 'bound'; @endphp
<template is="extends/b" :bind_me="$bind_me"></template>
=====
<parent2>
    bound
    <b></b>
</parent2>