{%
if (!empty($name)) {
    $error = isset($error) ? $error : ($errors ? $errors->first($name) : null);
    if ($formModel && !isset($_data['value'])) {
        $value = data_get($formModel,str_replace(['[',']'],['.',''],$name));
    }
    $value = old($name, $value) ?? '';
    $id = isset($id) ? $id : 'input-'.$name;
    $label = isset($label) ? $label : trans($name);
    if (strpos($name, '.')) {
        $name = implode(array_map(function() {
            
        }, explode('.', $name)))
    }
}
%}

<tpl p-if="isset($multilang)" is="bootstrap:forms/form-group" p-bind="$_context->all()">
  <span p-foreach="$languages as $lang" :class="'lang lang-'.$lang['value']">
    <slot>
      <x-form-control p-bind="$slot->attrs" :name="'['.$lang['value'].']'" />
    </slot>
  </span>
</tpl>
<tpl p-else is="bootstrap:forms/form-group" p-bind="$_context->all()">
    <slot p-bind="['attrs' => $slot->attrs]"></slot>
</tpl>

<div></div>
<?php return new class extends PhpTemplates\ParseEvent {
    public $props = [
      
    ];
    public function parsing($node, $doc) 
    {
       $foo;
    }
};// pl