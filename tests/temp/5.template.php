
@php $this->scopeData['bind_me'] = 'bound'; @endphp
<template is="extends/c" :bind_me="$this->scopeData['bind_me']"></template>

-----
