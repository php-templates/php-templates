@php
$_attrs = $_context->except(['class','label']);
@endphp

<div class="form-group" :class="!empty($class) ? $class : ''">
    <slot name="label">
        <label class="form-label">{{ $label }}</label>
    </slot>
    <slot>
        <input p-if="$type === 'text'" type="text" class="form-control" p-bind="$_attrs" :placeholder="$placeholder ?? $label">
        <input p-elseif="$type === 'number'" type="number" class="form-control" p-bind="$_attrs" :placeholder="$placeholder ?? $label">
        <input p-elseif="$type === 'email'" type="email" class="form-control" p-bind="$_attrs" :placeholder="$placeholder ?? $label">
        <label p-elseif="$type === 'checkbox'" p-foreach="$options as $name => $label">
            <input type="checkbox" p-raw="in_array($name, $values) ? 'checked' : ''" value="1">
            {{ $label }}
        </label>
        <label p-elseif="$type === 'radio'" p-foreach="$options as $val => $label">
            <input type="radio" :name="$name" p-raw="$val == $value ? 'checked' : ''" :value="$val">
            {{ $label }}
        </label>
        <select p-elseif="$type === 'select'" class="form-control">
            <option p-foreach="$options as $val => $label" :value="$val" p-raw="$val == $value ? 'checked' : ''">{{ $label }}</option>
        </select>
        <textarea p-elseif="$type === 'textarea'" class="form-control" :placeholder="$placeholder ?? $label" p-bind="$_attrs">{{ $value }}</textarea>
    </slot>
    <span p-if="!empty($error)" class="error">{{ $error }}</span>
</div>