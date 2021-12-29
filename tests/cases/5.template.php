<!-- multi-extends -->
<?php $data['bind_me'] = 'bound'; ?>
<component is="extends/c"></component>
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