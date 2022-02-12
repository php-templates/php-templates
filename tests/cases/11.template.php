<!-- component as block item -->
<block name="b1" p-foreach="[1,2] as $k" :k="$k">
    <template is="comp/simple"></template>
</block>
=====
<div class="comp/simple">
    comp/simple
</div>
<div class="comp/simple">
    comp/simple
</div>