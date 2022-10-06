
@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl is="comp/x">{{ $val }}</tpl>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <simplenode>{{ $val }}</simplenode>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl>{{ $val }}</tpl>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}textnode {{ $val }}</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <extends template="comp/x">{{ $val }}</extends>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <slot>{{ $val }}</slot>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <simplenode p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>textnode {{ $val }}
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>textnode {{ $val }}
  <extends template="comp/x" p-else>{{ $val }}</extends>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>textnode {{ $val }}
  <extends template="comp/x" p-else>{{ $val }}</extends>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>textnode {{ $val }}
  <extends template="comp/x" p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</extends>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-elseif="0">{{ $val }}</extends>
  <slot p-else>{{ $val }}</slot>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</extends>
  <slot p-else>{{ $val }}</slot>
</tpl>

-----

@php $val = 'val'; @endphp
<tpl is="comp/x">{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-elseif="0">{{ $val }}</extends>
  <slot p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</slot>
</tpl>