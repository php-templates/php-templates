<x>
    @php $var = isset($var) ? $var : 's-val'; @endphp
    {{ $b }}
    <slot :var="$var">s-default</slot>
    <slot p-foreach="[1, 2] as $i" name="s2" :var="$var" :i="$i">s2-default {{ $i }}</slot>
</x>