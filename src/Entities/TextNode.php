<?php

namespace PhpTemplates\Entities;

class TextNode extends SimpleNode
{
    public function rootContext()
    {
        $x = $this->addContextualVariables(
            '$foo = 123; foreach($foo as
            $bar); 
            $foo[$bar]; $foo[\'bar\']; \'$dolars\' "\$dolars" "$yes"'
        );
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
        d($string);
        ((?!\\).)"[^"\\]*(?:\\.[^"\\]*)*"
        // match all $ not inside of a string declaration, considering escapes
        return preg_replace_callback("/(?<!=\\)'/", function($m) {
            dd($m);
        }, $string);
    }
}