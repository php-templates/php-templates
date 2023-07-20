{% $array = [1, 2] %}
{% $array_map = ['foo' => 'f1', 'bar' => 'f2'] %}
{% $true = true %}
{% $false = false %}

<tpl is="comp/simple" p-if="$true"></tpl>
<elseif p-elseif="$true"></elseif>
=====
<div class="comp/simple">
    comp/simple
</div>