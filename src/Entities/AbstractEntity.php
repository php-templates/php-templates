<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use IvoPetkov\HTML5DOMDocument;

abstract class AbstractEntity
{
    protected $trimHtml = false;
    protected $document;
    protected $context;
    protected $node;
    protected $caret;
    protected $attrs = [];
    protected $depth = 0;
    protected $pf = 'p-';
    
    public function __construct(Document $doc, $node, AbstractEntity $context = null)
    {
        if ($context) {
            $ct_type = explode('\\', get_class($context));
            $ct_type = end($ct_type);

            if (!in_array($ct_type, ['SimpleNode'])) {
                $this->depth = $context->depth +1;
            }
        }

        if (isset($this->document->config['prefix'])) {
            $this->pf = $this->document->config['prefix'];
        }

        $this->document = $doc;
        if (is_string($node)) {
            $node = $this->load($node);
        }
        $this->node = $node;
        $this->context = $context;
        $this->makeCaret();
    }
    
    //abstract public function rootContext();
    //abstract public function componentContext();
    //abstract public function slotContext();
   
    /**
     * Get root Entity in a nested context (first element in a nested structure)
     *
     * @return AbstractParser
     */
    public function getRoot(): AbstractEntity
    {
        if ($this->context && $this->context->depth === 0) {
            return $this->context;
        }
        elseif ($this->context) {
            return $this->context->getRoot();
        }
        return $this;
    }
    
    /**
     * Create a caret above the parsed node for future refering in print process to avoid deleting parsed structures
     *
     * @return void
     */
    protected function makeCaret()
    {
        $node = $this->getRoot()->node;
        $this->caret = $node->ownerDocument->createTextNode('');
        //$this->document->toberemoved[] = $caret;
        $node->parentNode->insertBefore($this->caret, $node);
    }

    protected function println(string $line)
    {
        $this->caret->parentNode->insertBefore(
            $this->caret->ownerDocument->createTextNode($line),
            $this->caret
        );
    }
    
    protected function depleteNode($node, $html = true)
    {
        $data = [];
        if (!$node->attributes) {
            return $data;
        }
        foreach ($node->attributes as $a) {
            $node->removeAttribute($a->nodeName);
            $k = $a->nodeName;
            if (strpos($k, $this->pf) === 0) {
                $k = substr($k, strlen($this->pf));
                if (in_array($k, Config::allowedControlStructures)) {
                    $this->controlStructure($k, $a->nodeValue, $this->caret, $html);
                    continue;
                }
            }
            $k = $a->nodeName;
            $val = $a->nodeValue;
            if ($k[0] === ':') {
                $k = substr($k, 1);
            } else {
                $val = "'$val'";
            }
            if (!array_key_exists($k, $this->attrs)) {
                $data[$k][] = $val;
            } else {
                $this->attrs[$k] = $val;
            }
        }

        foreach ($data as $k => $val) {
            if (count($val) > 1) {
                $data[$k] = 'Helper::mergeAttrs('.implode(',',$val).')';
            } else {
                $data[$k] = reset($val);
            }
        }
        
        return $data;
    }

    protected function controlStructure($statement, $args, $node, $html = true)
    {
        if ($args || $args === '0') {
            $statement .= " ($args)";
        }

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode("<?php $statement { ".($html ? '?>' : '')),
            $node
        );

        if ($node->nextSibling) {
            $node->parentNode->insertBefore(
                $node->ownerDocument->createTextNode("<?php } ?>"),
                $node->nextSibling
            );
        } else {
            $node->parentNode->appendChild($node->ownerDocument->createTextNode(($html ? '<?php' : ''). " } ?>"));
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
    
    protected function parseNode($node)
    {
        $fn = explode('\\', get_class($this));
        $fn = end($fn);
        $fn = lcfirst($fn).'Context';
        if ($node->nodeName === 'slot') {
            (new Slot($this->document, $node, $this))->mount($refNode);
        }
        elseif ($node->nodeName === 'block') {
            (new Block($this->document, $node, $this))->mount($refNode);
        }
        elseif ($this->isComponent($node)) {
            (new Component($this->document, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'template') {
            (new AnonymousComponent($this->document))->mount($refNode);
        }
        else {
            (new SimpleNode($this->document, $node, $this))->{$fn}();
        }
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
        $node = new HTML5DOMDocument;
        $node->substituteEntities = false;
        $node->formatOutput = true;
        $html = file_get_contents($srcFile);
        $html = $this->escapeSpecialCharacters($html);
        $html = $this->removeHtmlComments($html);
        $this->trimHtml = strpos($html, '</body>') === false;
        $node->loadHtml($html);
        
        return $node;
    }
    
    public function isComponent($node)
    {
        if (!@$node->nodeName) {
            return null;
        }
        if ($node->nodeName === 'template') {
            return $node->getAttribute('is');
        }
        
        // merged with default aliased
        $aliased = $this->document->config['aliased'];
        if (isset($aliased[$node->nodeName])) {
            return $aliased[$node->nodeName];
        }

        return null;
    }
    
    public function escapeSpecialCharacters($html) {
        return str_replace(['&lt;', '&gt;', '&amp;'], ['&\lt;', '&\gt;', '&\amp;'], $html);
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
    
    
    protected function getTemplateFunction(string $templateString, $html = true) {
        preg_match_all('/\$([a-zA-Z0-9_]+)/', $templateString, $m);
        $used = Helper::arrayToEval(array_values(array_unique($m[1])));//var_dump($used);die();
        $used = preg_replace('/\s*[\r\n]*\s*/', '', $used);
        if ($html) {
            $templateString = " ?>$templateString<?php ";
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

    public function __get($prop)
    {
        return $this->$prop;
    }
}