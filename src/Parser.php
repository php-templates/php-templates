<?php

namespace PhpTemplates;

use PhpTemplates\Entities\AnonymousComponent;
use PhpTemplates\Entities\Block;
use PhpTemplates\Entities\Component;
use PhpTemplates\Entities\Slot;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;

class Parser
{
    private $document;
    private $name;

    public function __construct(Document $doc, string $name)
    {
        $this->name = $name;
        $this->document = $doc;
    }

    /**
     * as root, comp, slot
     */
    public function parse($dom = null)
    {
        // $trimHtml = false;
        // if (!$dom || Helper::isComponent($dom)) {
        //     $requestName = preg_replace('(\.template|\.php)', '', $this->name);
        //     $this->document->registerDependency($requestName);
        //     $f = trim(Config::get('src_path'), '/').'/';
        //     $srcFile = $f.$requestName.'.template.php';
        //     $dom = new HTML5DOMDocument;
        //     $dom->substituteEntities = false;
        //     $dom->formatOutput = true;
        //     $html = file_get_contents($srcFile);
        //     $html = $this->escapeSpecialCharacters($html);
        //     $html = $this->removeHtmlComments($html);
        //     $trimHtml = strpos($html, '<body') === false;
        //     $dom->loadHtml($html);

        //     if ($extends = $dom->querySelector('extends')) {
        //         $this->extends($extends);
        //     }
        // } elseif ($dom->nodeName !== '#document') {
        //     // create extra scope to ensure safe insertbefore and insertafter
        //     $container = new HTML5DOMDocument;
        //     $dom = $container->importNode($dom, true);
        //     $container->appendChild($dom);
        //     $dom = $container;
        // }

        NodeParser::parse($node, null);

        while ($this->document->toberemoved) {
            $node = array_pop($this->document->toberemoved);
            try {
                @$node->parentNode && @$node->parentNode->removeChild($node);
            } catch (\Exception $e) {}
        }

        if ($trimHtml) {
            $htmlString = $this->trimHtml($dom);
        }
        elseif ($dom->ownerDocument) {
            $htmlString = $dom->ownerDocument->saveHtml($dom);
        } else {
            $htmlString = $dom->saveHtml();
        }
        // make replaces
        $htmlString = preg_replace('/<html>[\s\n\r]*<\/html>/', '', $htmlString);
        $htmlString = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo htmlspecialchars($eval); ?>";
            }
            return '';
        }, $htmlString);

        $htmlString = CodeBuffer::getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }

    private function parseNode($node, $asFunction = null)
    {
        NodeParser::parse($node);
        return;
        $return = true;
        $nodeData = Helper::nodeStdClass($node);
        if ($node->nodeName === 'slot') {
            (new Slot($this->document))->mount($node);
        }
        elseif ($node->nodeName === 'block') {
            (new Block($this->document, $this->name))->mount($node);// this name, iar mount zice: compx are sloturile y, sunt pe parsed
        }
        elseif ($name = Helper::isComponent($node)) {
            (new Component($this->document, $name))->mount($node);
        }
        elseif ($node->nodeName === 'template') {
            (new AnonymousComponent($this->document))->mount($node);
        }
        else {
            $this->parseSimpleNode($node);
            $return = false;
        }

        if ($return) {
            return;
        }

        foreach ($node->childNodes ?? [] as $_node) {//d($_node);
            $this->parseNode($_node);
        }
    }

    private function parseSimpleNode($node)
    {
        if (empty($node->attributes)) {
            return;
        }

        $toberemoved = ['slot', '_index'];
        $pf = Config::get('prefix');
        $bpf = ':'; // bind prefix

        foreach ($node->attributes as $attr) {
            $k = $attr->nodeName;
            if (strpos($k, $pf) === 0) {
                $expr = substr($k, strlen($pf));
                if ($expr === 'raw') {
                    $rid = '__r'.uniqid();
                    $this->document->tobereplaced[$this->thread][$rid] = "<?php echo ({$attr->nodeValue}); ?>";
                    $node->setAttribute($rid, '__empty__');
                }
                elseif ($expr === 'bind') {
                    $rid = '__r'.uniqid();
                    $this->document->tobereplaced[$this->thread][$rid] = "<?php foreach({$attr->nodeValue} as ".'$k=>$v) echo "$k=\"$v\" "; ?>';
                    $node->setAttribute($rid, '__empty__');
                }
                elseif (in_array($expr, Config::allowedControlStructures)) {
                    $this->controlStructure($expr, $attr->nodeValue, $node);
                }
                elseif ($custom = Config::directive($expr, $attr->nodeValue)) {
                    $rid = '__r'.uniqid();
                    $this->document->tobereplaced[$this->thread][$rid] = "<?php echo $custom; ?>";
                    $node->setAttribute($rid, '__empty__');
                }

                $toberemoved[] = $k;
            }
            elseif (strpos($k, $bpf) === 0) {
                $a = substr($k, 1);
                $rid = '__r'.uniqid();
                if ($nattr = $node->getAttribute($a)) {
                    $node->setAttribute($a, $nattr." $rid");
                } else {
                    $node->setAttribute($a, $rid);
                }
                $this->document->tobereplaced[$this->thread][$rid] = "<?php echo {$attr->nodeValue} ;?>";
                $toberemoved[] = $k;
            }
        }
        if (method_exists($node, 'removeAttribute')) {
            foreach ($toberemoved as $attr) {
                $node->removeAttribute($attr);
            }
        }
    }
    
    public function insertAfter($node, string $inserted)
    {
        if ($node->nextSibling) {
            $node->parentNode->insertBefore(
                $node->ownerDocument->createTextNode($inserted),
                $node->nextSibling
            );
        } else {
            $node->parentNode->appendChild($node->ownerDocument->createTextNode($inserted));
        }
    }
    
    public function insertBefore(string $inserted, $node)
    {
        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($inserted),
            $node
        );
    }
    
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }

    protected function extends($extends)
    {
        $extendedTemplate = $extends->getAttribute('template');
        (new Parser($this->document, $extendedTemplate))->parse();

        $this->document->addEventListener('rendering', $this->name, "function(\$template, \$data) {
            \$comp = Parsed::template('$extendedTemplate', \$data);
            \$comp->addSlot('default', \$template);
            \$comp->render(\$data);
            return false;
        }");

        $extends->parentNode->removeChild($extends);
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
            $content.= $dom->saveHtml($node);
        }
        return $content;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function escapeSpecialCharacters($html) {
        return str_replace(['&lt;', '&gt;', '&amp;'], ['&\lt;', '&\gt;', '&\amp;'], $html);
    }
}
