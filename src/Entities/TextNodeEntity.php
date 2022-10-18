<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Dom\DomNode;

class TextNodeEntity extends SimpleNodeEntity
{
    const WEIGHT = 70;

    public static function test(DomNode $node, EntityInterface $context): BOOL
    {
        return $node->nodeName == '#text';
    }

    /**
     * <div>abc</div>
     */
    public function simpleNodeContext()
    {
        $this->node->changeNode('#text', $this->replaceSpecialTags($this->node->nodeValue));
        parent::simpleNodeContext();
    }

    /**
     * <tpl is="comp/x">abc</tpl>
     */
    public function templateContext()
    {
        // unreachable because of Template::simpleNodeContext dom manipulation
    }

    /**
     * Replace php echo, open and close tags
     *
     * @param string $html
     * @return string
     */
    private function replaceSpecialTags(string $html): string
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