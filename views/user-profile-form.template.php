<extends template="layouts/app"/>

<slot name="ascomp"><x-helper>h</x-helper>Slot with default as comp</slot>
<x-card>
    <slot slot="title" bind="mytitle"></slot>
    <slot slot="title" bind="x"><x-helper>-x-</x-helper></slot>
    <div class="row">
        <x-form-group type="text" class="col-6"
            name="firstname"
            :label="$entry_firstname"
            :value="$firstname"
            />
        <x-form-group type="text" class="col-6"
            name="firstname"
            :label="$entry_lastname"
            :value="$lastname"
            />
    </div>
    <x-form-group type="email" 
        name="email"
        :label="$entry_email"
        :value="$email"
        />
    <x-form-group type="select" :options="['male' => $entry_male, 'female' => $entry_female]"
        name="gender"
        :label="$entry_gender"
        :value="$gender"
        />
    <x-form-group type="checkbox" :options="['o1' => 'A', 'o2' => 'B']"
        name="options"
        label="Options"
        :values="['o1']"
        />
    <x-form-group type="radio" :options="['1' => 'A', '2' => 'B']"
        name="radio"
        label="Radio"
        value="2"
        />
    <x-form-group type="textarea" rows="10"
        name="textarea"
        label="Label"
        value="some text">
        <label slot="label"><x-helper>Helper</x-helper> Label with helper</label>
    </x-form-group>
    
    <block name="extra-fields">
        <x-form-group type="text"
            name="ef1"
            label="ef1"
            value=""
            />
    </block>
</x-card>