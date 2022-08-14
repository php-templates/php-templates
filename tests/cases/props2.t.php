<!-- bind data to a component slot -->
<template is="props/c" p-scope="$s">
    1{{ $s->name }}
    <template is="comp/comp_slot">2{{ $s->name }}</template>
</template>
=====
<c>
    1myname
    <div class="comp_slot">
        <span>2myname</span>
    </div>
</c>