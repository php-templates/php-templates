
@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl is="comp/x">{{ $val }}</tpl>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <simplenode>{{ $val }}</simplenode>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl>{{ $val }}</tpl>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}textnode {{ $val }}</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <extends template="comp/x">{{ $val }}</extends>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <slot>{{ $val }}</slot>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl is="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <simplenode p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>textnode {{ $val }}
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>textnode {{ $val }}
  <extends template="comp/x" p-else>{{ $val }}</extends>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>textnode {{ $val }}
  <extends template="comp/x" p-else>{{ $val }}</extends>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>textnode {{ $val }}
  <extends template="comp/x" p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</extends>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-elseif="0">{{ $val }}</extends>
  <slot p-else>{{ $val }}</slot>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</extends>
  <slot p-else>{{ $val }}</slot>
</simplenode>

-----

@php $val = 'val'; @endphp
<simplenode>{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-elseif="0">{{ $val }}</extends>
  <slot p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</slot>
</simplenode>