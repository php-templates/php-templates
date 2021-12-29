<!-- pass data to extended template -->
<?php $data['bind_me'] = 'bound'; ?>
<component is="extends/b"></component>
=====
<parent2>
    bound
    <b></b>
</parent2>