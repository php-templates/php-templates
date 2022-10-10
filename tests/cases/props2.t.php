<!-- bind data to a component slot -->
<tpl is="props/c">
    @php $s = $slot; @endphp
    1{{ $slot->name }}
    <tpl is="comp/comp_slot">2{{ $s->name }}</tpl>
</tpl>
=====
<c>
    1myname
    <div class="comp_slot">
        <span>2myname</span>
    </div>
</c>