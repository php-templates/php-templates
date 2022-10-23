
@php  
$this->addSlot('default', function() {
    if (!empty(func_get_arg(0)['y'])) {
     echo func_get_arg(0)['y'];
    }
});
$val = 'val';
@endphp
<slot :y="$val">{{ $val }}
  <tpl is="comp/x">{{ $val }}</tpl>
</slot>
=====
val

-----

@php $val = 'val'; @endphp
<slot y="23">{{ $val }}
  <simplenode>{{ $val }}</simplenode>
</slot>
=====
23

-----

@php $val = 'val'; @endphp
<slot y="foo">{{ $val }}
  <tpl>{{ $val }}</tpl>
</slot>
=====
foo

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}textnode {{ $val }}</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <extends template="comp/x">{{ $val }}</extends>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <slot>{{ $val }}</slot>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <tpl is="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <simplenode p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>textnode {{ $val }}
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <tpl p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <extends template="comp/x" p-else>{{ $val }}</extends>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>
  <extends template="comp/x" p-else>{{ $val }}</extends>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>
  <extends template="comp/x" p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</extends>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-if="0">{{ $val }}</extends>
  <slot p-else>{{ $val }}</slot>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</extends>
  <slot p-else>{{ $val }}</slot>
</slot>
=====

-----

@php $val = 'val'; @endphp
<slot>{{ $val }}textnode {{ $val }}
  <extends template="comp/x" p-if="0">{{ $val }}</extends>
  <slot p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</slot>
</slot>
=====