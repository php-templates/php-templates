<div class="form-group" :class="!empty($class) ? $class : ''">
    <slot name="label">
        <label class="form-label">{{ $label }}</label>
    </slot>
    <slot>
        <switch of="type">
            <input case="text" type="text" class="form-control" :value="$value" :placeholder="$placeholder ?? $label">
            <input case="number" type="number" class="form-control" :value="$value" :placeholder="$placeholder ?? $label">
            <input case="email" type="email" class="form-control" :value="$value" :placeholder="$placeholder ?? $label">
            <label case="checkbox" p-foreach="$options as $name => $label">
                <input type="checkbox" p-raw="in_array($name, $values) ? 'checked' : ''" value="1">
                {{ $label }}
            </label>
            <label case="radio" p-foreach="$options as $val => $label">
                <input type="radio" :name="$name" p-raw="$val == $value ? 'checked' : ''" :value="$val">
                {{ $label }}
            </label>
            <select case="select" class="form-control">
                <option p-foreach="$options as $val => $label" :value="$val" p-raw="$val == $value ? `checked='checked` : ''">{{ $label }}</option>
            </select>
            <textarea case="textarea" class="form-control" :placeholder="$placeholder ?? $label" p-bind="$_attrs">{{ $value }}</textarea>
        </switch>
    </slot>
    <span p-if="!empty($error)" class="error">{{ $error }}</span>
</div>