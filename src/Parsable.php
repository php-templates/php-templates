<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;

class Parsable
{
    protected static $last_id = 1;
    protected static $cache = [];
    
    protected $id;
    
    protected $attrs = [
        
    ];
    
<<<<<<< HEAD
    public function __construct($rfilepath, $data = null, $slots = [], $comp = true)
=======
    public function __construct($srcFile, $data = null, $slots = [], array $options = [], $comp = true)
>>>>>>> refs/heads/dev
    {
        $this->id = (self::$last_id++);
        //d($this->id);
        if (is_string($rfilepath)) {
            $requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            $name = str_replace(['/', '\\'], '_', $requestName);
            $this->name = preg_replace('/(?![a-zAZ0-9_]+)./', '', $name);
            $f = Config::get('src_path');
            $srcFile = $f.$requestName.'.template.php';
            $this->srcFile = $srcFile;
        } else {
            $this->dom = $rfilepath;
        }
        $this->data = $data;
        foreach ($slots as $slot) {
            $slot = is_array($slot) ? $slot : [$slot];
            foreach ($slot as $s) {
                //$s->nestLevel = $this->nestLevel +1;
            }
        }
        
        $this->slots = $slots;
        $this->attributes = $options['attributes'] ?? [];
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
        // load dom and check for switches on data and add them to name
        if (!$this->dom && $this->srcFile) {
<<<<<<< HEAD
            // se va face pe main root, cu acces la acelasi codebuffer
            // verificam daca e deja incarcata
            // compunem numele cu req si data cu switches
            // verificam daca nu cumva e deja parsata... e deja prea tarziu... trebuie facut lucrul asta in Parser
            // 
            $dom = new HTML5DOMDocument;//d($this->srcFile);
            $dom->formatOutput = true;
            $html = file_get_contents($this->srcFile);
            $html = $this->removeHtmlComments($html);
            $dom->loadHtml($html);
            if ($this->is_component) {
                $dom = $this->trimHtml($dom);
=======
            if (!isset(self::$cache[$this->srcFile])) {
                $dom = new HTML5DOMDocument;//d($this->srcFile);
                $dom->formatOutput = true;
                $html = file_get_contents($this->srcFile);
                $html = $this->removeHtmlComments($html);
                $dom->loadHtml($html);
                if ($this->is_component) {
                    $dom = $this->trimHtml($dom);
                }
                self::$cache[$this->srcFile] = $dom;
>>>>>>> refs/heads/dev
            }
            $this->dom = self::$cache[$this->srcFile]->cloneNode(true);
            $this->addDynamicAttrs();
        }

        return $this->dom;
    }
    
    public function getName()
    {
        if (!$this->name) {
            if ($this->srcFile) {
 
            }
            else {
                $this->name = 'custom_slot_'.uniqid();
            } 
        }
        return $this->name;
    }
    
    public function getDataKey()
    {
        if (is_string($this->data)) {
            return $this->data;
        }
        return '__slot_data'.$this->id;
    }
    
    public function getName()
    {
        return str_replace(['.template.php', '/', '-'], ['', '_', ''], $this->srcFile);
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
    
  
    private function addDynamicAttrs()
    {
        foreach ($this->attributes as $key => $value) {
            $this->dom->setAttribute($key, $value);
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
