<button :class="['btn btn-'.'primary'.' '.'disabled']" :class="[($size = 'sm') ? 'btn-'.$size : '']" p-bind="$_attrs = ['onclick' => 'doSomething()']" p-disabled="$disabled = true" :class="1 ? 'yes' : ''">
    <slot></slot>
</button>
=====
<button class="btn btn-primary disabled btn-sm yes" onclick="doSomething()" disabled></button>
