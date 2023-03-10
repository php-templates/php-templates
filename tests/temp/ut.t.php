{% '$slot->render([]);' %}

-----

{% $i = 0 %}
{% $k = 'k' %}
<tpl p-foreach="[1,2,3,4] as $k => $l">
    {% $i = $i +1 %}
    {% $i++ %}
</tpl>
{{ $i }}
{{ $k }}
{{ $l }}

-----

<tpl is="comp/csdf1">
    
</tpl>

-----
