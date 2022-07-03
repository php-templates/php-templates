<template is="extends/parent4" :bind_me="$bind_me">
    <parent3>
        parent3
        {{ $bind_me }}
        <slot></slot>
    </parent3>
</template>
