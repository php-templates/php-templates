<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Template;

class Parser extends HTML5DOMDocument
{
    public static $root = null;
    private $options = [
        
    ];
    
    private $data;
    private $slots;
    public $components = [];
    public $replaces = [];
    
    public function __construct(string $srcFile, array $data = [], array $slots = [], array $options = [])
    {
        $file = file_get_contents($srcFile);
        $this->loadHtml($file);
        $this->data = $data;
        $this->slots = $slots;
        $this->options = (object) $options;
        $this->insertQuerySlots();
    }
    
    public function parse()
    {
        //aicisa fac parse peste ele. cand ajung la o componenta, o instantiez cu numele. daca are sloturi, ii fac nume unic si o pun pe replaces. daca are date, ii fac dunctie
        //recursivitatea se face in components
        //check if any dynamic slots and parse file for dynamic slots query and replace them with uniq name
        
        // parse this file, and foreach found slot call load m
        // foreach if tag name slot check in slots
        // slot will be a string as result of load with o to return string
        // if slot has data, replace slot with closure function if slot has slots, f will be unique, k => val
        // if slot has no data, replace slot with uname and k val global
        //   foreach slots slots, call load
        $this->recursiveParse($this);

        //dd($this->saveHtml());
    }
    
    private function recursiveParse($node)
    {
        if ($node->nodeName === 'slot') {
            $this->insertSlot($node);
        }
        
        foreach ($node->childNodes ?? [] as $_node) {
            $this->recursiveParse($_node);
        }
    }
    
    private function insertQuerySlots()
    {
        if (!$this->slots) {
            return;
        }

        foreach ($this->slots as $name => $slot) {
            if (strpos($name, 'q:')) {
                // is query slot
                $this->addDynamicSlot(str_replace('q:', $name), $slot);
                unset($this->slots[$name]);
            }
        }
    }

    public function addDynamicSlot($q, $slot)
    {
        $o = $slot->getOptions();
        $slot = $this->createNodeElement('slot');
        $sname = 's'.uid();
        $slot->addAttribute('name', $sname);
        $this->slots[$sname] = $slot;
        if ($o['all']) {
            $ref = $this->querySelectorAll($q);
        } else {
            $ref = [$this->querySelector($q)];
        }
        $pos = $o['position'] ?? null;
        foreach ($ref as $node) {
            if ($pos === 'before') {
                $this->insertBefore($slot, $node);
            }
            elseif ($pos === 'after') {
                $this->insertAfter($slot, $node);
            }
            else {
                $this->dom_node_insert_before();
                $this->removeNode($node);
            }
        }
    }
    
    private function insertSlot($node)
    {
        $slotName = $node->getAttribute('name');
        if (!isset($this->slots[$slotName])) {
            return;
        }

        // if slot has childslots, function/replace will be unique name
        $slotReplace = str_replace('-', '_', $slotName);
        if ($this->slots[$slotName]->hasSlots()) {
            $slotReplace .= uniqid();
        }
        // insert scoped slot if node's slot has data
        if ($this->slots[$slotName]->hasData()) {
            $slotReplace .= "()";
            
        }

        $node->parentNode->insertBefore(
            $this->createTextNode('babababab'),
            $node
        );
        $node->parentNode->removeChild($node);
    }
}