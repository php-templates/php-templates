<?php

namespace PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\PhpTag;
use PhpTemplates\Traits\CanParseNodes;
// rename into TemplateParser
class Context {
    rename in template function ca asta eibi
    nu poate inloxui doc din cauza ca replaces colectate pe fiest load trb sa fie globale
    sau poate-> pt ca la final as face replace la tot cumulat
    poate ar fi ok ca asta sa inloc doc ca si liant per parsari-> nu e idee buna pt ca nu am acces la doc sa inreg fn-> ba da ca pot face ca in mom in care se face start parsing doc sa fie tinut global static sau sa fie trecut ca arg 
    asta va contine un prop care e parent
    pe root zic new context parse
    apoi zic register(document ca arg)
    care face pregatirile
    itereaza peste -> memory consuming
    
    use CanParseNodes;
    
    private $data; // data passed to component using  node attributes
    private $attrs; // computed at calling render function moment

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
            // aici ar trebui extends ul
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
            muta mai sus, pe construct, nu ar trb sa fie aici
            ca poate pune vreunul extendz undenu trb
            asta la pachet cu cautarea de atribute
            if ($extends = $this->node->querySelector('extends')) {
                $this->extends($extends);
            }
            if ($props = $this->node->querySelector('props')) {
                $this->props = $this->getProps($props);
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

        //$htmlString = str_replace(array_keys($this->document->tobereplaced[$this->thread]), array_values($this->document->tobereplaced[$this->thread]), $htmlString);

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
        $html = $this->removeHtmlComments($html);
        $html = $this->collectBrokingBlocks($html);
        $this->trimHtml = strpos($html, '<body') === false;
        $node->loadHtml($html);

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
        
        $html = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                $rid = '__r'.uniqid();
                $this->document->tobereplaced['_'][$rid] = "<?php echo htmlspecialchars($eval); ?>";
                return $rid;
            }
            return '';
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
        //preg_match_all('/\$([a-zA-Z0-9_]+)/', $templateString, $m);
        //$used = Helper::arrayToEval(array_values(array_unique($m[1])));//var_dump($used);die();
        //$used = preg_replace('/\s*[\r\n]*\s*/', '', $used);
        //if ($html) {
            $templateString = " ?> $templateString <?php ";
        //}
        
        nuuu in momentul parsarii, voi avea parsed t [x => 1, @y => 2], iar pe template pun si un fill de props. pe construct, filtrez oile si pun props si attrs
        nu merge pe event uri
        
        nunu
        data, scopedata, attrs, props <-- cel mai semantic
        nunu  
        declare props... are nevoie de extract data
        this attrs calculation are nevoie de props
        extract data
        apooi extract props daca este
        aici fac un array assoc sau ceva obj builder, iar a doua e o 
        $fnheader = ' extract($_data);';
        if ($this->props) {
            $props = Helper::arrayToEval($this->props);
            $prepend = "\$_props = $props; ";
            $prepend .= ' $_attrs = array_diff_key($this->data, $props);';
            $prepend .= ' $_data = array_merge($_props, $data);';
            $header = $data = array merge props, this data si apoi linia de mai sus si apoi extract
        } else {
            $header
        }
        $fnDeclaration = 
        "function (\$data, \$slots) {
     \$_attrs = array_diff_key(\$this->data, array_flip($used));
    $templateString
}";
        return $fnDeclaration;
    }
 
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }
}