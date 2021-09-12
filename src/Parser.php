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

    public function __construct($rfilepath, $data = [], array $slots = [], array $options = [])
    {
        $this->uid = (self::$index++);
        //$this->options = $this->mergeOptions($options);
        $this->data = $data;
        $this->slots = $slots;
        if ($rfilepath) {
            $this->requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            $this->srcFile = $this->getSrcFile();
        }
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    protected function getSrcFile()
    {
        if (!$this->requestName) {
            return null;
        }
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
        return str_replace('-', '', $this->name) . $this->uid . '_';
    }

    public function parse(Parser $root)
    {
        $this->root = $root;
        if ($this->srcFile) {
            if (!file_exists($this->srcFile)) {
                return '';
            }
        $this->loadHtml(file_get_contents($this->srcFile));
        }
        $this->insertQuerySlots();
        $html = $this->parseNode($this);
        if ($this->name) {
            $html = $this->trimHtml($html);
        } else {
            $html = $html->saveHtml();
        }
        //if ($this->name === 'components/component-slot') dd($html);
        if (!$this->slots && $this->name) {
            $root->components[$this->requestName] = $html;
        }
        if ($this->data && $this->name) {
            $fname = $this->slots ? $this->getUniqueName() : $this->requestName;
            $root->functions[] = $fname;
            $root->components[$fname] = $html;
            $bindVar = is_string($this->data) ? $this->data : $fname;
            // daca data e string, ia l ca atare, ca e component. else e slot
            return $fname."($bindVar)";
        } else {
            return $html;
        }
    }
    
    private function parseNode($node)
    {
        if ($node->nodeName === 'slot') {
            $this->insertSlot($node);
        } 
        elseif ($node->nodeName === 'component') {
            $this->insertComponent($node);
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
        if (!$slotName) {
            $slotName = 'default';
        }
        if (!isset($this->slots[$slotName])) {
            // stergem doar daca nu are default ceva
            //$node->parentNode->removeChild($node);
            return;
        }
        $slots = $this->slots[$slotName];
        if (!is_array($slots)) {
            $slots = [$slots];
        }
        foreach ($slots as $slot) {
            $node->parentNode->insertBefore(
                $this->createTextNode($slot->parse($this->root)), // daca are data, intoarce function call, daca nu, intoarce string html. In ambele cazuri, recicleaza req name daca nu are sloturi si e comp pura
                $node
            );
        }
        //$node->parentNode->removeChild($node);
    }
    
    private function insertComponent($node)
    {
        $rfilepath = $node->getAttribute('src');
        $data = $node->getAttribute('data') ?? [];
        $slots = [];
        foreach ($node->childNodes as $slotNode) {
            $sname = 'default';
            $sdata = [];
            if (method_exists($slotNode, 'getAttribute')) {
                $sname = $slotNode->getAttribute('slot') ?? 'default';
                $sdata = $slotNode->getAttribute('data') ?? [];
            } 
            elseif (!trim($slotNode->wholeText)) {
                continue;
            }
            $slot = new Parser(null, $sdata);
            $slot->setName($sname);
            //dd(, $slotNode);
            //dd($this->saveHtml($slotNode));
            $slot->loadHtml($this->saveHtml($slotNode));
            $slots[$sname][] = $slot;
        }
        $comp = new Parser($rfilepath, $data, $slots);
        $comp->setName($comp->requestName);
        $comp = $comp->parse($this->root);
        $node->parentNode->insertBefore(
            $this->createTextNode($comp), // daca are data, intoarce function call, daca nu, intoarce string html. In ambele cazuri, recicleaza req name daca nu are sloturi si e comp pura
            $node
        );
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