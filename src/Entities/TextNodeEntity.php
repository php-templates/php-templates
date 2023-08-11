<?php

namespace PhpTemplates\Entities;

use function PhpTemplates\enscope_variables;

class TextNodeEntity extends Entity
{
    public function startupContext() {
        $this->simpleNodeContext();
    }
    
    /**
     * <div>abc</div>
     */
    public function simpleNodeContext()
    {
        $this->node->setNodeValue($this->replaceSpecialTags($this->node->getNodeValue()));
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
        $html = preg_replace_callback('/\{%(((?!\{%).)*)%\}/', function($m) {
            // todo throw error if syntax ends with;
            return '<?php '. enscope_variables($m[1]) .'; ?>';
        }, $html);

        $html = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                $eval = enscope_variables($eval);
                return "<?php \$this->__e($eval); ?>";
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
            return '<?php echo '. enscope_variables(sprintf('$this->%s(%s)', $m[1], trim($m[2]))) .'; ?>';
        }, $html);
    }
}