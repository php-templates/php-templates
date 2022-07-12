<!-- bind data to a component slot -->
<template is="props/c">
    {{ $name }}
    <template is="comp/comp_slot">{{ $name }}</template>
</template>
=====
<c>
    myname
    <div class="comp_slot">
        <span>myname</span>
    </div>
</c>