<?php

namespace PhpTemplates\Entities;

use function PhpTemplates\enscope_variables;

class TextNodeEntity extends SimpleNodeEntity
{
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
        // unreachable because of View::simpleNodeContext dom manipulation
    }

    /**
     * Replace php echo, open and close tags
     *
     * @param string $html
     * @return string
     */
    private function replaceSpecialTags(string $html): string
    {
        $html = preg_replace('/(?<!@)@php(.*?)@endphp/s', '<?php $1 ?>', $html);
        $html = preg_replace('/\{%(((?!\{%).)*)%\}/', '<?php $1; ?>', $html);

        $html = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                $eval = enscope_variables($eval);
                return "<?php e($eval); ?>";
            }
            return '';
        }, $html);

        $html = preg_replace_callback('/{\!\!(((?!{\!\!).)*)\!\!}/', function($m) {
            if ($eval = trim($m[1])) {
                $eval = enscope_variables($eval);
                return "<?php echo $eval; ?>";
            }
            return '';
        }, $html);
        
        // custom tags
        return preg_replace_callback("/{(\w+) (((?!{(\w+) ).)*)}/", function($m) {
            // todo check if method exist, throw error if not
            return '<?php echo $this->'.$m[1].'('.enscope_variables(trim($m[2])).'); ?>';
        }, $html);
    }
}