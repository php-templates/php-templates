<!-- bind from slot to surface -->

<template is="props/c" p-scope="$s">
    <template>
        <div p-foreach="$s->val as $v">{{ $s->name.$v }}</div>
    </template>
</template>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>