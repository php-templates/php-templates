
{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl is="comp/x">{{ $val }}</tpl>
</tpl>
=====
val
<x>
    val
    s2-default 1
    s2-default 2
</x>
-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <simplenode>{{ $val }}</simplenode>
</tpl>
=====
val
<simplenode>val</simplenode>

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl>{{ $val }}</tpl>
</tpl>
=====
val val

-----

{% $val = 'val'; %}
<tpl>{{ $val }}textnode {{ $val }}</tpl>
=====
valtextnode val

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl extends="comp/x">{{ $val }}</tpl>
</tpl>
=====
val
<x>
    val
    s2-default 1
    s2-default 2
</x>

-----

{% $val = 'val'; %}
{% $this->addSlot('default', function() { echo 123; }, $this); %}
<tpl>{{ $val }}
  <slot>{{ $val }}</slot>
</tpl>
=====
val
123

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl is="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}{{ $i }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</tpl>
=====
val
<x>
    val1
    s2-default 1
    s2-default 2
</x>
<x>
    val2
    s2-default 1
    s2-default 2
</x>

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-else>{{ $val }}</tpl>
</tpl>
=====
val
<simplenode class="1">val</simplenode>
<simplenode class="2">val</simplenode>

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl is="comp/x" p-if="0">{{ $val }}</tpl>
  <simplenode p-elseif="0">{{ $val }}</simplenode>
  <tpl p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val.$i }}</tpl>
</tpl>
=====
val
val1
val2

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <simplenode p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</tpl>
=====
val
<simplenode class="1">val</simplenode>
<simplenode class="2">val</simplenode>
textnode val

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>textnode {{ $val }}
</tpl>
=====
val
val
val
textnode val

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <simplenode p-if="0">{{ $val }}</simplenode>
  <tpl p-elseif="0">{{ $val }}</tpl>textnode {{ $val }}
</tpl>
=====
val
textnode val

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl p-if="123" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else>{{ $val }}</tpl>
</tpl>
=====
val
val
val

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else>{{ $val }}</tpl>
</tpl>
=====
val
<x>
    val
    s2-default 1
    s2-default 2
</x>

-----

{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl p-if="0">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
</tpl>
=====
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

-----

{% $val = 'val'; %}
<tpl>{{ $val }}textnode {{ $val }}
  <tpl extends="comp/x" p-if="0">{{ $val }}</tpl>
  <slot p-else>{{ $val }}</slot>
</tpl>
=====
valtextnode val
123

-----

{% $val = 'val'; %}
<tpl>{{ $val }}textnode {{ $val }}
  <tpl extends="comp/x" p-if="1" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <slot p-else>{{ $val }}</slot>
</tpl>
=====
val textnode val
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

-----

{% $val = 'val'; %}
<tpl>{{ $val }}textnode {{ $val }}
  <tpl extends="comp/x" p-if="0">{{ $val }}</tpl>
  <slot p-else p-foreach="[1, 2] as $i" :class="$i">{{ $val.$i }}</slot>
</tpl>
=====
valtextnode val
123
123