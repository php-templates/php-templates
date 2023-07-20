{% $val = 'val'; %}
<tpl>{{ $val }}
  <tpl p-if="123" p-foreach="[1, 2] as $i" :class="$i">{{ $val }}</tpl>
  <tpl extends="comp/x" p-else>{{ $val }}</tpl>
</tpl>
=====
val
val
val