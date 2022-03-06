<!-- bind from slot to surface -->

<template is="props/c">
    <template>
        <div p-foreach="$val as $v">{{ $name.$v }}</div>
    </template>
</template>
=====
<c>
    <div>myname1</div>
    <div>myname2</div>
</c>