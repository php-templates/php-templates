<!-- component is="components/form-group" type="text">
    <div slot="label">Form label</div>
</component>

<x-form-group type="text"></x-form-group -->

<x-form-group type="text">
    <div slot="label">
        {{ $label }}
        <x-helper>This is a simple helper</x-helper>
    </div>
</x-form-group>