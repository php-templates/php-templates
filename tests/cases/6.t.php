<!-- bind from slot to surface -->

<tpl is="props/c">
    <tpl>
        <div p-foreach="$slot->val as $v">{{ $slot->name.$v }}</div>
    </tpl>
</tpl>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>