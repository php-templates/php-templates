<!-- pass data to extended template -->
{% $bind_me = 'bound' %}
<tpl is="extends/b" :bind_me="$bind_me"></tpl>
=====
<parent2>
    bound
    <b></b>
</parent2>