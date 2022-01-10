## Introduction
Php-templates is a template engine based on [HTML5DOMDocument](https://github.com/ivopetkov/html5-dom-document-php). Unlike some PHP templating engines, Php-templates does not restrict you from using plain PHP code in your templates. In fact, all Php-templates templates are compiled into plain PHP code (functional templating) and cached until they are modified, meaning Php-templates adds essentially zero overhead to your application, also it has a clear syntax due to the fact that control structures are placed on desired tag, like in React/Vue.js syntax. Php-templates template files use the `.template.php` file extension and stored in `src_path` configured path and they are parsed and 'cached' in `dest_path` in plain path mode (`foo/bar.template.php` will cached as `foo_bar_{hash}.php`).

Each template will become a closure function indexed on Parsed global object by its name path, but all of these are Php-templates job. You just have to call `PhpTemplates\Template::load({path}, $data)` (path will be relative to `src_path`, without extension `template.php`) to render it. If you only want a template instance to render it later, you can call `Template::get({path}, $attrs)`, then call `render($data)`. `$attrs` will be described later, in Components section.

## Displaying data
Like in most template engines, data is escaped against html entities and displayed using `{{}}`. You can anytime call php pure echo in order to display raw data.
Html nodes ttributes are set using `:` bind syntax.
The following:
```markdown <div class="card" :class="$myVar" :class="$foo === 1 ? 'active' : ''"></div>```
will produce:
```markdown <div class="card <?php echo $myVar; ?> <?php echo $foo === 1 ? 'active' : ''; ?>"></div>```

As you can see, any valid continuing `echo ` php syntax is allowed between "" -> :attr="echo {php_syntax}".

## Control structures
You can place any of this allowed control structures prefixed with `p-` on html node targeted to control.


-----

## Welcome to GitHub Pages

You can use the [editor on GitHub](https://github.com/florin-botea/php-templates/edit/gh-pages/index.md) to maintain and preview the content for your website in Markdown files.

Whenever you commit to this repository, GitHub Pages will run [Jekyll](https://jekyllrb.com/) to rebuild the pages in your site, from the content in your Markdown files.

### Markdown

Markdown is a lightweight and easy-to-use syntax for styling your writing. It includes conventions for

```markdown
Syntax highlighted code block

# Header 1
## Header 2
### Header 3

- Bulleted
- List

1. Numbered
2. List

**Bold** and _Italic_ and `Code` text

[Link](url) and ![Image](src)
```

For more details see [Basic writing and formatting syntax](https://docs.github.com/en/github/writing-on-github/getting-started-with-writing-and-formatting-on-github/basic-writing-and-formatting-syntax).

### Jekyll Themes

Your Pages site will use the layout and styles from the Jekyll theme you have selected in your [repository settings](https://github.com/florin-botea/php-templates/settings/pages). The name of this theme is saved in the Jekyll `_config.yml` configuration file.

### Support or Contact

Having trouble with Pages? Check out our [documentation](https://docs.github.com/categories/github-pages-basics/) or [contact support](https://support.github.com/contact) and we’ll help you sort it out.
