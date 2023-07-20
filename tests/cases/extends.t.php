<!-- multi-extends -->
<tpl is="extends/c" :bind_me="'bound'"></tpl>
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

-----
{% $bind_me = 'bound'; %}
<tpl extends="extends/parent2">
    <div>123</div>
</tpl>
=====
<parent2>
    bound
    <div>123</div>
</parent2>