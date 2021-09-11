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
    public $functions = [];
    public $components = [];
    public $replaces = [];

    public function __construct(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->uid = (self::$index++);
        //$this->options = $this->mergeOptions($options);
        $this->data = $data;
        $this->slots = $slots;
        $this->requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        $this->srcFile = $this->getSrcFile();
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    protected function getSrcFile()
    {
        if (!$this->srcFile) {
            $f = $this->options['src_path'];
            $this->srcFile = $f.$this->requestName.'.template.php';
        }
        return $this->srcFile;
    }
    
    // based on this output, we decide if to recompile template
    protected function getDestFile()
    {
        if (!$this->destFile) {
            $f = str_replace('/', '_', $this->requestName);
            if ($this->options->track_changes) {
                $f .= '-'.self::getUpdatedAt($this->getSrcFile());
            }
            if ($slotsHash = $this->getHash()) {
                $f .= '-'.$slotsHash;
            }
            $this->destFile = $f;
        }
        return $this->destFile;
    }
    
    
    public function getHash()
    {
        $hash = filemtime($this->getSrcFile()).$this->uid;
        foreach ($this->slots as $n => $slot) {
            $slots = is_array($slot) ? $slot : [$slot];
            foreach ($slots as $slot) {
                if ($slot instanceof self) {
                    $hash .= $n.$slot->getHash();
                } 
                else {
                    throw new Exception('Non component detected');
                }
            }
        }
    
        return substr(md5($hash, true), 0, 12);
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
    
    
    public function getUniqueName()
    {
        return $this->name . $this->uid . '_';
    }

    public function parse(Parser $root)
    {
        $this->root = $root;
        $this->loadHtml(file_get_contents($this->srcFile));
        $this->insertQuerySlots();
        $html = $this->parseNode($this);
        if ($this->name) {
            $html = $this->trimHtml($html);
        } else {
            $html = $html->saveHtml();
        }
        if (!$this->slots && $this->name) {
            $root->components[$this->requestName] = $html;
        }
        if ($this->data && $this->name) {
            $fname = $this->slots ? $this->getUniqueName() : $this->requestName;
            $root->functions[] = $fname;
            $root->components[$fname] = $html;
            return $fname."($fname)";
        } else {
            return $html;
        }
    }
    
    private function parseNode($node)
    {
        if ($node->nodeName === 'slot') {
            $this->insertSlot($node);
        }
        
        foreach ($node->childNodes ?? [] as $_node) {
            $this->parseNode($_node);
        }
        return $node;
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
    
    private function insertSlot($node)
    {
        $slotName = $node->getAttribute('name');
        if (!isset($this->slots[$slotName])) {
            return;
        }
        $slot = $this->slots[$slotName];
        $node->parentNode->insertBefore(
            $this->createTextNode($slot->parse($this->root)), // daca are data, intoarce function call, daca nu, intoarce string html. In ambele cazuri, recicleaza req name daca nu are sloturi si e comp pura
            $node
        );
        $node->parentNode->removeChild($node);
    }
    
    public function trimHtml($dom)
    {
        $body = $dom->getElementsByTagName('body')->item(0);
        $content = '';
        foreach ($body->childNodes as $node)
        {
            $content.= $dom->saveHtml($node);
        }
        return $content;
    }
    
    public function __get($prop)
    {
        return $this->$prop;
    }
}