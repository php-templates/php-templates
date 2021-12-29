<?php 
$foo = 'foo';
$bar = 'bar';
$arr = ['arr1', 'arr2'];
$true = 1;
$false = 0;
?>

<simple :foo="$foo" bar="$bar"></simple>
=====
<simple bar="$bar" foo="foo"></simple>

-----

<!-- component with extra props -->
<component is="props/a" foo="$foo" :bar="$bar" :true="$true"></component>
=====
<a true="1"></a>

-----

<!-- bindings in component -->
<component is="props/b" :true="$true" false="$false" foo="$foo"></component>
=====
<b true="1"><bind false="$false" foo="$foo"></bind></b>

-----

<!-- bind from slot to surface -->
<component is="props/c">
    <component>
        <div p-foreach="$val as $v">{{ $name.$v }}</div>
    </component>
</component>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>