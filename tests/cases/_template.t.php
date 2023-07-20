
{% $this->addSlot('default', function() { echo func_get_arg(0)['y'] ?? ''; }, $this); %}
{% $val = 'val'; %}

<tpl is="comp/x">{{ $val }}
  <tpl is="comp/x">
      <tpl slot="default">{{ $val }}</tpl>
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

{% $val = 'val'; %}
<tpl is="comp/x">
  <tpl slot="default">{{ $val }}</tpl>
  <tpl slot="s2" p-scope="$slot">
      <tpl p-if="1">{{ $slot['i'] }}</tpl>
      <span></span>
  </tpl>
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

{% $val = 'val'; %}
<tpl is="comp/x">
  <tpl slot="default">
    <tpl extends="comp/x">{{ $val }}</tpl>
  </tpl>
  <tpl slot="s2"></tpl>
</tpl>
=====
<x>
    <x>
        val
        s2-default 1
        s2-default 2
    </x>
</x>

-----

{% $val = 'val'; %}
<tpl is="comp/x">
  <tpl slot="default">
      {{ $val }}
      <slot>{{ $val }}</slot>
  </tpl>
</tpl>
=====
<x>
    val
    s2-default 1
    s2-default 2
</x>

-----

{% $val = 'val'; %}
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