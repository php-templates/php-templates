<!-- bind from slot to surface -->

<tpl is="props/c" p-scope="$s">
    <tpl>
        <div p-foreach="$s->val as $v">{{ $s->name.$v }}</div>
    </tpl>
</tpl>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>