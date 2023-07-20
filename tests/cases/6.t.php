<!-- bind from slot to surface -->

<tpl is="props/c">
    <tpl p-scope="['val' => $val, 'name' => $name]">
        <div p-foreach="$val as $v">{{ $name.$v }}</div>
    </tpl>
</tpl>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>