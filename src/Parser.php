<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Entities\AnonymousComponent;
use DomDocument\PhpTemplates\Entities\Block;
use DomDocument\PhpTemplates\Entities\Component;
use DomDocument\PhpTemplates\Entities\Slot;
use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;

class Parser
{
    private $document;
    private $codebuffer;
    private $name;
    
    public function __construct(Document $doc, string $name, CodeBuffer $cbf = null)
    {
        $this->name = $name;
        $this->document = $doc;
        $this->codebuffer = $cbf ?? new CodeBuffer;
    }

    /**
     * as root, comp, slot
     */
    public function parse($dom = null)
    {
        $trimHtml = false;
        if (!$dom || Helper::isComponent($dom)) {
            $requestName = preg_replace('(\.template|\.php)', '', $this->name);
            $f = Config::get('src_path');
            $srcFile = $f.$requestName.'.template.php';
            $dom = new HTML5DOMDocument;
            $dom->formatOutput = true;
            $html = file_get_contents($srcFile);
            $html = $this->removeHtmlComments($html);
            $trimHtml = strpos($html, '<body') === false;
            $dom->loadHtml($html);

            if ($extends = $dom->querySelector('extends')) {
                $this->extends($extends);
            }
        }

        $this->parseNode($dom);

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
        $htmlString = html_entity_decode($htmlString);
        
        $htmlString = preg_replace('/<html>[\s\n\r]*<\/html>/', '', $htmlString);
        $htmlString = preg_replace('/\?>[ \n\r]*<\?php/', '', $htmlString);
        $htmlString = str_replace(array_keys($this->document->tobereplaced), array_values($this->document->tobereplaced), $htmlString);
        $htmlString = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo htmlspecialchars($eval); ?>";
            }
            return '';
        }, $htmlString);

        // default register aici
        $htmlString = CodeBuffer::getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }
    
    private function parseNode($node, $asFunction = null)
    {
        $return = true;
        $nodeData = Helper::nodeStdClass($node);
        // daca e un deep, degeaba il montez
        if ($node->nodeName === 'slot') {
            (new Slot($this->document))->mount($node);
        } 
        elseif ($node->nodeName === 'block') {
            (new Block($this->document))->mount($node);
        } 
        elseif ($name = Helper::isComponent($node)) {
            (new Component($this->document, $name))->mount($node);
        }
        elseif ($node->nodeName === 'component') {
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
                    $this->document->tobereplaced[$rid] = "<?php echo ({$attr->nodeValue}); ?>";
                    $node->setAttribute($rid, '__empty__');
                    $toberemoved[] = $k;
                    continue;
                }
                elseif ($expr === 'bind') {
                    $rid = '__r'.uniqid();
                    $this->document->tobereplaced[$rid] = "<?php foreach({$attr->nodeValue} as ".'$k=>$v) echo "$k=\"$v\" "; ?>';
                    $node->setAttribute($rid, '__empty__');
                    $toberemoved[] = $k;
                    continue;
                }
                elseif (in_array($expr, Config::allowedControlStructures)) {
                    $this->controlStructure($expr, $attr->nodeValue, $node);
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
                $this->document->tobereplaced[$rid] = "<?php echo {$attr->nodeValue} ;?>";
                $toberemoved[] = $k;
            }
        }
        if (method_exists($node, 'removeAttribute')) {
            foreach ($toberemoved as $attr) {
                $node->removeAttribute($attr);
            }
        }
    }

    protected function controlStructure($statement, $args, $node)
    {
        if ($args || $args === '0') {
            $statement .= " ($args)";
        }

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode("<?php $statement { ?>"),
            $node
        );

        if ($node->nextSibling) {
            $node->parentNode->insertBefore(
                $node->ownerDocument->createTextNode("<?php } ?>"), 
                $node->nextSibling
            );
        } else {
            $node->parentNode->appendChild($node->ownerDocument->createTextNode("<?php } ?>"));
        }
    }
    
    protected function getNodeSlots($node, $forceDefault = false): array
    {
        $slots = [];
        if (!$node->childNodes) {
            return $slots;
        }
        
        foreach ($node->childNodes as $slotNode) {
            if (Helper::isEmptyNode($slotNode)) {
                continue;
            }
            
           $slotPosition = $slotNode->nodeName !== '#text' ? $slotNode->getAttribute('slot') : 'default';
            if ($forceDefault || !$slotPosition) {
                $slotPosition = 'default';
            }

            $slots[$slotPosition][] = $slotNode;
        }
        
        return $slots;
    }
    
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }
    
    protected function extends($extends)
    {
        //$extendedLayout = $extends->getAttribute('layout');
        $extendedTemplate = $extends->getAttribute('template');
        //$extendMethod = $extendedLayout ? 'getLayout' : 'getTemplate';
        //$extended = $extendedLayout ? $extendedLayout : $extendedTemplate;
        // document registerEvent( cu urmatorul format)
            // template va asimila Component si are un event pe new care se asigura ca parseaza ce primeste, in cazul in care nu exista inregistrat (sloturile fac register mai inainte)
        // actualul component
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
}