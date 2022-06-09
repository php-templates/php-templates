<?php

namespace PhpTemplates\Entities;

use DOMAttr;
use PhpTemplates\Config;
use PhpTemplates\Helper;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Directive;
use PhpTemplates\InvalidNodeException;
use PhpTemplates\Process;
use PhpTemplates\Traits\CanParseNodes;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNode;

abstract class AbstractEntity
{
    use CanParseNodes;
    
    /**
     * Current processing thread contextual data holder (like config, parsed index, other cross entities shared data)
     * @var Process
     */
    protected $process;

    protected $isHtml = false;
    protected $trimHtml = false;
    protected $context;
    protected $node;
    protected $caret;
    protected $attrs = [];
    protected $depth = 0;
    protected $thread;
    protected $pf = 'p-';
    
    public function __construct(Process $process, $node, $context = null) //todo interfata ca param 3
    {
        if (is_string($context)) {
            $this->name = $context;
            $context = null;
        }
        //if (is_string($node)) debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        if ($context) {
            $ct_type = explode('\\', get_class($context));
            $ct_type = end($ct_type);

            if (!in_array($ct_type, ['SimpleNode'])) {
                $this->depth = $context->depth +1;
            }
        }

        if (isset($this->process->config['prefix'])) {
            $this->pf = $this->process->config['prefix'];
        }

        $this->process = $process;
        $this->node = $node;
        if (method_exists($this->node, 'setAttribute')) {
        // $this->node->setAttribute('i', $this->depth);
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
    protected function makeCaret($refNode = null)
    {return;
        if (!$this->node->parentNode) {
            // is hierarchical top
            return;
        }
        elseif ($this->depth < 1) {
            $node = $this->node;
        }
        else {
            $context = $this->context;
            while ($context->depth > 1) {
                $context = $context->context;
            }
            $node = $context->caret;
        }
        if ($refNode) {
            $node = $refNode;
        }
        
        $this->caret = new DomNode('#text');
        $node->parentNode->insertBefore($this->caret, $node);
        
    }

    public function println(string $line, $end = false)
    {return;
        $line = '<?php ' . $line . ' ?>';

        if ($end) {
            if ($this->caret->nextSibling) {
                $this->caret->parentNode->insertBefore(
                    new DomNode('#text', PHP_EOL.$line),
                    $this->caret->nextSibling
                );
            }
            else {
                $this->caret->parentNode->appendChild(new DomNode('#text', PHP_EOL.$line));
            }
        }
        else {
            $this->caret->parentNode->insertBefore(
                new DomNode('#text', PHP_EOL.$line),
                $this->caret
            );
        }
    }
    
    protected function depleteNode($node, callable $cb, $isHtml = false)
    {
        $attrs = $node->attributes ? $node->attributes : [];
        $extracted_attributes = [];

        foreach ($attrs as $a) {
            $k = $a->nodeName;

            if (strpos($k, $this->pf) === 0) {
                // unpack directive result attributes
                $directiveName = substr($k, strlen($this->pf));
                if ($directive = $this->process->getDirective($directiveName)) {
                    $result = $directive($a->nodeValue);
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
            $extracted_attributes[] = clone $a;
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

        $node->removeAttributes();
        
        foreach ($data as $k => $val) {
            $bk = ':'.$k;
            $bind = isset($binds[$bk]) ? $binds[$bk] : null;
            
            if ($bind) {
                $val = array_map(function($attr) {
                    return "'$attr'";
                }, $val);
                $val = array_merge($val, $bind);
                $val = 'attr('.implode(',',$val).')';
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
                $bval = 'attr('.implode(',',$bval).')';
            } else {
                $bval = $bval[0];
            }
            if ($this->isHtml && 0) { // todo: findout
                $rid = '__r'.uniqid();
                $this->process->toBeReplaced($rid, $bval);
                $bval = $rid;
            }
            $data[$bk] = $bval;
        }
        // imsert $c_structs
        $cstruct = null;
        $condNode = null;
        foreach ($c_structs as $struct) {
            list($statement, $args) = $struct;
            $phpnode = new PhpNode($statement, $args);
            if ($cstruct) {
                $cstruct->appendChild($phpnode);
            } else {
                $condNode = $phpnode;
            }
            $cstruct = $phpnode;
        }//d(''.$node);
        if ($condNode) {
            $node->parentNode->insertBefore($condNode, $node);
            $cstruct->appendChild($node->detach());
            $node = $condNode;
            //=dd(''.$node);
        }
        //dd(''.$node, $node);
        
        $cb($data, $c_structs);
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
                $val = "<?php echo $val; ?>";
            }
            elseif ($k === 'p-bind') {
                $rid = '__r'.uniqid();
                $k = '<?php foreach('.$val.' as $k=>$v) echo "$k=\"$v\" "; ?>';
                $val = '';
            }
            elseif ($k === 'p-raw') {
                $rid = '__r'.uniqid();
                $k = "<?php echo $val; ?>";
                $val = '';
            }
            $node->setAttribute($k, $val);
        }
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
//remove it
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
                $container = new DomDocument();dd(66);
                $slotNode = $container->importNode($slotNode, true);
                $container->appendChild($slotNode);
                $slots[$slotPosition][] = $container;
                $lastPos = $slotPosition;
            } else {
                // has dependencies above
                if (isset($slots[$lastPos])) {dd(1);
                    $i = count($slots[$lastPos]) -1;
                    $slotNode = $slots[$lastPos][$i]->importNode($slotNode, true);
                    $slots[$lastPos][$i]->appendChild($slotNode);
                }
            }
        }

        return $slots;
    }
    
    protected function removeNode($node) {
        $node->parentNode->removeChild($node);
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