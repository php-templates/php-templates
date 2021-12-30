<!-- bind from slot to surface -->
<component is="props/c">
    <div p-foreach="$val as $v">{{ $name.$v }}</div>
</component>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>