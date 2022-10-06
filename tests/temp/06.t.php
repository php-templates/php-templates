@php $val = 'val'; @endphp
<tpl>{{ $val }}textnode {{ $val }}
  <tpl extends="comp/x" p-if="0">{{ $val }}</tpl>
  <slot p-else>{{ $val }}</slot>
</tpl>

-----
