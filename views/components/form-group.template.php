<div class="form-group" :class="!empty($class) ? $class : ''">
    <slot name="label">
        <label class="form-label">{{ $label }}</label>
    </slot>
    <slot>
        <switch of="type">
            <input case="text" type="text" class="form-control">
            <input case="number" type="number" class="form-control">
        </switch>
    </slot>
    <span p-if="!empty($error)" class="error">{{ $error }}</span>
</div>