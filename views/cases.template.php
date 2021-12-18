<component is="components/c" class="onroot">
<component is="components/ns" class="compns ">ns</component>
</component>

ar trebui sa rezulte 
<div>comp/ns<div>ns</div></div>

<component is="components/c" class="onroot">
<div class="plainSlot">
<component is="components/ns" class="compns ">
    ns
</component>
</div>
</component>

ar trebui sa rezulte
<div><div class="plainSlot">comp/ns<div class="compns">ns</div></div></div>


<component is="components/c" class="onroot">
<component is="components/nns" class="compnns ">nns</component>
</component>

ar trebui sa rezolte
<div onroot>comp/nns<div><div>nns</div></div></div>