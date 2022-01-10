## Introduction
Php-templates is the simple, yet powerful templating engine that is easy to implement in almost any PHP app, due to its easy and flexible configuration process. Unlike some PHP templating engines, Php-templates does not restrict you from using plain PHP code in your templates. In fact, all Php-templates templates are compiled into plain PHP code (functional templating) and cached until they are modified, meaning Php-templates adds essentially zero overhead to your application, also it has a clear syntax. Php-templates template files use the `.template.php` file extension and stored in `src_path` configured path and they are parsed and 'cached' in `dest_path` in plain path mode (`foo/bar.template.php` will cached as `foo_bar_{hash}.php`).

Each template will become a closure function indexed on Parsed global object by its name path, but all of these are Php-templates job. You just have to 

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
