{% $foo = 'foo' %}
{% $bar = 'bar' %}
{% $arr = ['arr1', 'arr2'] %}
{% $true = 1 %}
{% $false = 0 %}

<!-- bindings in component -->
yoy
<tpl is="props/b" :true="$true" false="$false" foo="$foo"></tpl>
=====
yoy
<b true="1"><bind false="$false" foo="$foo"></bind></b>

-----

<simple :foo="$foo" bar="$bar"></simple>
=====
<simple foo="foo" bar="$bar"></simple>

-----

<!-- component with extra props -->
<tpl is="props/a" foo="$foo" :bar="$bar" :true="$true"></tpl>
=====
<a true="1"></a>

-----

<!-- bind from slot to surface -->
<tpl is="props/c">
    <tpl p-scope="$slot">
        <div p-foreach="$slot['val'] as $v">{{ $slot['name'].$v }}</div>
    </tpl>
</tpl>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>