<?php

namespace PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\PhpTag;
use PhpTemplates\Traits\CanParseNodes;
// rename into TemplateParser
class Context {
    use CanParseNodes;

    private $name;
    private $node;
    private $trimHtml = false;
    public $depth = 0; // todo _get
  // todo: muta pe document  
    private $tobereplaced = [
        '="__empty__"' => '',
        /*'&gt;' => '>',
        '&amp;\gt;' => '&gt;',
        '&lt;' => '<',
        '&amp;\lt;' => '&lt;',
        '&amp;' => '&',
        '&amp;\amp;' => '&amp;',
        '<php>' => '<?php',
        '</php>' => '?>'*/
    ];

    public function __construct(Document $doc, $node, $context = null)
    {
        // parent::__construct($doc, $node, is_string($context) ? null : $context);
        $this->document = $doc;
        if (is_string($node)) {
            $this->name = $node;
            $node = $this->load($node);
        } 
        elseif (is_string($context)) {
            $this->name = $context;
        }
        
        $this->node = $node;
    }
    
    public function parse()
    {
        $this->thread = uniqid();
        PhpTag::setThread($this->thread);
        $this->document->tobereplaced[$this->thread] = $this->tobereplaced;
        if (method_exists($this->node, 'querySelector')) {
            if ($extends = $this->node->querySelector('extends')) {
                $this->extends($extends);
            }
        }
        $this->parseNode($this->node);

        $this->register();
    }
    
    protected function register()
    {
        if ($this->trimHtml) {
            $htmlString = $this->trimHtml($this->node);
        }
        elseif ($this->node->ownerDocument) {
            $htmlString = $this->node->ownerDocument->saveHtml($this->node);
        } else {
            $htmlString = $this->node->saveHtml();
        }

        $htmlString = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo htmlspecialchars($eval); ?>";
            }
            return '';
        }, $htmlString);

        $htmlString = str_replace(array_keys($this->document->tobereplaced[$this->thread]), array_values($this->document->tobereplaced[$this->thread]), $htmlString);

        $htmlString = $this->getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }

    private function extends($extends)
    {
        $extendedTemplate = $extends->getAttribute('template');
        (new Context($this->document, $extendedTemplate))->parse();

        $this->document->addEventListener('rendering', $this->name, "function(\$template, \$data) {
            \$comp = Parsed::template('$extendedTemplate', \$data);
            \$comp->addSlot('default', \$template);
            \$comp->render(\$data);
            return false;
        }");

        $extends->parentNode->removeChild($extends);
    }

    /**
     * Load the given route document using this.document settings with fallback on default settings
     */
    public function load($rfilepath)
    {
        $srcpath1 = rtrim($this->document->config['src_path'], '/').'/'.$rfilepath.'.template.php';
        $srcpath2 = rtrim(Config::get('src_path'), '/').'/'.$rfilepath.'.template.php';
        if (file_exists($srcpath1)) {
            $srcFile = $srcpath1;
        }
        elseif ($srcpath2 !== $srcpath1 && file_exists($srcpath2)) {
            $srcFile = $srcpath2;
        } else {
            $message = implode(' or ', array_unique([$srcpath1, $srcpath2]));
            throw new \Exception("Template file $message not found");
        }
        
        $this->document->registerDependency($srcFile);
        $node = new HTML5DOMDocument();

        $html = file_get_contents($srcFile);
        $html = $this->collectBrokingBlocks($html);
        $html = $this->removeHtmlComments($html);
        $this->trimHtml = strpos($html, '<body') === false;
        $node->loadHtml($html);
//if(!$node) dd();
        return $node;
    }

//chemat din afara, sau cu flag uri
    public function escapeSpecialCharacters($html) {
        return str_replace(['&lt;', '&gt;', '&amp;'], ['&\lt;', '&\gt;', '&\amp;'], $html);
    }
    
    private function collectBrokingBlocks($html)
    {
        
        $html = preg_replace_callback('/(?<!<)<\?php(.*?)\?>/s', function($m) {
            $rid = '__r'.uniqid();
            $this->document->tobereplaced['_'][$rid] = $m[0];
            return $rid;
        }, $html);
        
        $html = preg_replace_callback('/(?<!@)@php(.*?)@endphp/s', function($m) {
            $rid = '__r'.uniqid();
            $this->document->tobereplaced['_'][$rid] = '<?php ' . $m[1] . ' ?>';
            return $rid;
        }, $html);
        
        return $html;
    }

    public function trimHtml($dom)
    {
        $body = $dom->getElementsByTagName('body')->item(0);

        if (!$body) {
            return '';
        }

        $content = '';
        foreach ($body->childNodes as $node)
        {
            $content.= $dom->saveHtml($node).PHP_EOL;
        }
        return $content;
    }
    
    protected function getTemplateFunction(string $templateString, $html = true) {
        preg_match_all('/\$([a-zA-Z0-9_]+)/', $templateString, $m);
        $used = Helper::arrayToEval(array_values(array_unique($m[1])));//var_dump($used);die();
        $used = preg_replace('/\s*[\r\n]*\s*/', '', $used);
        if ($html) {
            $templateString = " ?> $templateString <?php ";
        }
        $fnDeclaration = 
        "function (\$data, \$slots) {
    extract(\$this->data); \$_attrs = array_diff_key(\$this->attrs, array_flip($used));
    $templateString
}";
        return $fnDeclaration;
    }
 
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }
}