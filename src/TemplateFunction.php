<?php

namespace PhpTemplates;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Traits\CanParseNodes;

class TemplateFunction 
{
    use CanParseNodes;
    
    /**
     * Current processing thread contextual data holder (like config, parsed index, other cross entities shared data)
     * @var Process
     */
    protected $process;

    /**
     * the name ID of the template file
     *
     * @var string $name 
     */
    private $name;
    
    private $depth = 0;

    /**
     * The dom object tree of the loaded phpt file
     *
     * @var DomNode
     */
    private $node;

    /**
     * Gain a singlethon process as param and every entity will push/register data to it
     *
     * @param Process $process
     * @param string|DomNode $node
     * @param string|AbstractEntity|null $context
     */
    public function __construct(Process $process, $node, $context = null)
    {
        $this->process = $process;

        if (is_string($node)) 
        {
            // obtaining config prefix pointing to settings collection then assign it to current process
            $path = array_filter(explode(':', $node));
            $cfgKey = count($path) > 1 ? $path[0] : 'default';
            $this->process->withConfig($cfgKey);

            // obtaining relative template file path and load it using config's src path
            $path = end($path);
            $this->name = $node;
            $cb = $this->load($path);

            // if contenxt given, aka Component used in Template, assign it's parent to give possibility of accessing root node
            if ($context) {
                $this->node->parent($context->node);
            }
            
            //TODO: events before parsing a template
            DomEvent::event('parsing', $this->name, $this->node);
            
            // if template file is returning an callback function, execute it
            if (is_callable($cb)) {
                $cb($this->node);
            }
        }
        else {
            // node was given by AbstractEntity
            $this->node = $node;
        }

        // same as else above, node was given with a custom name
        if (is_string($context)) {
            $this->name = $context;
        }
    }
    
    public function parse()
    {
        $this->parseNode($this->node);
        $this->register();
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
     * Load the given route document using this.document settings with fallback on default settings
     */
    public function load($rfilepath)
    {
        // obtaining the template file path using multi-config mode
        $srcFile = null;
        $tried = [];
        foreach ($this->process->getSrcPaths() as $srcPath) {
            $filepath = rtrim($srcPath, '/').'/'.$rfilepath.'.template.php';
            if (file_exists($filepath)) {
                $srcFile = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        if (!$srcFile) {
            $message = implode(' or ', $tried);
            throw new \Exception("Template file $message not found");
        }
        
        // add file as dependency to template for creating hash of states
        $this->process->addDependencyFile($srcFile);

        // geting file content (php function can be returned and executed in actual context)
        ob_start();
        $cb = require($srcFile);
        $html = ob_get_contents();
        ob_end_clean();

        $html = $this->removeHtmlComments($html);

        // obtaining the DomNode
        $node = DomNode::fromString($html, ['preservePatterns' => [
            '/(?<!<)<\?php(.*?)\?>/s',
            '/(?<!@)@php(.*?)@endphp/s',
            '/{{(((?!{{).)*)}}/',
            '/{\!\!(((?!{\!\!).)*)\!\!}/',
        ]]);

$x = preg_replace('/[\n\r\t\s]*|(="")*/', '', $node);
$y = preg_replace('/[\n\r\t\s]*|(="")*/', '', str_replace('=\'""\'', '=""""', $html));
$x = str_replace("'", '"', $x);
$y = str_replace("'", '"', $y);
 
if (0 && $x != $y) {
    d('nu se pupa '.$srcFile);
    //$node->querySelector('body')[0]->empty();
    //dd(''.$node);
    //d($node->debug());
    while ($x && $y && substr($x, 0, 300) == substr($y, 0, 300)) {
        $x = substr($x, 300);
        $y = substr($y, 300);
    }
    echo "\n$y\n$x"; die();
}

        $this->node = $node;
        
        return $cb;
    }
    
    /**
     * Replace special syntaxes with php eval syntax
     *
     * @param [type] $html
     * @return void
     */
    private function replaceSpecialBlocks($html)
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
 
    public function removeHtmlComments($content = '') {
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
}