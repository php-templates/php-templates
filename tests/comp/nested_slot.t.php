<div class="sdefsdef">
    <slot><span><slot name="sn"></slot></span></slot>
</div>

<div class="sdefsdef">
    <slot name="sn1"><span><slot name="sn2">foo</slot></span></slot>
</div>

<div class="sdefsdef">
    <slot name="sn3"><span><slot name="sn4"><template is="comp/simple"></template></slot></span></slot>
</div>

<template is="comp/comp_slot">
    <slot name="sn5">
        <template is="comp/simple"></template>
    </slot>
</template>

<template is="comp/comp_slot">
    <slot name="sn6">
        <slot name="sn7"></slot>
    </slot>
</template>

<template is="comp/comp_slot">
    <div class="x">
        <slot name="sn8">
            <template is="comp/simple"></template>
        </slot>
    </div>
</template>

<template is="comp/comp_slot">
    <p>xjd</p>
    <slot name="sn9">
        djdh
        <template is="comp/simple"></template>
    </slot>
    <p>hdhd</p>
</template>
