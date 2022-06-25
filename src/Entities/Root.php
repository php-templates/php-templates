<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\DomEvent;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Traits\CanParseNodes;
use PhpTemplates\Process;

class Root extends AbstractEntity
{
    /**
     * the name ID of the template file
     *
     * @var string $name 
     */
    private $name;

    /**
     * Gain a singlethon process as param and every entity will push/register data to it
     *
     * @param Process $process
     * @param DomNode $node
     * @param string $withName
     */
    public function __construct(Process $process, DomNode $node = null, string $name, $context = null)
    {
        $this->name = $name;
        if (is_null($node) && !$name) {
            throw new \Exception('Node or name must be given');
        }
        elseif (is_null($node) && $name) {
            find config file, load e de abstract entitiy, nu de process si va chema parser.parsefile iar parser va fi cel care executa callback ul, si intoarce doar un nod, atata
            
            list($node, $cb) = $process->load($name);
            lucru care va intoarce node si cb
            // we create a virtual reference in order to not lose node in events, aka node->detach()
            $wrapper = new DomNode('#root');
            // if contenxt given, aka Component used in Template, assign it's parent to give possibility of accessing root node
            if ($context) {
                $wrapper->parent($context->node);
            }
            $node = $wrapper->appendChild($node->detach());
        
            //events before parsing a template
            DomEvent::event('parsing', $name, $node);
            
            // if template file is returning an callback function, execute it
            if (is_callable($cb)) {
                $cb($node);
            }
            
            $node = $wrapper;
        }
        
        parent::__construct($process, $node, $context);
    }
    
    /**
     * register parse result as template function
     *
     * @return void
     */
    protected function register()
    {
        $htmlString = (string)$this->node;
        $htmlString = $this->replaceSpecialBlocks($htmlString);

        $htmlString = $this->getTemplateFunction($htmlString);
        $this->process->addTemplateFunction($this->name, $htmlString);
    }
    
 
    
    /**
     * Replace special syntaxes with php eval syntax
     *
     * @param [type] $html
     * @return void
     */
    protected function replaceSpecialBlocks($html)
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
        
        $html = preg_replace_callback('/{\!\!(((?!{\!\!).)*)\!\!}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo $eval; ?>";
            }
            return '';
        }, $html);
        
        return $html;
    }

    /**
     * Obtaining the template function of the phpt to be used in document
     *
     * @param string $templateString
     * @return void
     */
    protected function getTemplateFunction(string $templateString) : string
    {
        $fnDeclaration = 
"function (\$data) {
    if (!isset(\$data['_attrs'])) {
        \$data['_attrs'] = [];
    }
    extract(\$data);
    ?> $templateString <?php 
}";

        return $fnDeclaration;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
    
    public function rootContext()
    {
        $this->parseNode($this->node);
        $this->register();
    }
    
    public function simpleNodeContext() {
        $this->rootContext();
    }
    public function componentContext() {
        $this->rootContext();
    }
    public function blockContext() {
        $this->rootContext();
    }
    public function slotContext() {
        $this->rootContext();
    }
    public function templateContext() {
        $this->rootContext();
    }
}