<!-- pass data to extended template -->
@php $bind_me = 'bound'; @endphp
<tpl is="extends/b" :bind_me="$bind_me"></tpl>
=====
<parent2>
    bound
    <b></b>
</parent2>
