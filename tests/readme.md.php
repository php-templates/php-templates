<?php

require('../autoload.php');

use PhpTemplates\Config;
use PhpTemplates\EventHolder;
use PhpTemplates\Template;
use PhpTemplates\View;
use PhpTemplates\Dom\DomNodeAttr;

//header("Content-Type: text/plain");

ob_start();

//$dependenciesMap = new DependenciesMap('./dep.php', __DIR__.'/results/');
$eventHolder = new EventHolder();
$viewFactory = new Template(__DIR__, __DIR__.'/results' , ['debug' => true]);
$cfg = $viewFactory->getConfig();

$cfg->setAlias([
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-data-table' => 'components/data-table',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper',
    'x-tabs' => 'components/tabs',
]);

$cfg = $cfg->subconfig('cases2', __DIR__.'/cases2/');
$cfg->setAlias('x-form-group', 'components/form-group', 'cases2');
$cfg->setDirective('mydirective', function($node, $val) {
    $node->addAttribute(new DomNodeAttr('mydirective', 2));
});
$cfg->setDirective('guest', function($node, $val) {
    $node->addAttribute('p-if', 'empty($user)');
});
$cfg->setDirective('auth', function($node, $val) {
    $node->addAttribute('p-if', '!empty($user)');
});
$cfg->setDirective('active', function($node, $val) {
    $node->addAttribute(':class', "$val ? 'active' : ''");
});

function tstart()
{
    //ob_end_clean();
    ob_start();
}

function teval()
{
    global $viewFactory;
    $php = ob_get_contents();
    ob_end_clean();
    echo $php;
    eval($php);
}

function tresult($file, $data = '[]')
{
    global $viewFactory;
    $tpl = ob_get_contents();
    ob_end_clean();
    echo "
`// $file.t.php`\n$tpl";
    eval('$_data = '.$data.';');
    echo "
```
\$viewFactory->make('$file', $data)->render();
```";
    echo "\nwill result:\n
```
";
ob_start();
$viewFactory->makeRaw("\n".trim(str_replace('```', '', $tpl), "\n")."\n", $_data)->render();
$tpl = ob_get_contents();
ob_end_clean();
echo trim($tpl);
echo "\n```
";
    return $tpl;
}

?>

***Php-Templates*** is a template engine which goal is to bring full modularity into 'View' part of a web app. Unlike some PHP templating engines, ***Php-Templates*** does not restrict you from using plain PHP code and functions in your templates as a 'measure of security'. It gives you the freedom to organizes your templates as you wish. 
In fact, all templates are compiled into plain PHP code and cached until they are modified, meaning ***Php-Templates*** adds essentially zero overhead to your application, also it has a clear syntax due to the fact that control structures are placed as targeted tag attribute.

## Setting up
View files will have the `.t.php` extension and be placed in configured source path. They will be refered by their relative name, without extension and without source path prepended.

```
<\?php
use PhpTemplates\Config;
use PhpTemplates\EventHolder;
use PhpTemplates\Template;

// we set debug true to force discard any cached file for now
$viewFactory = new Template(__DIR__, __DIR__.'/cached', ['debug' => true]); 
$cfg = $viewFactory->getConfig();

$view = $viewFactory->makeRaw('<h1>Hello {{ $world }}</h1>', ['world' => 'Php Templates']);
$view->render();
```
```
<?php
$view = $viewFactory->makeRaw('<h1>Hello {{ $world }}</h1>', ['world' => 'Php Templates']);
$view->render();
?>

```

## Data interpolation
Like in most template engines, data is escaped against html entities and displayed using `{{ $var }}` syntax. You can use `{!! $var !!}` syntax in order to display raw, unescaped data.
The following:
<?php tstart(); ?>
```
<h1>{{ $h1 }}</h1>
```
<?php tresult(
'examples/hello',
'["h1" => "Hello Php Templates"]'); ?>

Unlike other template engines, interpolation is resumed only on text nodes.
The following syntax won't work:
<?php tstart(); ?>
```
<input type="text" value="{{ $value }}">
```
<?php tresult(
'examples/hello',
'["value" => "No value"]'); ?>

In order to bind values to node attributes, just write your attributes prefixed by ':'. We will further refer this syntax as 'bind'.
<?php tstart(); ?>
```
<input type="text" :value="$value">
```
<?php tresult(
'examples/hello',
'["value" => "No value"]'); ?>
In fact, the syntax above will be translated to `value="<php echo htmlentities($value); ?>"`, means you can replace `$value` with any valid php syntax.
<?php tstart(); ?>
```
<input type="text" :value="str_ireplace('no ', '', $value) . ' given'">
```
<?php tresult(
'examples/hello',
'["value" => "No value"]'); ?>

Class attribute is a special case, because we often have many of them, or we need to conditionate some of them. You can:
- give an array of values, ex: `:class="['class1', true ? 'class2' : '']"` and expect as result `class="class1 class2"`
- give an associative array where keys are attribute values and values are filter criteria, ex: `:class="['class3' => 1, 'class4' => 0]"` will result `class="class3"`;
Classes are cumulative, so having many attributes of them, will concatenate their values into a single class atrribute.

## Php syntax
In order to cover other features and to avoid any ambiguosity in parse process, template files are loaded using php 'require'. This means you cannot use php tags for declaring render time stuffs, like variables, function calls, etc. Instead, you can use `{% ... %}` tags, or single line tags `{% ... %}`
<?php tstart(); ?>
```
{% $text = 'Lorem ipsum'; %}
{% $name = 'fname'; %}
<input type="text" :value="$text" :name="$name">
<input type="text" value="{% echo 'this not gonna work'; %}" {% echo 'neither this'; %}>
```
<?php tresult(
'examples/hello'); ?>

If you wonder how then conditionally rendering attributes is possible, take a look at 'Directives' section. First, we have to cover control structures.

## Control structures
Allowed control structures are:
`if, elseif, else, foreach`
You can use them to conditionally render a node. Just add them as attribute on targeted node, prefixed with `p-`.
<?php tstart(); ?>
```
{% $inp = ['text', 'number', 'email']; %}
<input p-if="in_array($type, $inp)" :type="$type" :value="$value">
<input type="checkbox" p-elseif="$type == 'checkbox'" value="1">
<textarea p-else>{{ $value }}</textarea>
```
<?php tresult(
'examples/hello', "['type' => 'textarea', 'value' => 'Lorem']"); ?>

Here is a `foreach` example:
<?php tstart(); ?>
```
Do you like Php Templates?
<select>
   <option p-foreach="$options as $v => $lbl" :value="$v">{{ $lbl }}</option>
</select>
```
<?php tresult(
'examples/hello', "['options' => ['1' => 'Yes', '0' => 'No']]"); ?>

In Php Templates, loops are scoped, meaning that anything declared inside a loop, will stay in the loop and not be available outside of it. Also, anything from outside of the loop can't be overriden from inside the loop. In the above example, in a normal php script, `$lbl` and `$val` would be available below the loop. Not in this case:
<?php tstart(); ?>
```
{% $lbl = 'I will survive!!!'; %}
<select>
   <option p-foreach="$options as $v => $lbl" :value="$v">{{ $lbl }}</option>
</select>
{{ $lbl . $val }}
```
<?php tresult(
'examples/hello', "['options' => ['1' => 'Yes', '0' => 'No']]"); ?>

## Directives
Directives are 'parsing phase' commands and are usefull when you need to declare complex logic under a small alias. They are node attributes prefixed with 'p-', like control structures.

### Built-in directives
`raw` - usefull when you need to conditionally render content on a tag declaration:
<?php tstart(); ?>
```
<div class="card" p-raw="$condition ? 'style=\"width: 18rem;\"' : ''"></div>
```
<?php tresult(
'examples/hello',
'["condition" => true]'); ?>
Please note that is IMPORTANT to escape nested quotes using backslash. Or just avoid it by using next directive (`bind`).
Using this directive on a component node will take no effect.

`bind` - declare node attributes inside an associative array. This is usefull if you need to conditionate rendering of some specific attributes.
<?php tstart(); ?>
```
<input p-bind="$attrs">
```
<?php tresult(
'examples/hello',
'["attrs" => [ "type" => "text", "name" => "name", "disabled"] ]'); ?>
As a matter of rendering performance, the limitation is that you cannot `bind` class attribute, or any attribute already declared on node.

`checked` - used on input type radio / checkbox
<?php tstart(); ?>
```
<input name="thecheckbox" type="checkbox" value="1" p-checked="!empty($thecheckbox)">
<input name="theradio" type="radio" value="1" p-checked="$theradio === 1">
<input name="theradio" type="radio" value="0" p-checked="$theradio === 0">
```
<?php tresult(
'examples/hello',
'["theradio" => 1]'); ?>

`selected` - used on select input

<?php tstart(); ?>
```
<select name="fruits">
    <option p-foreach="$options as $val => $label" :value="$val" p-selected="$val == $value">{{ $label }}</option>
</select>
```
<?php tresult(
'examples/hello',
'["options" => ["a" => "avocado", "b" => "banana", "c" => "cherry"], "value" => "b"]'); ?>

`disabled` - used to apply attribute `disabled`
<?php tstart(); ?>
```
<input type="text" p-disabled="3 > 2">
```
<?php tresult(
'examples/hello'); ?>


### Custom directives

Directives are dispatched before any node attribute be parsed. So, basically, they are populating the DomNode with attributes which becomes parsed. You can declare your own custom directives like this:

```
$cfg->setDirective('guest', function($node, $val) {
    $node->addAttribute('p-if', 'empty($user)');
});
$cfg->setDirective('auth', function($node, $val) {
    $node->addAttribute('p-if', '!empty($user)');
});
$cfg->setDirective('active', function($node, $val) {
    $node->addAttribute(':class', "$val ? 'active' : ''");
});
```
Now, the following:
<?php tstart(); ?>
```
<div p-guest>Guest</div>
<div p-auth>Auth</div>
<div p-active="3 < 4"></div>
```
<?php tresult(
'examples/hello'); ?>

Note that `$val` param passed to callback function is the string value of the directive attribute, in our case `3 < 4`.
You can learn more about DomNode manipulation at Working with DOM section.

## Entities
### Components
You can reuse parts of design by making them components. Just put the html code into another file in your source path in any folder structure you preffer. For example, you can have:
// components/form-group.t.php
```
{%
$_attrs = $_context->except(['label','class']); // this will take any passed attribute not in listed array
%}
<div class="form-group" :class="!empty($class) ? $class : ''">
    <label class="form-label">{{ $label }}</label>
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
    <span p-if="!empty($error)" class="error">{{ $error }}</span>
</div>
```

and use it like this:
<?php tstart(); ?>
```
<tpl is="components/form-group" type="text" :label="$label" :value="$value" />
```
<?php tresult(
'examples/hello', '[ "label" => "The Label", "value" => "The Value" ]'); ?>

Components will have their own scope (no access to upper context of values) so you have to irrigate them with data. You can pass values to componenent context in 3 ways:
- simple attribute: will be passed as string value, ex.: `value="somevalue"`
- bind syntax: php syntax accepted, ex.: `:value="$value"`, or `:value="'The value'"`
- bind attribute: using `p-bind` directive, which accepts an array of attributes
You can also have control structures on components nodes.
When working with multiple namespaces configs (`$viewFactory->subConfig($name='cfg2', $sourcePath)`) and your  has a component with same name, for example `form-group`:
- form-group
- cfg2:form-group
- cfg2:some-file
If you refer `form-group` in `cfg2:some-file`, you will get default one. You can instruct php-templates that you want local config template like this `<tpl is="cfg2:form-group"` or like this `<tpl is="@form-group"` (`@` will tell php-templates to look for a specific component in current config path, with fallback on default path).

#### Components aliasing
You can alias components into custom tags like this:
```
$cfg->setAlias([
    'x-form-group' => 'components/form-group',
]);
```
Now, we can use our component:
```
instead of this
<tpl is="components/form-group" type="text" :label="$label" value="$value" />
like this
<x-form-group type="text" :label="$label" value="$value" />
```
!!! Disclaimer: ***Php-Templates*** won't protect you against infinite reccursivity, so avoid aliasing components to valid html tags like `<section>` component having another section as body tag.

### Slots
Slots increases a component reusability by leting us to control a defined layout from outside. Slots may have default content as child node, which will be rendered when no slot defined. Slots may be named, or default. 
Slots are sub-scoped:
- compiled outside the component in which they are passed
- having access to variables declared in this 'outside' scope, but cannot modify them
Considering our form-group component with slots would be:
components/form-group.t.php
```
<div class="form-group" :class="!empty($class) ? $class : ''">
    <slot name="label"><!-- this is a named slot, with default content -->
        <label class="form-label">{{ $label }}</label>
    </slot>
    <slot><!-- this is a main slot, with default content -->
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
```
Now, we can use it like this:
<?php tstart(); ?>
```
<x-form-group type="number" min="1">
    <span slot="label">Custom label <i class="fa fa-download"></i></span>
    <input type="number" class="form-control"><!-- same as
    <input type="number" slot="default" class="form-control"> -->
</x-form-group>
```
<?php tresult('examples/hello'); ?>

No slot is required to be passed. Empty slots will render nothing and slots with default values (declared between `<slot></slot>` tag) will evaluate that value. Multiple nodes can fill the same slot name.

#### Scoped Slots Data
Consider you have a component responsable for rendering a table:
//components/data-table.t.php
```
<div class="table-wrapper">
    <table>
        <thead>
            <th p-foreach="$headings as $heading">{{ $heading }}</th>
            <th p-if="$this->slots('action')">Action</th>
        </thead>
        <tbody>
            <tr p-foreach="$data as $i => $item">
                <td p-foreach="$headings as $k => $v">{{ $item[$k] }}</td>
                <slot name="action" :id="$item['id']" :i="$i"></slot>
            </tr>
        </tbody>
    </table>
</div>
```
Two things here:
- we checked if any slot passed by calling `$this->slots($slotName)`
- we passed some data on slot node declaration ($id and $i), then we can access this values outside component, like this `$slot->varName`
Now, we can use the component like this:
<?php tstart(); ?>
```
<x-data-table :headings="$headings" :data="$data">
    <div slot="action">
        <a :href="'edit-item-'.$slot->id">Edit</a>
    </div>
</x-data-table>
```
<?php tresult('examples/hello',
"[
'headings' => [
    'id' => 'ID',
    'name' => 'Name'
],
'data' => [
    ['id' => 67, 'name' => 'Mango'],
    ['id' => 32, 'name' => 'Potatos'],
]]"); ?>

## Extends
Consider we have a main layout:
// layouts/app.t.php
```
<htm>
    <head>… </head>
    <body>
        … {{ $var }}
        <slot></slot>
    </body>
</htm>
```
Now, we can have all our templates extending it, like this:
<?php tstart(); ?>
```
<tpl extends="layouts/app">
    <div class="card">… {{ $var }}</div>
</tpl>
```
<?php tresult('examples/hello', "['var' => 'I am shared with my parent']"); ?>
As you can see, extended template shares the same context with the child, means it can have access to child variables/child automatically binds variables to parent.

## Global Shared data
You can use the following method on TemplateFactory instance to share a value across all templates (nested, extended, components or not) built by it:
<?php $viewFactory->share('shared', 'I share because I care'); ?>
```
<\?php
$viewFactory->share('shared', 'I share because I care');
```
<?php tstart(); ?>
```
<div class="card">… {{ $shared }}</div>
```
<?php tresult('examples/hello'); ?>
Shared data have low precedence, meaning they are there, only if they are not overriden by another value with the same label (variable name).

## Composing data
You may have pieces of UI in your app which may repeat on different pages and you may feel tired of building the data for each one.
Here is a filtered list:
// components/filtered-list.t.php
```
<ul>
    <li p-foeach="$items as $item">{{ $item }}</li>
</ul>
```
then we register a composer:
```
<\?php $viewFactory->composer('components/filtered-list', function($attrs) {
    $fruits = ['avocado', 'banana', 'cherry', 'berry'];
    // you can have sql here too
    if ($attrs->sort == 'DESC') {
        rsort($fruits);
    }
    elseif ($attrs->sort == 'ASC') {
        sort($fruits);
    }
    $attrs->items = $fruits;
});
```
<?php $viewFactory->composer('components/filtered-list', function($attrs) {
    $fruits = ['avocado', 'banana', 'cherry', 'berry'];
    // you can have sql here too
    if ($attrs->sort == 'DESC') {
        rsort($fruits);
    }
    elseif ($attrs->sort == 'ASC') {
        sort($fruits);
    }
    $attrs->items = $fruits;
}); ?>
now, calling our component like this:
<?php tstart(); ?>
```
<tpl is="components/filtered-list" sort="ASC" />
<!-- or like this -->
<tpl is="components/filtered-list" sort="DESC" />
```
<?php tresult('examples/hello'); ?>

## Events
Each template is transformed into a virtual DOM then semantically parsed from top to bottom, entering in each child node. This empowers Php Templates with ability to intervents in parsing process and manipulate DOM in a close to JavaScript flexibility (add, remove, edit node).
There are three ways of doing this:
### Parsing moment
We have our form:
form.t.php
```
<form action="action">
    <x-form-group type="text" name="firstname" label="Firstname" />
    <x-form-group type="text" name="lastname" label="Lastname" />
    <x-form-group type="text" name="city" label="City" />
</form>
```
Now we add an event listener:
```
<?php tstart(); ?>
$viewFactory->on('parsing', 'form', function($node) {
    // any css selector here
    $node->querySelector('form')
    ->appendChild('<x-form-group type="text" name="zipcode" label="Zipcode" />');
    $city = $node->querySelector('form [name="city"]');
    $node->querySelector('form')
    ->insertBefore('<x-form-group type="number" name="age" label="Age" />', $city);
    $city->detach();
    // see Working with DOM section for more details
});
<?php teval(); ?>
```
and when we call our template (direct, or nested):
<?php tstart(); ?>
$viewFactory->render('form', []);
<?php teval(); ?>
Because of cache system, parsing events are impossible to be tracked for changes to recompile the code. You have to reset them manually by deleting cached files, or better, pass null as cache path on Template instancing. This will parse templates on each request without caching them (do this only during development).

### On Rendering time
Let it be our last sorted list:

```
<tpl is="components/filtered-list" sort="ASC" />
```
add event
```
<?php tstart(); ?>
$viewFactory->on('rendering', 'components/filtered-list', function($context) {
    $context->items[] = 'added';
});
<?php teval(); ?>
```
and the call:
<?php tstart(); ?>
```
<tpl is="components/filtered-list" sort="ASC" />
```
<?php tresult('examples/hello'); ?>
pretty usefull if you want to add data on fly

### Self events
When you declare a template which will suppose to be a component, you may return a php function which will be called as callback before template parse.
This feature is usefull if you have components which have script/css/cdn dependencies and you want to keep them grouped together.
We may have our form group to accept images with preview:
```
<div class="form-group row mb-3">
    <label :for="$id ?? $name ?? ''" class="control-label col-sm-3">
        {{ $label ?? $name ?? '' }}
    </label>
    <div class="col-sm-9">
        <img p-if="!empty($preview) && $type == 'file'" :src="$value ?? ''" class="img-fluid pb-2">
        <slot>
            <input p-if="$type == 'file'" type="file" :id="$id ?? $name ?? ''" :name="$name" :value="$value" p-bind="$_attrs" class="form-control" :class="!empty($preview) ? 'preview' : ''">
            ...
        </slot>
        <p p-if="isset($error) && $error" class="text-danger">{{ $error }}</p>
    </div>
</div>

<script id="moveMe">
$(document).on("change", 'input[type="file"].preview', function() {
    const [file] = this.files
    if (file) {
       $(this).prev("img").attr("src", URL.createObjectURL(file));
    }
});
</script>

<\?php return function($node, $eventHolder) {
    $script = $node->querySelector('#moveMe')->detach()->removeAttribute('id');
    $eventHolder->on('parsed', 'layouts/*', function($node) use ($script) {
        $node->querySelector('head')->appendChild($script);
    });
} ?\>
```
Events may be declared eliptic in name using *, (meaning anything except '/').
Events declaration may accept a weight as 4'th argument which will define listener execution order (high to low).
In the above example, we needed to detach the $script and keep a reference of it, because in event callback would be too late because the component would be already transformed to template function at that point and any change made would take no effect. Also, layout rendering event was triggered before this point.

# DomNode and Dom manipulation
PhpTemplates parses every template into a virtual dom, then reccursively traverse each node to handle semantic syntaxes/nodes. At the end, the dom is saved into a valid tpl format. This makes PhpTemplates different from other template engines. You can hook anywhere in the dom and insert whatever element you want, modify or delete dom elements.
Each node is a DomNode object class. We will list below the class methods you can use.

### `__construct(string $nodeName, $nodeValue = '')`
Constructs a DomNode instance, like div, span, etc.
$nodeName - tag name. In case of textnode, prefix `$nodeName` with '#' and name it as you wish
$nodeValue - if textnode, it should be string. If domNode, it can be a key => value array containing attributes (ex: ['class' => 'foo bar'])

### static `fromString(string $str)`
Create a new DOM structure from a given string, ex: `<div><span>Hello</span> World</div>`
This fn will try to capture its call location in order to give relevant data for debugging

### `addAttribute($nodeName, string $nodeValue = '')`
Add an attribute to node in append mode (if an attribute class exists on node and you call `addAttribute('class', 'class2')`, it will add this class too)
$nodeName - string|DomNodeAttr
$nodeValue - string


### `setAttribute(string $nodeName, string $nodeValue = '')`
Add an attribute to node. If an already existing attribute will be found by given name, its value will be overriden

### `getAttribute(string $name)`
Returns node attribute value by attribute name, null if no attribute found

### `hasAttribute(string $name)`
Determine if an attribute exists on current node, by its name

### `removeAttribute(string $name): self`
Remove node attribute, return node instance

### `removeAttributes()`
Remove all node attributes

### `appendChild($node)`
Append a new child node to current node and returns appended child instance.
If appended node already exists in this node flow, it will throw an error to prevent infinite recursion

### `insertBefore($node, self $refNode)`
Insert a child node before another given childnode
If appended node already exists in this node flow, it will throw an error to prevent infinite recursion

### `insertAfter($node, self $refNode)`
Insert a child node after another given childnode
If appended node already exists in this node flow, it will throw an error to prevent infinite recursion


### `removeChild(self $node)`
Remove given childnode

### `empty()`
Remove all childnode

### `detach()`
Remove childnode from its parent and returns it available to be attached (insert,append) elsewhere

### `cloneNode()`
Returns an exact node clone, excluding its parent

### `getPrevSibling()`
Returns previous sibling

### `getNextSibling()`
Returns next sibling

### `querySelector(string $selector)`
Non complex css selectors supported
Supported selectors are:
.class	(ex: .intro)	- Selects all elements with class="intro"
.class1.class2 (ex: .name1.name2) - Selects all elements with both name1 and name2 set within its class attribute
.class1 .class2	(ex: .name1 .name2)	- Selects all elements with name2 that is a descendant of an element with name1
\#id	(ex: #firstname) - Selects the element with id="firstname"
element	(ex: p) - Selects all &lt;p&gt; elements
element.class (ex: p.intro) - Selects all &lt;p&gt; elements with class="intro"
element element	(ex: div p) - Selects all &lt;p&gt; elements inside &lt;div&gt; elements
element>element	(ex: div > p) - Selects all &lt;p&gt; elements where the parent is a &lt;div&gt; element
element+element	(ex: div + p) - Selects the first &lt;p&gt; element that is placed immediately after &lt;div&gt; elements
element1~element2 (ex: p ~ ul) - Selects every &lt;ul&gt; element that is preceded by a &lt;p&gt; element
[attribute]	(ex: [target="value"]) - Selects all elements with a target attribute having value 'value'

### `querySelectorAll(string $selector)`
Returns any node found which match the given selector
Non complex css selectors supported

<?php
$md = ob_get_contents();
file_put_contents(__DIR__ . '/../readme.md', trim($md));
?>