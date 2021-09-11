<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Template;

class Parser extends HTML5DOMDocument
{
    // requestName => [requestName => filemtime, ...other components]
    protected static $dependencies = null;
    protected static $timestamps = []; // cache file $timestamps
    protected static $index = 0;
    protected static function getUpdatedAt(string $file)
    {
        if (!isset(self::$timestamps[$file])) {
            self::$timestamps[$file] = filemtime($file);
        }
        return self::$timestamps[$file];
    }
    
    public static function resetId()
    {
        self::$index = 0;
    }
    

    protected $options = [
        'prefix' => '@',
        'src_path' => 'views/',
        'dest_path' => 'parsed/',
        'track_changes' => true,
        'trim_html' => false
    ];
    
    // instance variables
    private $uid = 0;
    private $name;
    protected $checkedDependencies = [];
    protected $requestName;
    protected $srcFile;
    protected $destFile;
    protected $slots = [];

    
    
    
    
    
    private $root = null;
    private $options = [
        
    ];
    
    private $data;
    private $slots;
    public $components = [];
    public $replaces = [];
    
    public function __construct(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->uid = (self::$index++);
        
        if (self::$dependencies === null) {
            self::$dependencies = require_once('dependencies_map.php');
        }
        
        $this->options = $options;
        $this->data = $data;
        $this->slots = $slots;
        $this->requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        $this->srcFile = $this->getSrcFile();
    }
    
    protected function mergeOptions($options)
    {
        // in this phase, we already have seted all dom global datas
        if (isset($options['prefix'])) {
            if (!trim($options['prefix'])) {
                unset($options['prefix']);
            }
        }
        $this->options = array_merge($this->options, $options);
    }
    
    public function parseCached(Parser $root): string
    {
        $this->destFile = $this->getDestFile();
        
        //$hasChanged = $this->options->track_changes && $this->syncDependencies($this->requestName);
        //if (!$hasChanged && file_exists($this->destFile)) {
            //$this->mountSlots($this);
            //return require($this->destFile);
        //}
        //
        $this->parse($root);
        // set file content
        return $root;
    }
    
    public function addGlobalData(Template $root)
    {
        // montam datele pe Template::data daca exista
        $root->data[$this->getVariableName()] = $this->data;
    }

    public function parse(Parser $root)
    {
        $this->loadHtml(require($this->destFile));
        $this->insertQuerySlots();
        // in this stage, we have a normalized template file to parse, data seted on globale
        // load src file
        // parse it
        // return it trimmed
        // if is root, mount don t, just return it
        
        // parse this file, and foreach found slot call load m
        // foreach if tag name slot check in slots
        // slot will be a string as result of load with o to return string
        // if slot has data, replace slot with closure function if slot has slots, f will be unique, k => val
        // if slot has no data, replace slot with uname and k val global
        //   foreach slots slots, call load
        $this->recursiveParse($this);
        return $this;
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
                $this->addSlotNode(str_replace('q:', $name), $slot);
                unset($this->slots[$name]);
            }
        }
    }

    public function addSlotNode($q, $slot)
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

        // insert scoped slot if node's slot has data
        if ($this->slots[$slotName]->getData()) {
            
        } else {// foreach slot cazul []
            $this->root->replaces[$slotName] = $this->slots[$slotName]->loadParsed($this->root);
        }

        $node->parentNode->insertBefore(
            $this->createTextNode($this->slots[$slotName]->loadParsed($this->root)),
            $node
        );
        $node->parentNode->removeChild($node);
    }
}