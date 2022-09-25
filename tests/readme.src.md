<?php
function result() 
{
    
}

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

What about:
```
<div p-if="$foo" class="foo" :class="$bar">
    <div p-if="isset($bar)">
        <x-form-group type="text" label="Name" :value="$name">
    </div>
</div>
```
?

***Php-Templates*** is a template engine which syntax is inspired from Vue.js. Unlike some PHP templating engines, ***Php-Templates*** does not restrict you from using plain PHP code in your templates - with condition of writing it inside @php ... @endphp blocks. In fact, all ***Php-Templates*** templates are compiled into plain PHP code (functional templating) and cached until they are modified, meaning ***Php-Templates*** adds essentially zero overhead to your application, also it has a clear syntax due to the fact that control structures are placed as targeted tag attribute, like in React/Vue.js syntax.

## Setting up
***Php-Templates*** files use the `.template.php` extension and stored in `src_path` configured path and they are parsed and 'cached' in `dest_path` in plain path mode (`foo/bar.template.php` will cached as `foo_bar_{hash}.php`). Now, `dest_path` won't be used by developer, is just the place where parsed templates are stored.
```
required_once 'path/to/phpt/autoload.php';

use PhpTemplates\PhpTemplate;

$tpl = new PhpTemplate($src_path = '/views', $dest_path = '/parsed');
```
*___In the next parts, we will refer to `src_path` files as components or templates as the same thing. Also, parsed components that are ready to be rendered will be refered as instances___*

In order to render a template:
```
// this will echo html content
$tpl->load('user-form', $data);` //where user form is user-form.template.php file located under src_path

// If you only want a template instance to render it later, or to programatically assign it to another template render context
$modal = $tpl->get('auth/modal', $data)`

// manipulate template data
$modal->data['owner'] = 'me';

// when you want to render that template
$modal->render($extraData)
```
Passed $data is assumed to be an map array which will be extracted to template scope.

## Displaying data
Like in most template engines, data is escaped against html entities and displayed using `{{ $var }}` syntax. You can use `{!! $var !!}` syntax in order to display raw, unescaped data.
Php values are passed to html nodes attributes using `:` bind syntax.
The following:
``` 
<div class="card" :class="$foo === 1 ? 'active' : ''"></div>
```
will produce:
``` 
<div class="card <?php echo $foo === 1 ? 'active' : ''; ?>"></div>
```

As you can see, any valid continuing `echo ` php syntax is allowed `:attr="$__HERE__"`. 
```
:attribute="{php_syntax}"
is translated to
attribute="<?php echo {php_syntax}"
```
## Passing data
### To loaded template:
```
$tpl->load('tpl-file', $data);
// or
$tpl->get('tpl-file', $data)
… 
->render($extraData);
```
will make available any `$data` key as variable inside `tpl-file`
### To a simple node
```
// $bar = 'baz';
<div class="foo" :class="$bar">
// resulting <div class="foo baz">

<div class="foo" :class="bar">
// error, undefined constant `bar`
```
### To component (read below about components)
```
// $bar = 123
// $baz = [1,2,3];
<my-component foo="foo" :bar="$bar" :baz="$baz" :abc="['array']" />
// will make available in my-component the given variables.

<my-component @rows="5" @required="'required'"/>
// inside <my-component> we will have all @attrs available on $_attrs variable and may have a p-bind="$_attrs" syntax on a textarea node (for example) do dynamically pass attributes whitout requireing to manually declare the assignments.
// now, we can have in my-component a syntax like <textarea p-bind="$_attrs"> to produce <textarea rows="5" required="required">
```
### To slot (read below about slots)
```
// my-component.template.php
@php
  $foo = 123;
@endphp
<div>
    <slot :foo="$foo" bar="bar" :baz="$baz"></slot>
</div>

// app.template.php
<my-component :baz="5">
    <div>
        {{ $foo }} and {{ $bar }} {{ $baz }} available here
    </div>
</my-component>
```
### Global Share data
```
$tpl->shareData($data);
// will make $data key variables available to any template file (with low precedence, meaning those variables may be overriden by codeflow passed params)
```
### Composing data for specific components
```
<tpl is="file-name" foo="123">

$tpl->dataComposer('file-name', function($data) {
    // $data is an array containing attributes passed to the file-name invocation tag, in our case ['foo' => 123]
    // extra processing here
    return [… extra-data as key => value]
});
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
You may create your own parse rules using `Config::setDirective()`. Directives are functions which returns arrays of `attr -> value` which will be attached to Node before parsing it.
```
$cfg = $tpl->getConfig();
$cfg->setDirective('checked', function($eval) {
    return [
        'p-raw' => $eval.' ? "checked" : ""' // like <node p-raw="$eval ? 'checked' : ''" />
    ];
    // p-raw is a built in directive which says: print me only value (HTMLT5 attrs like)
});
// OR
$cfg->setDirective('auth', function() {
    return [
        'p-if' => $isAuthCheck // like <node p-if="$isAuthCheck" />
    ];
});
```
Now we can use our directive like this:
```
<input type="checkbox" p-checked="1 < 3">
<input p-auth>
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
<tpl is="components/form-group" type="text" name="string" :value="$value = 'any php expression'" @required="'required'" />
```
Every component will be mapped on current rendering process and will be reused in case of second call with the given node attributes as parameters.

Each attribute passed on a component node will be included in one associative array which will be extracted in component function scope to be available there. Attributes passed with bind syntax (`:`) will be evaluated as php variables/syntax. Attributes passed without bind syntax will be treated as strings.
Please notice `p-bind="$_attrs"` - is a built in syntax which says that `<input` will receive as attributes all attributes passed using `@attr="value"` syntax. To be noted that this syntax is evaluated as php, so don't put strings without quote as values.
You can also have control structures on components nodes.

### Component aliasing
If you have an extensivelly used component, you can alias it by calling `Config::set('aliased', $what)`
```
$cfg = $tpl->getConfig();
$cfg->setAlias('form-group', 'components/form-group'); // array with key value supported too

// Now we can reffer to our component by this:
<form-group type="text" value="123"/>
```
!!! Disclaimer: ***Php-Templates*** won't protect you against infinite reccursivity, so avoid aliasing components to valid html tags like `<section>` component having another section as body tag.

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
No slot is required to be passed. Empty slots will render nothing and slots with default values (declared between `<slot></slot>` tag) will evaluate that value. To pass a node as value to a slot, you have to use `slot="{slot_name}"` attribute. That node will replace {slot_name} in our component context. Multiple nodes can fill the same slot name.

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
<tpl is="our_form">
    <form-group type="number" label="age" value="" _index="0"></form-group>
</tpl>

// between 
<tpl is="our_form">
    <form-group type="number" label="age" value="" _index="1.5"></form-group>
</tpl>

// as last element
<tpl is="our_form">
    <form-group type="number" label="age" value="" _index="3"></form-group>
</tpl>
```

## Extends
If you find yourself in a situation where a layout is too repetitive, and only the main part of the layout is different, `extends` feature comes in help. Imagine you have the main layout `layouts/app.template.php` which contains the scaffolding of your application:
```
// layouts/app.template.php
<html>
    <head>...</head>
    <body>
        <tpl_header/>
        <tpl_column_left/>
        <slot></slot>
        <tpl_footer/>
    </body>
</html>
```
Products, categories and many other pages will use the same structure. This can be simplified by declaring an html node wrapper representing extended template:
```
<tpl is="layout/app">
   specific html content of product page 
</tpl>
```
Now we just need to call 
```
$tpl->load('product', $data);
// and php-templates will do the rest
```
In the background, ***Php-Templates*** will create a `layout/app` template instance to which it will add the loaded template instance as the default slot. Keep in mind that you need to irigate above extended component with given data using bind syntax.
The extension is valid in any other situation given by using slots.

## Events
Events are a key point in the development of a modular interface and the thing that makes ***Php-Templates*** perfect for this. For now, events are parsing time only. Please keep in mind that template cache can't detect events attached nodes modifications in order to re-transpile, so you have to reset them manually. If you find yourself working on events based UI, you can enable debug mode `$tpl->debugMode = true;` and `$tpl->trackChanges = true;` to prevent overfilling dest folder with old cached files and to parse without cache (at each request).

The syntax that will be used to attach an event:
```
use PhpTemplates\DomEvent;

DomEvent::on('parsing', '{template_name}', function($node) {
    // you can manipulate $node here using syntaxes like: $node->querySelector('div')
    // appendChild('…html content string here')
    // insertBefore(newNode, $anotherNode)
    // insertAfter
    // detach()
});
```
Of course, this must be registered before template calling.
Examples may be found in [playground/form](https://github.com/florin-botea/php-templates/blob/dev/playground/form.php) may be used as sample of the power of this feature.