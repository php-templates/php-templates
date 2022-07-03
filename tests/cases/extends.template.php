<template is="extends/a"></template>
=====
<parent>
    <div>123</div>
    <a>
        <foo></foo>
    </a>
</parent>

-----

<!-- pass data to extended template -->
@php $this->scopeData['bind_me'] = 'bound'; @endphp
<template is="extends/b" :bind_me="$this->scopeData['bind_me']"></template>
=====
<parent2>
    bound
    <b></b>
</parent2>

-----

<!-- multi-extends -->
<template is="extends/c" :bind_me="$this->scopeData['bind_me']"></template>
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