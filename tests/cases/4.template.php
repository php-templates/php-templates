<!-- pass data to extended template -->
<?php $this->data['bind_me'] = 'bound'; ?>
<template is="extends/b"></template>
=====
<parent2>
    bound
    <b></b>
</parent2>