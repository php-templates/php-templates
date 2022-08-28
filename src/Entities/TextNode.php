<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Entities\AbstractEntity;

class TextNode extends SimpleNode
{
    const WEIGHT = 70;
    
    public static function test(DomNode $node, EntityInterface $context)
    {
        return $node->nodeName == '#text';
    }
    
    public function rootContext()
    {
        $this->node->changeNode('#text', $this->replaceSpecialTags($this->node->nodeValue));
        parent::rootContext();
    }
    
    public function simpleNodeContext() 
    {
        $this->node->changeNode('#text', $this->replaceSpecialTags($this->node->nodeValue));
        parent::rootContext();
    }
    
    public function componentContext()
    {
        $this->node->changeNode('#text', $this->replaceSpecialTags($this->node->nodeValue));
        parent::componentContext();
    }
    
    private function replaceSpecialTags(string $html)
    {
        $html = preg_replace_callback('/(?<!@)@php(.*?)@endphp/s', function($m) {
            return '<?php ' . $m[1] . ' ?>';
        }, $html);
        
        $html = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                $eval = $eval;
                return "<?php e($eval); ?>";
            }
            return '';
        }, $html);
        
        $html = preg_replace_callback('/{\!\!(((?!{\!\!).)*)\!\!}/', function($m) {
            if ($eval = trim($m[1])) {
                $eval = $eval;
                return "<?php echo $eval; ?>";
            }
            return '';
        }, $html);
        
        return $html;
    }
}