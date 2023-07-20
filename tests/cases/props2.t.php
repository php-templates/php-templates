<!-- bind data to a component slot -->
<tpl is="props/c">
    <tpl p-scope="['name' => $name]">
        1{{ $name }}
        <tpl is="comp/comp_slot">2{{ $name }}</tpl>
    </tpl>
</tpl>
=====
<c>
    1myname
    <div class="comp_slot">
        <span>2myname</span>
    </div>
</c>