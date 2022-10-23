
@php  
$this->addSlot('default', function() {
    if (!empty(func_get_arg(0)['y'])) {
     echo func_get_arg(0)['y'];
    }
});
$val = 'val';
@endphp

<tpl is="comp/x">{{ $val }}
  <tpl is="comp/x">
      {{ $val }}
      <span slot="s2"></span>
  </tpl>
</tpl>
=====
<x>
    val
    <x>
        val
        <span></span>
        <span></span>
    </x>
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl p-if="1" slot="s2">{{ $slot->i }}</tpl>
  <span slot="s2"></span>
</tpl>
=====
<x>
    val
    1
    <span></span>
    2
    <span></span>
</x>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl extends="comp/x">{{ $val }}</tpl>
  <tpl slot="s2"></tpl>
</tpl>
=====
<x>
    val
    <x>
        val
        s2-default 1
        s2-default 2
    </x>
</x>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <slot>{{ $val }}</slot>
</tpl>
=====
<x>
    val
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else>{{ $val }}</tpl>
</tpl>
=====
<x>
    val
    val val
    s2-default 1
    s2-default 2
</x>