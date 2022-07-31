<?php

namespace PhpTemplates\Entities;

use Twig\Extension\CoreExtension;
use Twig\ExtensionSet;
use Twig\Lexer;
use Twig\Source;

class TextNode extends SimpleNode
{
    public function rootContext()
    {
        $x = '{% set foo = 123 %}';
        $x .= PHP_EOL . '{% foreach($foo as $bar) %}';
        $x .= PHP_EOL . '{% endforeach %}';
        $x .= PHP_EOL . '{{ $foo[$bar] | someFilter }}  dsad dsa ';
        $x .= PHP_EOL . '{# comment #}';
        $x .= PHP_EOL . '{{ \'yoy\' }}';

        $x = $this->addContextualVariables($x);
        dd($x);
        
        $this->node->changeNode('#text', $this->replaceSpecialTags($this->node->nodeValue));
        parent::rootContext();
    }
    
    public function componentContext()
    {
        $this->node->changeNode('#text', $this->replaceSpecialTags($this->node->nodeValue));
        parent::componentContext();
    }
    
    private function replaceSpecialTags(string $string)
    {
        $html = preg_replace_callback('/(?<!@)@php(.*?)@endphp/s', function($m) {
            return '<?php ' . $m[1] . ' ?>';
        }, $html);
        
        $html = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php e($eval); ?>";
            }
            return '';
        }, $html);
        
        $templateString = preg_replace_callback('/{\!\!(((?!{\!\!).)*)\!\!}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo $eval; ?>";
            }
            return '';
        }, $html);
    }
    
    private function addContextualVariables(string $string) 
    {
        $extensionSet = new ExtensionSet();
        $extensionSet->addExtension(new CoreExtension());
        $lexer = new Lexer($extensionSet);
        $stream = $lexer->tokenize(new Source($string, 'name.'.uniqid()));
        dd($stream);
        // $extensionSet->addExtension(new EscaperExtension($options['autoescape']));
        // $extensionSet->addExtension(new OptimizerExtension($options['optimizations']));
        // lexer duce greul…  asta e baza
        // stream = lexer tokenize
        // parser->parse(stream)

        d($string);
        // ((?!\\).)"[^"\\]*(?:\\.[^"\\]*)*"
        // match all $ not inside of a string declaration, considering escapes
        return preg_replace_callback("/(?<!=\\)'/", function($m) {
            dd($m);
        }, $string);
    }
}