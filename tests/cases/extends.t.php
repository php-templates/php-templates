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