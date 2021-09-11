<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Template;

class Parser extends HTML5DOMDocument
{
    protected static $index = 0;
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
    //protected $checkedDependencies = [];
    protected $requestName;
    protected $srcFile;
    protected $destFile;
    protected $slots = [];
    public $replaces = [];

    public function __construct(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->uid = (self::$index++);
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

    public function parse(Parser $root)
    {
        $this->loadHtml(require($this->destFile));
        $this->insertQuerySlots();
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