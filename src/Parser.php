<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Template;

class Parser extends HTML5DOMDocument
{
    private $options = [
        
    ];
    
    private $data;
    private $slots;
    
    public function __construct(string $srcFile, array $data = [], array $slots = [], array $options = [])
    {
        // parent::__construct($srcFile);
        // $this->load($srcFile);
        $file = file_get_contents($srcFile);
        $this->loadHtml($file);
        
        echo $this->saveHtml();
        die();
        // set slots set data, if q slots, set ukey then as name in slot
        // add slots too
        $this->data = $data;
        $this->slots = $slots;
        $this->options = (object) $options;

        $this->prepareSlots();
    }
    
    public function parse()
    {
        //check if any dynamic slots and parse file for dynamic slots query and replace them with uniq name
        
        // parse this file, and foreach found slot call load m
        // foreach if tag name slot check in slots
        // slot will be a string as result of load with o to return string
        // if slot has data, replace slot with closure function if slot has slots, f will be unique, k => val
        // if slot has no data, replace slot with uname and k val global
        //   foreach slots slots, call load
        $this->recursiveParse($this);
    }
    
    private function recursiveParse($node)
    {echo $node->nodeName;
        if ($node->nodeName === 'slot') {
            $this->insertSlot($node);
        }
        
        foreach ($this->childNodes as $node) {
            $this->recursiveParse($node);
        }
    }
    
    private function prepareSlots()
    {
        if (!$this->slots) {
            return;
        }

        foreach ($this->slots as $name => $slot) {
            $this->validateSlotType($slot);
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
        $this->insertBefore(
            $this->createTextNode('babababab'),
            $node
        );
    }

    private function validateSlotType($slot)
    {
        if (!is_array($slot) && !($slot instanceof Template)) {
            $t = gettype($slot);
            if ($t === 'object') {
                $t = get_class($slot) ?? $t;
            }
            throw new \Exception('Slots must be instances of '.Template::class.' or array of instances of '.Template::class. ', '.$t.' given');
        }
        $_slots = is_array($slot) ? $slot : [$slot];
        foreach ($_slots as $s) {
            if (!($s instanceof Template)) {
                $t = gettype($s);
                if ($t === 'object') {
                    $t = get_class($s) ?? $t;
                }
                throw new \Exception('ArraySlots must contain only instances of '.Template::class. ', '.$t.' given');
            }
        }
    }
}