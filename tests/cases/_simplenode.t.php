
@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl is="comp/x" :b="1">{{ $val }}</tpl>
</simplenode>
=====
<simplenode>
    val
    <x>
        1
        val
        s2-default 1
        s2-default 2
    </x>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <simplenode>{{ $val }}</simplenode>
</simplenode>
=====
<simplenode>
    val
    <simplenode>
        val
    </simplenode>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl>{{ $val }}</tpl>
</simplenode>
=====
<simplenode>
    val
    val
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}textnode {{ $val }}</simplenode>
=====
<simplenode>
    valtextnode val
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl extends="comp/x">{{ $val }}</tpl>
</simplenode>
=====
<simplenode>
    val
    <x>
        val
        s2-default 1
        s2-default 2
    </x>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <slot>{{ $val }}</slot>
</simplenode>
=====
<simplenode>
    val
    val
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl is="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</simplenode>
=====
<simplenode>
    val
    <x>
        1
        s2-default 1
        s2-default 2
    </x>
    <x>
        2
        s2-default 1
        s2-default 2
    </x>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</simplenode>
=====
<simplenode>
    val
    <simplenode class="1">1</simplenode>
    <simplenode class="2">2</simplenode>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</tpl>
</simplenode>
=====
<simplenode>
    val
    1
    2
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <simplenode p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</simplenode>
=====
<simplenode>
    val
    <simplenode class="1">val</simplenode>
    <simplenode class="2">val</simplenode>
    textnode val
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</tpl>textnode {{ $val }}
</simplenode>
=====
<simplenode>
    val
    1
    2
    textnode val
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</simplenode>
=====
<simplenode>
    val
    textnode val
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</tpl>
  <tpl extends="comp/x" p-else>{{ $val }}</tpl>
</simplenode>
=====
<simplenode>
    val
    1
    2
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else>{{ $val }}</tpl>
</simplenode>
=====
<simplenode>
    val
    <x>
        val
        s2-default 1
        s2-default 2
    </x>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
</simplenode>
=====
<simplenode>
    val
    <x>
        val
        s2-default 1
        s2-default 2
    </x>
    <x>
        val
        s2-default 1
        s2-default 2
    </x>
</simplenode>