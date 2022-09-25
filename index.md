## Introduction
Php-templates is a template engine based on [HTML5DOMDocument](https://github.com/ivopetkov/html5-dom-document-php). Unlike some PHP templating engines, Php-templates does not restrict you from using plain PHP code in your templates. In fact, all Php-templates templates are compiled into plain PHP code (functional templating) and cached until they are modified, meaning Php-templates adds essentially zero overhead to your application, also it has a clear syntax due to the fact that control structures are placed as targeted tag attribute, like in React/Vue.js syntax. Php-templates template files use the `.template.php` file extension and stored in `src_path` configured path and they are parsed and 'cached' in `dest_path` in plain path mode (`foo/bar.template.php` will cached as `foo_bar_{hash}.php`). 

Each template will become a closure function indexed on Template global object by its name path, but all of these are Php-templates job. You just have to call `PhpTemplates\PhpTemplate::load({path}, $data)` (path will be relative to `src_path`, without extension `template.php`) to render it. If you only want a template instance to render it later, you can call `Template::get({path}, $attrs)`, then call `render($data)`. `$attrs` will be described later, in Components section.

## Displaying data
Like in most template engines, data is escaped against html entities and displayed using `{{}}`. You can anytime call php pure echo in order to display raw data.
Html nodes ttributes are set using `:` bind syntax.
The following:
```markdown 
<div class="card" :class="$myVar" :class="$foo === 1 ? 'active' : ''"></div>
```
will produce:
```markdown 
<div class="card <?php echo $myVar; ?> <?php echo $foo === 1 ? 'active' : ''; ?>"></div>
```

As you can see, any valid continuing `echo ` php syntax is allowed between "" -> :attr="echo {php_syntax}".

## Control structures
You can place any of this allowed control structures prefixed with `p-` as attribute of the node you want to control.
The following:
```markdown
<div class="item" p-foreach="$items as $item" p-if="$item['status'] === 'active'">{{ $item['name'] }}</div>
```
will produce:
```markdown
<?php foreach ($items as $item") {
    if ($item['status'] === 'active') { ?>
        <div class="item"><?php echo htmlspecialchars($item['name']); ?></div>
    <?php } ?>
<?php } ?>
```

As you can see, control structures can be combined in many ways, even multiple `foreach` on same node. There is no operator precedence, but order of attributes matters, especially when one loop deppends of variables set by the parent loop.

## Components
You can reuse parts of design by making them components. Just put the html code into another file in `src_path` in any folder structure you preffer. For example, you can have src_path + `components/form-group.template.php`:
```markdown
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
```markdown
<tpl is="components/form-group" type="text" name="will_be_passed_as_string" $value="$any_valid_php = ['even_array_declaration']" required="required" />
```
Every component will be mapped on a global object and will be reused in case of second call with the given node attributes as parameters.
Each attribute will be included in one associative array which will be extracted() in component function scope to be available there.
`p-bind="$_attrs"` is a special syntax which says that `<input` will receive as attributes all `$key => $value` of $data that was not used in template. In our case, form-group has not used var $required, so this value will be passed to input.
You can also have control structures on components nodes.

### Component aliasing
If you have an extensivelly used component, you can alias it by calling `PhpTemplates/Config::set('aliased', ['form-group' => 'components/form-group'])`
Now we can reffer to our component by this:
```markdown
<form-group type="text"/>
```
!!! Disclaimer: php-templates won't protect you against infinite reccursivity, so avoid aliasing components to valid html tags like `<section>` component having another section as body tag.

## Slots
Slots increases a component reusability by leting us to control a defined component layout from outside.
Considering our form-group component with slots would be:
```markdown
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
```markdown
<form-group type="text" [other attrs]>
    <span slot="label">Custom label <i class="fa fa-download"></i></span>
    <input type="number" slot="default">
</form-group>
```
No slot is required to be passed. Empty slots will render nothing and slots with default values (declared between `<slot></slot>` tag) will evaluate that value. To pass a node as value to a slot, you have to use `slot="{slot_name}"` attribute. That node will replace {slot_name} in our component context.

## Blocks
Blocks are declared with `<block name="{block_name}">nodes here</block>` syntax. A block name is required. They work the same as a slot, they are treated like slots, but with 2 differences:
- passing a node as value to a block will not override default nodes, but push to them.
- blocks direct childnodes are indexed incrementally starting from 1. When you pass a node to a block, you can specify an `_index="int|float"` attribute (default is 0). Blocks will sort ascending its direct nodes using that _index value.
Lets have an example:
```markdown
// our_form.template.php
<div class="card">
    <form-group type="text" label="name" value=""></form-group>
    <form-group type="email" label="email" value=""></form-group>
</div>
```
Considering that our form groups are indexed as name => 1, email="2", you can pass a new form group/element at any position as block direct childnode:
```markdown
<tpl is="our_form">
    <form-group type="number" label="age" value="" _index="{0(-default),1.5(-middle),3(-last)}"></form-group>
</tpl>
```

## Extends
If you find yourself in a situation where a layout is too repetitive, and only the main part of the layout is different, `extends` feature comes in help. Imagine you have the main layout `layouts/app.template.php` which contains the scaffolding of your application:
```markdown
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
Products, categories and many other pages will use the same structure. This can be simplified by declaring an html node `<extends template="layout/app"/>` at the beginning of the files that represent these pages. Now we just need to call `PhpTemplates\PhpTemplate::load('product' | 'category', $data)`.  In the background, Php-templates will create a `layout/app` template instance to which it will add the loaded template instance as the default slot. Also, both templates have access to the data passed as a parameter.
The extension is valid in any other situation.  All that is required is a default slot on the parent template and its data requirements to be met.

## Events
Events are a key point in the development of a modular interface and the thing that makes Php-templates perfect for this. Events are executed before rendering a component, template or a block can be listened and allow the alteration of the context in which they are executed (received data, received slots, order of rendered block items). Events can be general (attached to a template / component) or specific (eliptic or full path to targeted entity, mentioned separated with '.'). The syntax that will be used to attach an event `new PhpTemplates\DomEvent('rendering', '{event_name}', {listener_as_callback_function})`, or `DomEvent::on('rendering', '{event_name}', {listener_as_callback_function})` and must be placed before template calling.

On each rendering event, php-templates will keep a record of the current path consisting of the parent templates + the current template joined by '.'.
When logging an event, a hierarchical selection rule similar to css descendants selector (`body header .my_class1 .myclass_2 {}`) applies, except that the name represents the relative name of the templates. If the `false` value is returned on any event callback, the rendering of the template in question is canceled.

The examples found in [playground/form](https://github.com/florin-botea/php-templates/blob/dev/playground/form.php) will be used as documentation.