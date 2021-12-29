<component is="extends/a"></component>
=====
<parent>
    <div>123</div>
    <a>
        <foo></foo>
    </a>
</parent>

-----

<!-- pass data to extended template -->
<?php $data['bind_me'] = 'bound'; ?>
<component is="extends/b"></component>
=====
<parent2>
    bound
    <b></b>
</parent2>

-----

<!-- multi-extends -->
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