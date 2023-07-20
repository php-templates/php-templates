<x>
    {% $var = isset($var) ? $var : 's-val'; %}
    {{ $b }}
    <slot :var="$var">s-default</slot>
    <slot p-foreach="[1, 2] as $i" name="s2" :var="$var" :i="$i">s2-default {{ $i }}</slot>
</x>