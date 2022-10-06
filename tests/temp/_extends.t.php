
@php $val = 'val'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl is="comp/x">{{ $val }}</tpl>
</tpl>

-----


@php $val = 'valp'; @endphp
<tpl extends="comp/x">{{ $val }}
  <simplenode>{{ $val }}</simplenode>
</tpl>

-----


@php $val = 'valp'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl>{{ $val }}</tpl>
</tpl>

-----


@php $val = 'valp'; @endphp
<tpl extends="comp/x">{{ $val }}textnode {{ $val }}</tpl>

-----


@php $val = 'valp'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl extends="comp/x">{{ $val }}</tpl>
</tpl>

-----


<tpl extends="comp/x">{{ $val }}
  <slot>{{ $val }}</slot>
</tpl>

-----


@php $val = 'y'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</tpl>

-----


@php $val = 'val'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</tpl>

-----


@php $val = 'val'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</tpl>
</tpl>

-----


@php $val = 'v'; @endphp
<tpl extends="comp/x">{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>textnode {{ $val }}
</tpl>

-----


@php $val = 'l'; @endphp
<tpl extends="comp/x">{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</tpl>

-----


@php $val = 'a'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $i }}</tpl>textnode {{ $val }}
  <tpl extends="comp/x">{{ $val }}</tpl>
</tpl>

-----


@php $val = 'h'; @endphp
<tpl extends="comp/x">{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
</tpl>

-----


@php $val = 'val'; @endphp
<tpl extends="comp/x">{{ $val }}textnode {{ $val }}
  <tpl extends="comp/x" p-if="0">{{ $val }}</tpl>
  <slot p-else>{{ $val }}</slot>
</tpl>

-----
