<?php

namespace PhpTemplates\Entities;

abstract class Parser
{
    protected $context;
    protected $node;
    protected $caret;
    protected $reservedAttrs = [];
    
    public function __construct(Document $doc, $node, $context)
    {
        $this->document = $doc;
        $this->node = $node;
        $this->makeCaret();
    }
    
    abstract public function rootContext();
    abstract public function componentContext();
    abstract public function slotContext();
   
    public function getRoot() {
        if ($this->context) {
            return $this->context->getRoot();
        }
        return $this;
    }
    
    protected function makeCaret()
    {
        $node = $this->getRoot()->node;
        $caret = $node->ownerDocument->createTextNode('caret');
        //$this->document->toberemoved[] = $caret;
        $node->parentNode->insertBefore($caret, $node);
    }
    // copy paste parser functionalities
    protected function println(string $line)
    {
        $this->caret->parentNode->insertBefore(
            $this->caret->ownerDocument->createTextNode($line),
            $this->caret
        );
    }
    
    protected function depleteNode($node)
    {
        $data = [];
        foreach ($node->attributes as $a) {
            $node->removeAttribute($a->nodeName);
            $k = $a->nodeName;
            if (strpos($k, $this->pf) === 0) {
                $k = substr($k, strlen($this->pf));
                if (in_array($k, Config::allowedControlStructures)) {
                    $this->controlStructure($k, $a->nodeValue, $this->caret);
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
            if (!in_array($k, $this->reservedAttrs)) {
                $data[$k][] = $val;
            }
        }
        
        foreach ($data as $k => $val) {
            if (count($val) > 1) {
                $data[$k] = 'Helper::mergeAttrs('.implode(',',$val).')';
            } else {
                $data[$k] = $val;
            }
        }
        
        return $data;
    }

}