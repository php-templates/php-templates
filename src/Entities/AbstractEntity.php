<?php

namespace PhpTemplates\Entities;

use DOMAttr;
use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Directive;
use PhpTemplates\InvalidNodeException;
use PhpTemplates\PhpTag;
use PhpTemplates\Traits\CanParseNodes;

abstract class AbstractEntity
{
    use CanParseNodes;

    protected $trimHtml = false;
    protected $document;
    protected $context;
    protected $node;
    protected $caret;
    protected $attrs = [];
    protected $depth = 0;
    protected $thread;
    protected $pf = 'p-';
    
    public function __construct(Document $doc, $node, AbstractEntity $context = null)
    {
        $this->thread = PhpTag::getThread();
        
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
        // $this->node->setAttribute('i', $this->depth);
        }
        $this->context = $context;
        $this->makeCaret();
        
        $this->shouldClosePhp = $this->shouldClosePhp();
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
    protected function makeCaret($refNode = null)
    {
        $debugText = '';
        if (0
        ) {
            $debugText = explode('\\', get_class($this));
            $debugText = end($debugText).'.'.$this->depth;
        }
    
        if (!$this->node->parentNode) {
            //d($this->node->nodeName);
            // is hierarchical top
            return;
        }
        elseif ($this->depth < 1) {
            $node = $this->node;
        }
        else {
            //d($this->context->depth, $this->depth);dom($this->node);
            $context = $this->context;
            while ($context->depth > 1) {
                $context = $context->context;
            }
            //dd($this->context->node, $this->context->depth);
            $node = $context->caret;
        }
        if ($refNode) {
            $node = $refNode;
        }
        
        $this->caret = $node->ownerDocument->createTextNode($debugText);
        $node->parentNode->insertBefore($this->caret, $node);
        //d($node, $debugText);
        //$this->document->toberemoved[$this->thread][] = $caret;
    }

    public function println(string $line, $end = false)
    {
        if ($end) {
            if ($this->caret->nextSibling) {
                $this->caret->parentNode->insertBefore(
                    $this->caret->ownerDocument->createTextNode(PHP_EOL.$line),
                    $this->caret->nextSibling
                );
            } else {
                $this->caret->parentNode->appendChild($this->caret->ownerDocument->createTextNode(PHP_EOL.$line));
            }
        } else {//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);dd($this->context);
        //d($line, $this->caret->nextSibling);
            $this->caret->parentNode->insertBefore(
                $this->caret->ownerDocument->createTextNode(PHP_EOL.$line),
                $this->caret
            );
        }
    }
    
    protected function depleteNode($node, callable $cb)
    {
        $attrs = $node->attributes ? $node->attributes : [];
        $extracted_attributes = [];

        foreach ($attrs as $a) {
            $k = $a->nodeName;

            if (strpos($k, $this->pf) === 0) {
                // unpack directive result attributes
                $directiveName = substr($k, strlen($this->pf));
                if (Directive::exists($directiveName)) {
                    $result = Directive::run($directiveName, $a->nodeValue);
                    if (empty($result)) {
                        throw new InvalidNodeException('Directive should return an associative array with node => value parsable by PhpTemplates', $node);
                    }
                    foreach ($result as $k => $val) {
                        $extracted_attributes[] = new DOMAttr($k, $val);
                    }
                    // directive unpacked his data
                    continue;
                }
            }
            $extracted_attributes[] = $a->cloneNode(true);
        }

        $c_structs = [];
        $data = [];
        $binds = [];
        foreach ($extracted_attributes as $a) {
            $k = $a->nodeName;
            if (strpos($k, $this->pf) === 0) {
                $k = substr($k, strlen($this->pf));
                if (in_array($k, Config::allowedControlStructures)) {
                    $c_structs[] = [$k, $a->nodeValue];
                    continue;
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
        while ($attributes && $attributes->length) {
            $node->removeAttribute($attributes->item(0)->name);
        }
        
        foreach ($data as $k => $val) {
            $bk = ':'.$k;
            $bind = isset($binds[$bk]) ? $binds[$bk] : null;
            
            if ($bind) {
                $val = array_map(function($attr) {
                    return "'$attr'";
                }, $val);
                $val = array_merge($val, $bind);
                $val = 'Helper::mergeAttrs('.implode(',',$val).')';
                unset($binds[$bk]);
                unset($data[$k]);
                $data[$bk] = $val;
            } else {
                $data[$k] = implode(' ', $val);
            }
        }
        
        foreach ($binds as $bk => $bval) {
            $k = substr($bk, 1);
            if (count($bval) > 1) {
                $bval = 'Helper::mergeAttrs('.implode(',',$bval).')';
            } else {
                $bval = $bval[0];
            }
            $data[$bk] = $bval;
        }

        // imsert $c_structs
        if ($c_structs) {
            $this->phpOpen();
        }
        foreach ($c_structs as $struct) {
            list($statement, $args) = $struct;
            if ($args || $args === '0') {
                $statement .= " ($args)";
            }

            $this->println("$statement { ");
        }
        
        $cb($data, $c_structs, $node);

        // close all control structures
        $close = implode(PHP_EOL, array_fill(0, count($c_structs), '} '));

        if (count($c_structs)) {
            $this->println($close);
        }
    }

    protected function fillNode($node, array $data) 
    {
        if (is_null($node)) {
            $_data = [];
            foreach ($data as $k => &$val) {
                if ($k[0] === ':') {
                    $k = substr($k, 1);
                } else {
                    $val = "'$val'";
                }
                $_data[$k] = $val;
            }
            return $_data;
        }

        if (!method_exists($node, 'setAttribute')) {
            return;
        }
        foreach ($data as $k => $val) {
            if ($k[0] === ':') {
                $k = substr($k, 1);
                $rid = '__r'.uniqid();
                $this->document->tobereplaced[$this->thread][$rid] = "<?php echo $val; ?>";
                $val = $rid;
            }
            elseif ($k === 'p-bind') {
                $rid = '__r'.uniqid();
                $this->document->tobereplaced[$this->thread][$rid] = '<?php foreach('.$val.' as $k=>$v) echo "$k=\"$v\" "; ?>';
                $k = $rid;
                $val = '__empty__';
            }
            elseif ($k === 'p-raw') {
                $rid = '__r'.uniqid();
                $this->document->tobereplaced[$this->thread][$rid] = "<?php echo $val; ?>";
                $k = $rid;
                $val = '__empty__';
            }
            $node->setAttribute($k, $val);
        }
    }
    
    protected function childNodes($node = null)
    {
        PhpTag::setThread($this->thread);
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
    
    protected function removeNode($node) {
        $node->parentNode->removeChild($node);
    }
    
    protected function phpOpen($println = true) {
        $tag = PhpTag::open($this->thread);
        if ($println && $tag) {
            $this->println($tag);
        }
        return $tag;
    }
    
    protected function phpClose($println = true) {
        $tag = PhpTag::close($this->thread);
        if ($println && $tag) {
            $this->println($tag);
        }
        return $tag;
    }
    
    protected function phpIsOpen()
    {
        return PhpTag::isOpen($this->thread);
    }
    
    protected function shouldClosePhp()
    {
        if ($this->depth) {
            return false;
        }
        elseif (($next = $this->nextSibling($this->node)) && $next->attributes) {
            foreach ($next->attributes as $a) {
                if (strpos($a->nodeName, $this->pf) === 0 && in_array(substr($a->nodeName, strlen($this->pf)), Config::allowedControlStructures)) {
                    return false;
                }
            }
        }
        
        return true;
    }

    protected function nextSibling($node)
    {
        $node = $node->nextSibling;
        while ($node && Helper::isEmptyNode($node)) {
            $node = $node->nextSibling;
        }
        return $node;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
}