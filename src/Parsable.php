<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;

class Parsable
{
    protected static $last_id = 1;
    
    protected $id;
    
    protected $attrs = [
        //'nestLevel' => 0
    ];
    
    public function __construct($srcFile, $data = null, $slots = [], $comp = true)
    {
        $this->id = (self::$last_id++);
        
        //d($this->id);
        if (is_string($srcFile)) {
            $this->srcFile = $srcFile;
        } else {
            $this->dom = $srcFile;
        }
        $this->data = $data;
        foreach ($slots as $slot) {
            $slot = is_array($slot) ? $slot : [$slot];
            foreach ($slot as $s) {
                //$s->nestLevel = $this->nestLevel +1;
            }
        }
        
        $this->slots = $slots;
        $this->is_component = $comp;
    }
    
    public function __set($prop, $val)
    {
        $this->attrs[$prop] = $val;
    }
    
    public function __get($prop)
    {
        return $this->attrs[$prop] ?? null;
    }
    
    public function getDom()
    {
        if (!$this->dom && $this->srcFile) {
            $dom = new HTML5DOMDocument;//d($this->srcFile);
            $dom->formatOutput = true;
            $html = file_get_contents($this->srcFile);
            $html = $this->removeHtmlComments($html);
            $dom->loadHtml($html);
            if ($this->is_component) {
                $dom = $this->trimHtml($dom);
            }
            $this->dom = $dom;
        }

        return $this->dom;
    }
    
    public function getDataKey()
    {
        if (is_string($this->data)) {
            return $this->data;
        }
        return '__slot_data'.$this->id;
    }
    
    public function trimHtml($dom)
    {
        $body = $dom->getElementsByTagName('body')->item(0);
        return $body->childNodes->item(0);
        
        
        $content = '';
        foreach ($body->childNodes as $node)
        {
            $content.= $dom->saveHtml($node);
        }
        return $content;
    }
            
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }
    
  
    private function addDynamicAttr()
    {
        $body = $this->getElementsByTagName('body')->item(0);
        if ($body->childNodes && $body->childNodes->count() === 1 && method_exists($body->firstChild, 'setAttribute')) {
            foreach ($this->attrs as $attr => $value) {
                //$body->firstChild->setAttribute($attr, $value);
            }
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
                $this->addSlotNode(str_replace('q:', $name), $slot);
                unset($this->slots[$name]);
            }
        }
    }

    private function addSlotNode($q, $slot)
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
    
}