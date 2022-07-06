## Introduction
Tired of writing syntax like:
```
@if | {% if %}
    <div class="foo {{ bar }}">
        @if | {% if %}
            <div>
            </div
        @endif | {% endif %}
    </div
@endif | {% endif %}
```
in any php template engine you are using?
If you indent control structures, soon, you will have an unreadable document. If you don't indent, you will have ambiguous control structures to follow. Where it starts. Where it ends? Want a simplified and pleasant syntax that is easy to follow and mentain? Want reusable components like form groups that are easy to interact with and set values?
What about:
```
<div p-if="$foo" class="foo" :class="$bar">
    <div p-if="isset($bar)">
        <x-form-group type="text" label="Name" :value="$name">
    </div>
</div>
```
? Is a vue.js inspired syntax, but in PHP.

***Php-Templatess*** is a template engine based on [HTML5DOMDocument](https://github.com/ivopetkov/html5-dom-document-php). Unlike some PHP templating engines, ***Php-Templatess*** does not restrict you from using plain PHP code in your templates. In fact, all ***Php-Templatess*** templates are compiled into plain PHP code (functional templating) and cached until they are modified, meaning ***Php-Templatess*** adds essentially zero overhead to your application, also it has a clear syntax due to the fact that control structures are placed as targeted tag attribute, like in React/Vue.js syntax. However, because of using DomDocument, there are some known limitations, but also solutions/workarounds.
1. ###### You can't have php tags outside of a node attribute value
The following syntax would confuse DomDocument on parsing:
```
<input type="checkbox" <?php echo $true ? 'checked' : ''; ?>>
``` 
The above syntax is invalid (and ugly). However, you have `p-raw` directive for this, or you can create your own custom directives (see **Custom directives** section):
```
<input type="checkbox" p-raw="$true ? 'checked' : ''">
// -> <input type="checkbox" <?php echo $true ? 'checked' : ''; ?>>
```
or after defining a custom directive that echo `checked` when passed condition is true:
```
<input type="checkbox" p-checked="$true">
```

2. ###### You can't have a dynamic node name
In situations that requires dynamic tag names based on condition (for example when we want a tag to be a `p` or `h1`):
``` 
<<?php echo $true ? 'h1' : 'p'>>
    ...
</<?php echo $true ? 'h1' : 'p'>>
```
using ***Php-Templatess***, you will have to treat that node open and close tag as pure string and taking in consideration that ***Php-Templatess*** will treat it like a string too (***Php-Templatess*** syntax on that tag won't be parsed)
```
<?php echo '<div class="'.(true ? 'some-class' : '').'">'; ?>
    <p p-foreach="[1,2] as $i"></p>
<?php echo '</div>'; ?>
```
3. ###### Missing closing tags will lead to unexpected behaviours and for now are hard to debug
However, now you have tools for auto closing tags and highlightings tools, and a new template engine for better templating.

4. ###### please, let me know if you found other limitations.

## How it works
***Php-Templatess*** files use the `.template.php` extension and stored in `src_path` configured path and they are parsed and 'cached' in `dest_path` in plain path mode (`foo/bar.template.php` will cached as `foo_bar_{hash}.php`). Now, `dest_path` won't be used by developer, is just the place where parsed templates are stored.
```
use PhpTemplates\Config;

Config::set('src_path', '/views');
Config::set('dest_path', '/parsed');

// the file /views/components/form-group.template.php will be parsed and results /parsed/components_formgroup_{hash}.php
```

*___In the next parts, we will refer to `src_path` files as components or templates as the same thing. Also, parsed components that are ready to be rendered will be refered as instances___*

Each template entity (components, slots, blocks then loaded template itself) will be recomposed with minimal redundance and executed to match the desired structure. For example:
- template `Garage` is composed with templates `Bicycle` and `Car`
- template `Car` has component `Wheel`
- template `Bicycle` has `Wheel` too, but with different aspect parameters
- component `Wheel` will be parsed only once and be used in template `Car` and `Bicycle` with given `parameters`.

For this to work, ***php-templates*** will create and map structures like this: 
```
// pseudo code, pseudo result
$wheel = function($data = ['size' => 12]) {
    ...html here
};
$car = function() {
    ...html here
    $wheel(['size' => 16])
}
$bicycle = function() {
    ...html here
    $wheel(['size' => 3])
}
$garage = function() {
    ...html here
    $car();
    $bicycle();
}
```
This is not how ***Php-templates*** actually works, but this is how it conceptually works. In fact, each entity will have an object instance of type `PhpTemplates\Parsed` wraping its template function and providing contextual data.

In order to render a template:
```
use PhpTemplates\PhpTemplate;

Template::load('Garage', $data)`. 

// If you only want a template instance to render it later, or to programatically assign it to another template render context
$car = Template::get('Garage/Car', $attrs)`

// manipulate template attrs or data
$car->attrs['color'] = 'red';
$car->data['owner'] = 'me';

// when you want to render that template
$car->render($data)
```
Difference between `$attrs` and `$data` will be described later, in Components section.

## Displaying data
Like in most template engines, data is escaped against html entities and displayed using `{{  }}` syntax. You can anytime call pure php in order to display raw, unescaped data.
Html nodes attributes are set using `:` bind syntax.
The following:
``` 
<div class="card" :class="$foo === 1 ? 'active' : ''"></div>
```
will produce:
``` 
<div class="card <?php echo $foo === 1 ? 'active' : ''; ?>"></div>
```
*Info: you can't have more than one binding of the same type per node*
```
<div :class="$x" :class="$y"></div>
// will result 
<div class="<?php echo $x; ?>"></div> 
```

As you can see, any valid continuing `echo ` php syntax is allowed between `""`. 
```
:attribute="{php_syntax}"
is translated to
attribute="<?php echo {php_syntax}"
```
## Control structures
Allowed control structures are 'if', 'elseif', 'else', 'for', 'foreach'.
You can place any of this allowed control structures prefixed with `p-` as attribute of the node you want to control.
The following:
```
<div class="item" p-foreach="$items as $item" p-if="$item['status'] === 'active'">{{ $item['name'] }}</div>
```
will produce:
```
<?php foreach ($items as $item") {
    if ($item['status'] === 'active') { ?>
        <div class="item"><?php echo htmlspecialchars($item['name']); ?></div>
    <?php } ?>
<?php } ?>
```

As you can see, control structures can be combined in many ways, even multiple `foreach` on same node. There is no operator precedence, but order of attributes matters, especially when one loop deppends of variables set by the parent loop.

## Custom directives
You may create your own parse rules using `Config::addDirective()`. 
```
use PhpTemplates\Config;

Config::addDirective('checked', function($expression) {
    // p-checked="$expression" will be evaluated as 
    // <?php echo {anything_that_function_returns}; ?>
    
    // the function must return a valid php expression as string
    return "$expression ? 'checked' : ''";
});
```
Now we can use our directive like this:
```
<input type="checkbox" p-checked="1 < 3">
```

## Components
You can reuse parts of design by making them components. Just put the html code into another file in `src_path` in any folder structure you preffer. For example, you can have `Config::get('src_path') . /components/form-group.template.php`:
```
<div class="form-group" :class="!empty($class) ? $class : ''">
    <label class="form-label">{{ $label }}</label>
    <input p-if="$type === 'text'" type="text" class="form-control" :value="$value" :placeholder="$placeholder ?? $label" p-bind="$_attrs">
    <select p-elseif="$type === 'select'" class="form-control">
        <option p-foreach="$options as $val => $label" :value="$val" p-raw="$val == $value ? 'checked' : ''">{{ $label }}</option>
    </select>
    ...
    <span p-if="!empty($error)" class="error">{{ $error }}</span>
</div>
```

Now we can use our component like this:
```
<template is="components/form-group" type="text" name="will_be_passed_as_string" $value="$any_valid_php = ['even_array_declaration']" required="required" />
```
Every component will be mapped on a global object and will be reused in case of second call with the given node attributes as parameters.

Each attribute passed on a component node will be included in one associative array which will be extracted in component function scope to be available there. Attributes passed with bind syntax (`:`) will be evaluated as php variables/syntax. Attributes passed without bind syntax will be treated as strings.

`p-bind="$_attrs"` is a special syntax which says that `<input` will receive as attributes all `$key => $value` of `$data` that was not used in template. In our case, `form-group` has not used var `$required`, so this value will be passed to input.
You can also have control structures on components nodes.

### Component aliasing
If you have an extensivelly used component, you can alias it by calling `Config::set('aliased', $what)`
```
use PhpTemplates/Config;

Config::set('aliased', ['form-group' => 'components/form-group']);

// Now we can reffer to our component by this:
<form-group type="text"/>
```
!!! Disclaimer: ***php-Templatess*** won't protect you against infinite reccursivity, so avoid aliasing components to valid html tags like `<section>` component having another section as body tag.

## Slots
Slots increases a component reusability by leting us to control a defined component layout from outside.
Considering our form-group component with slots would be:
```
<div class="form-group" :class="!empty($class) ? $class : ''">
    <slot name="label">
        <label class="form-label">{{ $label }}</label>
    </slot>
    <slot>
        <input p-if="$type === 'text'" type="text" class="form-control" :value="$value" :placeholder="$placeholder ?? $label" p-bind="$_attrs">
        <select p-elseif="$type === 'select'" class="form-control">
            <option p-foreach="$options as $val => $label" :value="$val" p-raw="$val == $value ? 'checked' : ''">{{ $label }}</option>
        </select>
        ...
    </slot>
    <span p-if="!empty($error)" class="error">{{ $error }}</span>
</div>
```
Slots can be named or default. Slots can have default values or not. To customize our component call, we can do something like this:
```
<form-group type="text" [other attrs]>
    <span slot="label">Custom label <i class="fa fa-download"></i></span>
    <input type="number" slot="default">
</form-group>
```
No slot is required to be passed. Empty slots will render nothing and slots with default values (declared between `<slot></slot>` tag) will evaluate that value. To pass a node as value to a slot, you have to use `slot="{slot_name}"` attribute. That node will replace {slot_name} in our component context.

## Blocks
Blocks are declared with `<block name="{block_name}">nodes here</block>` syntax. A block name is required. They work the same as a slot, they are treated like slots, but with 2 differences:
- passing a node as value to a block will not override default nodes, but join to them.
- blocks direct childnodes are indexed incrementally starting from 1. When you pass a node to a block, you can specify an `_index="int|float"` attribute (default is 0). Blocks will sort ascending its direct nodes using that _index value.
Lets have an example:
```
// our_form.template.php
<div class="card">
    <form-group type="text" label="name" value=""></form-group>
    <form-group type="email" label="email" value=""></form-group>
</div>
```
Considering that our form groups are indexed as name => 1, email="2", you can pass a new form group/element at any position as block direct childnode:
```
// as first element
<template is="our_form">
    <form-group type="number" label="age" value="" _index="0"></form-group>
</template>

// between 
<template is="our_form">
    <form-group type="number" label="age" value="" _index="1.5"></form-group>
</template>

// as last element
<template is="our_form">
    <form-group type="number" label="age" value="" _index="3"></form-group>
</template>
```

## Extends
If you find yourself in a situation where a layout is too repetitive, and only the main part of the layout is different, `extends` feature comes in help. Imagine you have the main layout `layouts/app.template.php` which contains the scaffolding of your application:
```
// layouts/app.template.php
<html>
    <head>...</head>
    <body>
        <template_header/>
        <template_column_left/>
        <slot></slot>
        <template_footer/>
    </body>
</html>
```
Products, categories and many other pages will use the same structure. This can be simplified by declaring an html node 
```
<extends template="layout/app"/>

... specific html content of product page 
```
at the beginning of the files that represent these pages. 

Now we just need to call 
```
PhpTemplates\PhpTemplate::load('product', $data);
// and php-templates will do the rest
```
In the background, ***Php-Templatess*** will create a `layout/app` template instance to which it will add the loaded template instance as the default slot. Also, both templates have access to the data passed as a parameter.
The extension is valid in any other situation.  All that is required is a default slot on the parent template and its data requirements to be met. Extending feature is related to the next one - ***Events***.

## Events
Events are a key point in the development of a modular interface and the thing that makes ***Php-Templatess*** perfect for this. Events are executed before rendering a component, template or a block can be listened and allow the alteration of the context in which they are executed (received data, received slots, order of rendered block items). Events can be ***general*** (attached to a template / component) or ***specific*** (eliptic or full path to targeted entity, mentioned separated with `.`). Events can be attached on components, slots or blocks. The syntax that will be used to attach an event:
```
use PhpTemplates\DomEvent;

new DomEvent('rendering', '{event_name}', $callback); 
// or 
DomEvent::on('rendering', '{event_name}', $callback);
```
Of course, this must be registered before template calling.

On each rendering event, ***php-Templatess*** will keep a record of the current path consisting of the parent templates + the current template joined by `.`.
When logging an event, a hierarchical selection rule similar to css ***descendants selector*** (`body header .my_class1 .myclass_2 {}`) applies, except that the name represents the relative name of the templates. If the `false` value is returned on any event callback, the rendering of the template in question is canceled.

Let's take an example. Considering we have the following templates: `user-profile-form` and `form-group`. First one contains a few of the second one. Now, we want to attach events on all `user-profile-form.form-group`:
```
$i = 0;
DomEvent::on('rendering', 'user-profile-form.form-group', function($template, &$data) use (&$i) {
    $i++;

    // make first element required
    if ($i === 1) {
        $data['required'] = true;
        // or
        $this->attrs['required'] = true;
    }

    // stop rendering age field 
    if ($this->attrs['name'] === 'age') {
        return false;
    }
});
```

Considering we add our event on a block or slot
```
DomEvent::on('rendering', 'user-profile-form.form-fields', function($template, &$data) {
    // here we have full access to manipulate the rendering context as we want
    // The rendering entity instance is binded to $this variable
    // take a look at Parsed::class render() function to see how it works

    $input = Template::get('form-group', [
        'name' => 'country',
        'type' => 'select',
        'options' => ['o1' => 'Ro', 'o2' => 'Gb'],
        'value' => 'o1',
        // _index attr here if event target is 
    ]);

    // if above components accepts slots, we can add them like this:
    // example of raw template (unparsed, on fly)
    $label = Template::raw(function() {
        echo '<label><i class="fa fa-help"></i>My label</label>'
    });
    $input->addSlot($position = 'label', $label);

    // finally, hook our input to render list
    $this->slots['form-fields'][] = $input;
    // if we have a slot event, we must insert the node at desired index in the above array

    // if form-fields is a block entity we can also change the order of displayed fields
    foreach ($this->slots['form-fields'] as $node) {
        // $node->attrs['_index'] = anything you want
    }
});
```

The examples found in [playground/form](https://github.com/florin-botea/***php-Templatess***/blob/dev/playground/form.php) may be used as sample of the power of that feature.