

***Php-Templates*** is a template engine which syntax is inspired from Vue.js. Unlike some PHP templating engines, ***Php-Templates*** does not restrict you from using plain PHP code in your templates. In fact, all templates are compiled into plain PHP code (functional templating) and cached until they are modified, meaning ***Php-Templates*** adds essentially zero overhead to your application, also it has a clear syntax due to the fact that control structures are placed as targeted tag attribute, like in React/Vue.js syntax.

## Setting up
Template files will have the `.t.php` extension and be placed in configured source path. They will be refered by their relative name, without extension and without source path prepended.

```
<\?php
use PhpTemplates\Config;
use PhpTemplates\ConfigHolder;
use PhpTemplates\EventHolder;
use PhpTemplates\ViewFactory;

$cfg = new Config('default', __DIR__);
$cfgHolder = new ConfigHolder($cfg);
$eventHolder = new EventHolder();
$viewFactory = new ViewFactory(__DIR__.'/cached', $cfgHolder, $eventHolder);

$view = $viewFactory->makeRaw('<h1>Hello {{ $world }}</h1>', ['world' => 'Php Templates']);
$view->render();
```
```
<h1>Hello Php Templates</h1> 
```

## Data interpolation
Like in most template engines, data is escaped against html entities and displayed using `{{ $var }}` syntax. You can use `{!! $var !!}` syntax in order to display raw, unescaped data.
The following:
// examples/hello.t.php
```
    <h1>{{ $h1 }}</h1>
```

```
    $viewFactory->make('examples/hello', ["h1" => "Hello Php Templates"])->render();
```
will result:

```
<h1>Hello Php Templates</h1> 
```

Unlike other template engines, interpolation is resumed only on text nodes.
The following syntax won't work:
// examples/hello.t.php
```
    <input type="text" value="{{ $value }}">
```

```
    $viewFactory->make('examples/hello', ["value" => "No value"])->render();
```
will result:

```
<input type="text" value="{{ $value }}"> 
```

In order to bind values to node attributes, just write your attributes prefixed by ':'.
// examples/hello.t.php
```
    <input type="text" :value="$value">
```

```
    $viewFactory->make('examples/hello', ["value" => "No value"])->render();
```
will result:

```
<input value="No value" type="text"> 
```
In fact, the syntax above will be translated to 'value="<\?php echo $value; ?>"', means you can replace '$value' with any valid php syntax.
// examples/hello.t.php
```
    <input type="text" :value="str_ireplace('no ', '', $value) . ' given'">
```

```
    $viewFactory->make('examples/hello', ["value" => "No value"])->render();
```
will result:

```
<input value="value given" type="text"> 
```

## Php syntax
In order to cover other features and to avoid any ambiguosity, template files are loaded using 'require(template)'. This means you cannot use php tags for declaring render time stuffs, like variables, function calls, etc. Instead, you can use @php ... @endphp tags.
// examples/hello.t.php
```
    @php $text = 'Lorem ipsum'; @endphp
    <input type="text" :value="$text">
    <input type="text" value="@php echo 'this not gonna work'; @endphp" @php echo 'neither this'; @endphp>
```

```
    $viewFactory->make('examples/hello', [])->render();
```
will result:

```
<input value="Lorem ipsum" type="text">
<input type="text" value="@php echo 'this not gonna work'; @endphp" @php echo 'neither this'; @endphp> 
```

If you wonder how then conditionally rendering attributes is possible, take a look at 'Directives' section. First, we have to cover control structures.

## Control structures
Allowed control structures are:
`if, elseif, else, for, foreach`
You can use them to conditionally render a node. Just add them as attribute on targeted node, prefixed with 'p-'.
// examples/hello.t.php
```
    @php $inp = ['text', 'number', 'email']; @endphp
    <input p-if="in_array($type, $inp)" :type="$type" :value="$value">
    <input type="checkbox" p-elseif="$type == 'checkbox'" value="1">
    <textarea p-else>{{ $value }}</textarea>
```

```
    $viewFactory->make('examples/hello', ['type' => 'textarea', 'value' => 'Lorem'])->render();
```
will result:

```
<textarea>Lorem</textarea>

```

Here is a foreach example:
// examples/hello.t.php
```
   Do you like Php Templates?
   <select>
       <option p-foreach="$options as $v => $lbl" :value="$v">{{ $lbl }}</option>
   </select>
```

```
    $viewFactory->make('examples/hello', ['options' => ['1' => 'Yes', '0' => 'No']])->render();
```
will result:

```
   Do you like Php Templates?
<select>
  <option value="1">Yes</option>
  <option value="0">No</option>
  </select> 
```

In Php Templates, inspired by Twig, loops are scoped, meaning that anything declared inside a loop, will stay in the loop and not be available outside of it. Also, anything from outside of the loop can't be overriden from inside the loop. In the above example, in a normal php script, $lbl and $val would be available below the loop. Not in this case:
// examples/hello.t.php
```
   @php $lbl = 'I will survive!!!'; @endphp
   <select>
       <option p-foreach="$options as $v => $lbl" :value="$v">{{ $lbl }}</option>
   </select>
   {{ $lbl . $val }}
```

```
    $viewFactory->make('examples/hello', ['options' => ['1' => 'Yes', '0' => 'No']])->render();
```
will result:

```
<select>
  <option value="1"><br />
<b>Warning</b>:  Undefined property: PhpTemplates\Context::$lbl in <b>/storage/emulated/0/dev/exegeza/vendor/florin-botea/php-templates/src/Context.php</b> on line <b>43</b><br />
</option>
  <option value="0"><br />
<b>Warning</b>:  Undefined property: PhpTemplates\Context::$lbl in <b>/storage/emulated/0/dev/exegeza/vendor/florin-botea/php-templates/src/Context.php</b> on line <b>43</b><br />
</option>
  </select>
   I will survive!!!
```

## Directives
Directives are parsing time commands and are usefull when you need to declare complex logic under a small alias. They are DOMNode attributes prefixed with 'p-', like control structures.

### Built-in directives
`raw` - usefull when you need to conditionally render content on a tag declaration:
// examples/hello.t.php
```
    <div class="card" p-raw="$condition ? 'style=\"width: 18rem;\"' : ''"></div>
```

```
    $viewFactory->make('examples/hello', ["condition" => true])->render();
```
will result:

```
<div class="card" style="width: 18rem;"></div> 
```
Please note that is IMPORTANT to escape nested quotes using backslash.

`bind` - declare node attributes inside an associative array. This is usefull if you need to conditionate rendering of some specific attributes.
// examples/hello.t.php
```
    <input p-bind="$attrs">
```

```
    $viewFactory->make('examples/hello', ["attrs" => [ "type" => "text", "name" => "name", "disabled"] ])->render();
```
will result:

```
<input type="text" name="name" disabled> 
```

`checked` - used on input type radio / checkbox
// examples/hello.t.php
```
    <input name="thecheckbox" type="checkbox" value="1" p-checked="!empty($thecheckbox)">
    
    <input name="theradio" type="radio" value="1" p-checked="$theradio === 1">
    <input name="theradio" type="radio" value="0" p-checked="$theradio === 0">
```

```
    $viewFactory->make('examples/hello', ["theradio" => 1])->render();
```
will result:

```
<input name="thecheckbox" type="checkbox" value="1" >
<input name="theradio" type="radio" value="1" checked>
<input name="theradio" type="radio" value > 
```

`selected` - used on select input

// examples/hello.t.php
```
    <select name="fruits">
        <option p-foreach="$options as $val => $label" :value="$val" p-selected="$val == $value">{{ $label }}</option>
    </select>
```

```
    $viewFactory->make('examples/hello', ["options" => ["a" => "avocado", "b" => "banana", "c" => "cherry"], "value" => "b"])->render();
```
will result:

```
<select name="fruits">
  <option value="a" >avocado</option>
  <option value="b" selected="selected">banana</option>
  <option value="c" >cherry</option>
  </select> 
```

`disabled` - used to apply attribute `disabled`
// examples/hello.t.php
```
    <input type="text" p-disabled="3 > 2">
```

```
    $viewFactory->make('examples/hello', [])->render();
```
will result:

```
<input type="text" disabled> 
```


### Custom directives

Directives are dispatched before any node attribute be parsed. So, basically, they are populating the DomNode with attributes which become parsed. You can declare your own custom directives like this:

```
$cfg->addDirective('guest', function($node, $val) {
    $node->setAttribute('p-if', 'empty($user)');
});
$cfg->addDirective('auth', function($node, $val) {
    $node->setAttribute('p-if', '!empty($user)');
});
$cfg->addDirective('active', function($node, $val) {
    $node->addAttribute(':class', "$val ? 'active' : ''");
});
```
Now, the following:
// examples/hello.t.php
```
    <div p-guest>Guest</div>
    <div p-auth>Auth</div>
    <div p-active="3 < 4"></div>
```

```
    $viewFactory->make('examples/hello', [])->render();
```
will result:

```
<div p-guest>Guest</div><div p-auth>Auth</div>
<div p-active="3 < 4"></div> 
```

Note that `$val` param passed to callback function is the string value of the directive attribute, in our case `3 < 4`.
You can learn more about DomNode manipulation at Working with DOM section.

## Entities
### Components
You can reuse parts of design by making them components. Just put the html code into another file in `src_path` in any folder structure you preffer. For example, you can have:
// components/form-group.t.php
```
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
// examples/hello.t.php
```
    <template is="components/form-group" type="text" :label="$label" @value="$value" />
```

```
    $viewFactory->make('examples/hello', [ "label" => "The Label", "value" => "The Value" ])->render();
```
will result:

```
  <div class="form-group ">
                  <label class="form-label">The Label</label>
                      <input placeholder="The Label" type="text" class="form-control" value="The Value">
              </div> 
```
You can pass values to componenent context in 3 ways:
- simple attribute: will be passed as string value, ex.: value="somevalue"
- bind syntax: php syntax accepted, ex.: :value="$value", or :value="'The value'"
- bind attribute: php syntax accepted, ex: @value="$value", or @value="'The value'". Those attributes passed like this will be gathered in an associative array under $_attrs variable in component scope. Combining this with p-bind directive helps you fill targeted node with attributes from component's outside, without explicitly declare each one.
You can also have control structures on components nodes.

#### Components aliasing
You can alias components into custom tags like this:
```
$cfg->addAlias([
    'x-form-group' => 'components/form-group',
]);
```
Now, we can use our component:
```
    instead of this
    <template is="components/form-group" type="text" :label="$label" @value="$value" />
    like this
    <x-form-group type="text" :label="$label" @value="$value" />
```
!!! Disclaimer: ***Php-Templates*** won't protect you against infinite reccursivity, so avoid aliasing components to valid html tags like `<section>` component having another section as body tag.

### Slots
Slots increases a component reusability by leting us to control a defined layout from outside. Slots may have default content as child node, which will be rendered when no slot defined. Slots may be named, or default.
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
// examples/hello.t.php
```
<x-form-group type="number" @min="1">
    <span slot="label">Custom label <i class="fa fa-download"></i></span>
    <input type="number" class="form-control"><!-- same as 
    <input type="number" slot="default" class="form-control"> -->
</x-form-group>
```

```
    $viewFactory->make('examples/hello', [])->render();
```
will result:

```
  <div class="form-group ">
        <span>Custom label
      <i class="fa fa-download"></i></span>
      <input type="number" class="form-control">
  <!-- same as
      <input type="number" class="form-control">
   -->
    </div> 
```

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
                <tr p-foreach="$data as $i => $_data">
                    <td p-foreach="$headings as $k => $v">{{ $_data[$k] }}</td>
                    <slot name="action" :id="$_data['id']" :i="$i"></slot>
                </tr>
            </tbody>
        </table>
    </div>
```
Two things here:
- we checked if any slot passed by calling $this->slots($slotName)
- we passed some data on slot node declaration ($id and $i), then we can access this values outside component, like this 'p-scope="$slot"' (whatever var name you preffer)
Now, we can use the component like this:
// examples/hello.t.php
```
<x-data-table :headings="$headings" :data="$data" p-scope="$slot">
    <div slot="action">
        <a :href="'edit-item-'.$slot->id">Edit</a>
    </div>
</x-data-table>
```

```
    $viewFactory->make('examples/hello', [
'headings' => [
    'id' => 'ID',
    'name' => 'Name'
], 
'data' => [
    ['id' => 67, 'name' => 'Mango'],
    ['id' => 32, 'name' => 'Potatos'],
]])->render();
```
will result:

```
  <div class="table-wrapper">
    <table>
      <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
              </thead>
      <tbody>
                  <tr>
            <td>67</td>
            <td>Mango</td>
                <div><a href="edit-item-67">Edit</a>
    </div>
            </tr>
                  <tr>
            <td>32</td>
            <td>Potatos</td>
                <div><a href="edit-item-32">Edit</a>
    </div>
            </tr>
              </tbody>
    </table>
  </div> 
```

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
// examples/hello.t.php
```
<template extends="layouts/app">
    <div class="card">… {{ $var }}</div>
</template>
```

```
    $viewFactory->make('examples/hello', ['var' => 'I am shared with my parent'])->render();
```
will result:

```
  <htm><head>… </head><body>
        … I am shared with my parent<div class="card">… I am shared with my parent</div>
  </body>
  </htm> 
```
As you can see, extended template shares the same context with the child, means it can have access to child variables/child automatically binds variables to parent.

## Global Shared data
You can use the following method on TemplateFactory instance to share a value across all templates (nested, extended, components or not) built by it:
```
<\?php 
$viewFactory->share('shared', 'I share because I care');
```
// examples/hello.t.php
```
<div class="card">… {{ $shared }}</div>
```

```
    $viewFactory->make('examples/hello', [])->render();
```
will result:

```
<div class="card">… I share because I care</div> 
```
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
now, calling our component like this:
// examples/hello.t.php
```
<template is="components/filtered-list" sort="ASC" />
<!-- or like this -->
<template is="components/filtered-list" sort="DESC" />
```

```
    $viewFactory->make('examples/hello', [])->render();
```
will result:

```
  <ul>
    <li>avocado</li>
    <li>banana</li>
    <li>berry</li>
    <li>cherry</li>
      </ul> <!-- or like this -->
  <ul>
    <li>cherry</li>
    <li>berry</li>
    <li>banana</li>
    <li>avocado</li>
      </ul> 
```

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
```
and when we call our template (direct, or nested):
$viewFactory->render('form', []);
  <form action="action">
      <div class="form-group ">
                  <label class="form-label">Firstname</label>
                      <input placeholder="Firstname" type="text" class="form-control" >
              </div>   <div class="form-group ">
                  <label class="form-label">Lastname</label>
                      <input placeholder="Lastname" type="text" class="form-control" >
              </div>   <div class="form-group ">
                  <label class="form-label">Age</label>
                      <input placeholder="Age" type="number" class="form-control" >
              </div>   <div class="form-group ">
                  <label class="form-label">Zipcode</label>
                      <input placeholder="Zipcode" type="text" class="form-control" >
              </div>   </form> Because of cache system, parsing events are impossible to be tracked for changes to recompile the code. You have to reset them manually by deleting cached files, or better, pass null as cache path on ViewFactory instancing. This will parse templates on each request without caching them (do this only during development).

### On Rendering time
Let it be our last sorted list:

```
<template is="components/filtered-list" sort="ASC" />
```
add event
```
$viewFactory->on('rendering', 'components/filtered-list', function($context) {
    $context->items[] = 'added';
});
```
and the call:
// examples/hello.t.php
```
<template is="components/filtered-list" sort="ASC" />
```

```
    $viewFactory->make('examples/hello', [])->render();
```
will result:

```
  <ul>
    <li>avocado</li>
    <li>banana</li>
    <li>berry</li>
    <li>cherry</li>
    <li>added</li>
      </ul> 
```
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
Parsed event is executed after a template is fully parsed. 
Events may be declared eliptic in name using *, (meaning anything except '/'). 
Events declaration may accept a weight as 4'th argument which will define listener execution order (high to low).
In the above example, we needed to detach the $script and keep a reference of it, because in event callback would be too late because the component would be already transformed to template function at that point and any change made would take no effect. Also, layout rendering event was triggered before this point.