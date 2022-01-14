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
            $this->document->registerDependency($requestName);
            $f = Config::get('src_path');
            $srcFile = $f.$requestName.'.template.php';
            $dom = new HTML5DOMDocument;
            $dom->substituteEntities = false;
            $dom->formatOutput = true;
            $html = file_get_contents($srcFile);
            $html = $this->escapeSpecialCharacters($html);
            $html = $this->removeHtmlComments($html);
            $trimHtml = strpos($html, '<body') === false;
            $dom->loadHtml($html);

            if ($extends = $dom->querySelector('extends')) {
                $this->extends($extends);
            }
        } elseif ($dom->nodeName !== '#document') {
            // create extra scope to ensure safe insertbefore and insertafter
            $container = new HTML5DOMDocument;
            $dom = $container->importNode($dom, true);
            $container->appendChild($dom);
            $dom = $container; unset($container);
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
                }
                elseif ($expr === 'bind') {
                    $rid = '__r'.uniqid();
                    $this->document->tobereplaced[$rid] = "<?php foreach({$attr->nodeValue} as ".'$k=>$v) echo "$k=\"$v\" "; ?>';
                    $node->setAttribute($rid, '__empty__');
                }
                elseif (in_array($expr, Config::allowedControlStructures)) {
                    $this->controlStructure($expr, $attr->nodeValue, $node);
                }
                elseif ($custom = Config::directive($expr, $attr->nodeValue)) {
                    $rid = '__r'.uniqid();
                    $this->document->tobereplaced[$rid] = "<?php echo $custom; ?>";
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
        
        // slots bound together using if else stmt should be keeped together
        $lastPos = null;
        foreach ($node->childNodes as $slotNode) {
            if (Helper::isEmptyNode($slotNode)) {
                continue;
            }
            
           $slotPosition = null;
           if ($slotNode->nodeName !== '#text') {
               $slotPosition = $slotNode->getAttribute('slot');
               $slotNode->removeAttribute('slot');
           }
            if ($forceDefault || !$slotPosition) {
                $slotPosition = 'default';
            }
            
            if ($slotNode->nodeName === '#text') {
                $slots[$slotPosition][] = $slotNode;
            }
            elseif (!$slotNode->hasAttribute('p-elseif') && !$slotNode->hasAttribute('p-else')) {
                // stands its own
                $container = new HTML5DOMDocument;
                $slotNode = $container->importNode($slotNode, true);
                $container->appendChild($slotNode);
                $slots[$slotPosition][] = $container;
                $lastPos = $slotPosition;
            } else {
                // has dependencies above
                if (isset($slots[$lastPos])) {
                    $i = count($slots[$lastPos]) -1;
                    $slotNode = $slots[$lastPos][$i]->importNode($slotNode, true);
                    $slots[$lastPos][$i]->appendChild($slotNode);
                }
            }
        }
        
        return $slots;
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