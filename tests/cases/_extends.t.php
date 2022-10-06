
@php $val = 'val'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl is="comp/x">{{ $val }}</tpl>
</tpl>
=====
<x>
    val
    s2-default 1
    s2-default 2
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'valp'; @endphp
<tpl extends="comp/x">{{ $val }}
  <simplenode>{{ $val }}</simplenode>
</tpl>
=====
<x>
    <simplenode>valp</simplenode>
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'valp'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl>{{ $val }}</tpl>
</tpl>
=====
<x>
    valp
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'valp'; @endphp
<tpl extends="comp/x">{{ $val }}textnode {{ $val }}</tpl>
=====
<x>
    valptextnode valp
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'valp'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl extends="comp/x">{{ $val }}</tpl>
</tpl>
=====
<x>
    valp
    valp
    <x>
      val
      s2-default 1
      s2-default 2
    </x>
    s2-default 1
    s2-default 2
</x>

-----

<tpl extends="comp/x">{{ $val }}
  <slot>{{ $val }}</slot>
</tpl>
=====
<x>
    s-val s-val
    s2-default 1
    s2-default 2
</x>


-----

@php $val = 'y'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</tpl>
=====
<x>
    y
<x>
    y
    s2-default 1
    s2-default 2
</x>
<x>
    y
    s2-default 1
    s2-default 2
</x>
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'val'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</tpl>
=====
<x>
    val
    <simplenode class="1">val</simplenode>
    <simplenode class="2">val</simplenode>
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'val'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</tpl>
</tpl>
=====
<x>
    val
    1 2
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'v'; @endphp
<tpl extends="comp/x">{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>textnode {{ $val }}
</tpl>
=====
<x>
    val
    textnode v
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'l'; @endphp
<tpl extends="comp/x">{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</tpl>
=====
<x>
    val
    textnode l
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'a'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</tpl>textnode {{ $val }}
  <tpl extends="comp/x">{{ $val }}</tpl>
</tpl>
=====
<x>
    a 1 2 textnode a
<x>
    a
    s2-default 1
    s2-default 2
</x>    
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'h'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
</tpl>
=====
<x>
    h
<x>
    h
    s2-default 1
    s2-default 2
</x> 
<x>
    h
    s2-default 1
    s2-default 2
</x>
    s2-default 1
    s2-default 2
</x>

-----

@php $val = 'val'; @endphp
<tpl extends="comp/x">{{ $val }}textnode {{ $val }}
  <tpl extends="comp/x" p-if="0">{{ $val }}</tpl>
  <slot p-else>{{ $val }}</slot>
</tpl>
=====
<x>
    val textnode val
    val
    s2-default 1
    s2-default 2
</x>