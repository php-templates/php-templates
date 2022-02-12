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
    protected $controlStructures = [];
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
        if (method_exists($this->node, 'setAttribute')) {
        $this->node->setAttribute('i', $this->depth);
        }
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
        if ($this->depth === 0) {
            return $this;
        }
        
        return $this->context->getRoot();
    }
    
    /**
     * Create a caret above the parsed node for future refering in print process to avoid deleting parsed structures
     *
     * @return void
     */
    protected function makeCaret($node = null)
    {
        $debugText = '';
        if (1) {
            $debugText = explode('\\', get_class($this));
            $debugText = end($debugText);
        }if ($node)dd($node);
        if (!$node) {
            //d($this->depth);
        if (!$this->depth) {
            $this->caret = $this->node;
            return;
        } 
        elseif($this->depth === 1) {
            $node = $this->node;
        } else {
            $node = $this->context->caret;
        }
        }
        $this->caret = $node->ownerDocument->createTextNode($debugText);
        //$this->document->toberemoved[] = $caret;
        $node->parentNode->insertBefore($this->caret, $node);
    }

    public function println(string $line)
    {//if (!$this->caret) return; //dd(get_class($this), get_class($this->getRoot()));
        $this->caret->parentNode->insertBefore(
            $this->caret->ownerDocument->createTextNode(PHP_EOL.$line),
            $this->caret
        );
    }
    
    protected function depleteNode($node, $html = false)
    {
        $data = [];
        $binds = [];
        if (!$node->attributes) {
            return $data;
        }
        foreach ($node->attributes as $a) {
            $k = $a->nodeName;
            if (strpos($k, $this->pf) === 0) {
                $k = substr($k, strlen($this->pf));
                if (in_array($k, Config::allowedControlStructures)) {
                    $this->controlStructure($k, $a->nodeValue, $this->caret);
                    $this->controlStructures[] = [$k, $a->nodeValue];
                    continue;
                }
                //todo validate simple node only
                elseif ($custom = $this->directive($k, $a->nodeValue)) {
                    $rid = '__r'.uniqid();
                    $this->document->tobereplaced[$rid] = $custom;//d($custom);
                    $data[$rid][] = '__empty__';
                    continue;
                    //$node->setAttribute($rid, '__empty__');
                }
            }
            $k = $a->nodeName;
       
            if (array_key_exists($k, $this->attrs)) {
                $this->attrs[$k] = $a->nodeValue;
            } 
            elseif ($k[0] === ':') {
                $binds[$k][] = $a->nodeValue;
            }
            else {
                $data[$k][] = $a->nodeValue;
            }
        }

        $attributes = $node->attributes;
        while ($attributes->length) {
            $node->removeAttribute($attributes->item(0)->name);
        }
        
        foreach ($data as $k => &$val) {
            $bk = ':'.$k;
            $bind = isset($binds[$bk]) ? $binds[$bk] : null;
            
            if ($bind || !$html) {
                $val = array_map(function($attr) {
                    return "'$attr'";
                }, $val);
            }
            if ($bind) {
                $val = array_merge($val, $bind);
                $val = 'Helper::mergeAttrs('.implode(',',$val).')';
                unset($binds[$bk]);
            } else {
                $val = implode(' ', $val);
            }
            
            if ($html && $bind) {
                $rkey = uniqid();
                $this->document->tobereplaced[$rkey] = "<?php echo $val; ?>";
                $val = $rkey;
            }
        }
        
        foreach ($binds as $k => $bval) {
            $k = substr($k, 1);
            if (count($bval) > 1) {
                $bval = 'Helper::mergeAttrs('.implode(',',$bval).')';
            } else {
                $bval = $bval[0];
            }
            if ($html) {
                $rkey = uniqid();
                $this->document->tobereplaced[$rkey] = "<?php echo $bval; ?>";
                $data[$k] = $rkey;
            } else {
                $data[$k] = $bval;
            }
        }

        return $data;
    }

    protected function controlStructure($statement, $args, $node)
    {
        $phpStart = $this->depth ? '' : '<?php';
        $phpEnd = $this->depth ? '' : '?>';
    
        if ($args || $args === '0') {
            $statement .= " ($args)";
        }

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($phpStart." $statement { ".$phpEnd),
            $node
        );

        if ($node->nextSibling) {
            $node->parentNode->insertBefore(
                $node->ownerDocument->createTextNode($phpStart." } ".$phpEnd),
                $node->nextSibling
            );
        } else {
            $node->parentNode->appendChild($node->ownerDocument->createTextNode($phpStart. " } ".$phpEnd));
        }
    }
    
    protected function directive($name, $val)
    {//d($name, $this->document->config['directives']);
        if (empty($this->document->config['directives'][$name])) {
            return false;
        }
        $directive = $this->document->config['directives'][$name];
        if (is_callable($directive)) {
            return $directive($val);
        }
        return $directive;
    }
    
    protected function childNodes($node = null)
    {
        if (!$node) {
            $node = $this->node;
        }
        $cnodes = [];
        if (!$node->childNodes) {
            return $cnodes;
        }
        foreach ($node->childNodes as $cn) {
            if (Helper::isEmptyNode($cn)) 
            continue;
            
            $cnodes[] = $cn;
        }
        
        return $cnodes;
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
            (new Slot($this->document, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'block') {
            (new Block($this->document, $node, $this))->{$fn}();
        }
        elseif ($this->isComponent($node)) {
            (new Component($this->document, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'template') {
            dd('anonim comp');
            // (new AnonymousComponent($this->document))->mount($refNode);
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

    public function __get($prop)
    {
        return $this->$prop;
    }
}