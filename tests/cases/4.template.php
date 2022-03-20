<!-- pass data to extended template -->
<?php $this->scopeData['bind_me'] = 'bound'; ?>
<template is="extends/b"></template>
=====
<parent2>
    bound
    <b></b>
</parent2>