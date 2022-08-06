<?php

namespace PhpTemplates\Dom;

class DomNode
{
    private static $last_id = 0;
    
    private $selfClosingTags = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
        'command',
        'keygen',
        'menuitem',    
    ];
    
    protected $nodeId;
    protected $nodeName;
    protected $nodeValue;
    protected $attrs = [];
    protected $parentNode;
    protected $childNodes = [];
    
    public $shortClose = false;
    public $lineNumber = 0;
    public $srcFile;
    
    public function __construct(string $nodeName, $nodeValue = '')
    {
        self::$last_id++;
        $this->nodeId = self::$last_id;
        $this->nodeName = trim($nodeName);
        if (is_array($nodeValue)) {
            foreach ($nodeValue as $k => $val) {
                if (is_array($val)) {
                    $val = var_export($val, true);
                }
                $this->setAttribute($k, $val);
            }
        } else {
            $this->nodeValue = $nodeValue;
        }
        $this->nodeName = $this->nodeName ? $this->nodeName : '#text';
    }
    
    public static function fromFile(string $srcFile, $options = []): self
    {
        $parser = new Parser();
        if (isset($options['preservePatterns'])) {
            foreach ($options['preservePatterns'] as $p) {
                $parser->addPreservePattern($p);
            }
        }
        
        return $parser->parseFile($srcFile);
    }
    
    public static function fromString(string $str, $options = []): self
    {
        $parser = new Parser();
        if (isset($options['preservePatterns'])) {
            foreach ($options['preservePatterns'] as $p) {
                $parser->addPreservePattern($p);
            }
        }
        
        return $parser->parseString($str);
    }
    
    public static function fromArray($arr)
    {
        $node = new DomNode($arr['nodeName'], $arr['nodeValue']);
        foreach ($arr['attrs'] as $attr) {
            $node->addAttribute($attr['nodeName'], $attr['nodeValue']);
        }
        foreach ($arr['childNodes'] as $cn) {
            $node->appendChild(self::fromArray($cn));
        }
        return $node;
    }
    
    public function addAttribute(DomNodeAttr $nodeName)
    {//todo
        if ($nodeName instanceof DomNodeAttr) {
            $attr = $nodeName;
        } else {
            $attr = new DomNodeAttr($nodeName, $nodeValue);
        }
        
        $this->attrs[] = $attr;
    }
    
    public function setAttribute(string $nodeName, string $nodeValue)
    {
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName == $nodeName) {
                $attr->nodeValue = $nodeValue;
                return;
            }
        }
        
        $this->addAttribute(new DomNodeAttr($nodeName, $nodeValue));
    }
    
    public function getAttribute(string $name)
    {
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName == $name) {
                return $attr->nodeValue;
            }
        }
        return null;
    }
    
    public function hasAttribute(string $name)
    {
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName == $name) {
                return true;
            }
        }
        return false;
    }
    
    public function removeAttributes()
    {
        $this->attrs = [];
    }
    
    public function appendChild($node) 
    {
        if (is_string($node)) {
            $node = self::fromString($node); //TODO: si la restul
        }
        $this->assertNotContained($this, $node);
        // set parent node first
        $node->parent($this);
        $this->childNodes[] = $node;
        
        return $node;
    }
    
    public function insertBefore($node, self $refNode)
    {
        if (is_string($node)) {
            $node = self::fromString($node); //TODO: si la restul
        }
        $this->assertNotContained($this, $node);
        $node->parent($this);
        $i = null;//TODO: array search da rateuri??? array_search($node, $this->childNodes, true);
        foreach ($this->childNodes as $j => $cn) {
            if ($cn === $refNode) {
                $i = $j;
                break;
            }
        }
        
        if (!is_null($i)) {
            array_splice($this->childNodes, $i, 0, [$node]);
        } else {
            $this->appendChild($node);
        }
        
        return $node;
    }
    
    public function removeChild(self $node)
    {
        $i = array_search($node, $this->childNodes, true);
        if ($i >= 0) {
            $this->childNodes[$i]->parentNode && $this->childNodes[$i]->detach();
            unset($this->childNodes[$i]);
            reset($this->childNodes);
        }
    }
    
    public function empty()
    {
        $this->childNodes = [];
    }
    
    public function detach()
    {
        if ($this->parentNode) {
            $parent = $this->parentNode;
            $this->parentNode = null;
            $parent->removeChild($this);
        }
        return $this;
    }
    
    public function cloneNode()
    {
        $arr = $this->__toArray();
        $clone = self::fromArray($arr);
        $clone->srcFile = $this->srcFile;
        $clone->lineNumber = $this->lineNumber;
        return $clone;
    }
    
    public function debug()
    {
        $x = ['tag' => $this->nodeName, 'node_id' => $this->nodeId, 'file' => $this->srcFile, 'line' => $this->lineNumber];
        if ($this->nodeName == '#text') {
            $x['text'] = $this->nodeValue;
        }
        foreach($this->childNodes as $cn) {
            $x['childs'][] = $cn->debug();
        }
        return $x;
    }
    
    public function __toArray()
    {
        $arr = [
            'nodeName' => $this->nodeName,
            'nodeValue' => $this->nodeValue,
            'attrs' => json_decode(json_encode($this->attrs), true),
            'childNodes' => [],
        ];
        foreach ($this->childNodes as $cn) {
            $arr['childNodes'][] = $cn->__toArray();
        }
        
        return $arr;
    }
    
    public function __toString()
    {
        // NODE START
        // don t indent texts
        $indentNL = $this->shouldIndent() ? $this->getIndent() : '';
        $return = $indentNL;
        if ($this->nodeName[0] != '#' && $this->nodeName) {
            $attrs = $this->attrs ? (' '.implode(' ', $this->attrs)) : '';
            $return .= '<'.$this->nodeName.$attrs.($this->shortClose ? '/>' : '>');
        }
        //$this->nodeName == 'x' && d($return);
        if ($this->nodeName == '#text' || !$this->nodeName) {
            $return .= $this->nodeValue;
            return $return;
        }
        elseif ($this->nodeName[0] == '#' && trim($this->nodeValue)) {
            $return .= $this->nodeValue;
        }
        
        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }
        
        // NODE END
        if (!$this->shortClose && $this->nodeName[0] != '#' && $this->nodeName && !$this->isSelfClosingTag()) {
            if (!$this->childNodes) {
                $indentNL = '';
            }
            $return .= $indentNL . "</{$this->nodeName}>";
        }
        
        return $return;
    }
    
    private function shouldIndent() 
    {
        if ($this->nodeName == '#text' && trim($this->nodeValue)) {
            return false;
        }
        if (isset($this->childNodes[0]) && $this->childNodes[0]->nodeName == '#text' && trim($this->childNodes[0]->nodeValue)) {
            return false;
        }
        return true;
    }
    
    public function parent($parentNode)
    {
        if ($this->parentNode) {
            debug_print_backtrace(2);
            throw new \Exception("Node already has a parent, detach it first");
        }
        $this->parentNode = $parentNode;
    }
    
    public function getIndent()
    {
        $level = 0;
        $c = $this;
        while ($c->parentNode) {
            $c = $c->parentNode;
            $level++;
        }
        $level--;
        if ($level <= 0) {
            return PHP_EOL;
        }
        return PHP_EOL.str_repeat('  ', $level);
    }
    
    /* GETTERS */
    public function __get($prop) 
    {
        if (method_exists($this, 'get'.ucfirst($prop))) {
            return $this->{'get'.ucfirst($prop)}();
        }
        return $this->{$prop};
    }
    
    public function getNodeName()
    {
        return $this->nodeName;
    }
    
    public function getParentNode()
    {
        return $this->parentNode;
    }
    
    public function getAttributes()
    {
        return new DomNamedNodeMap($this->attrs);
    }
    
    public function getRoot()
    {
        if (!$this->parentNode) {
            return null;
        }
        
        $node = $this;
        while ($node->parentNode) {
            $node = $node->parentNode;
        }
        
        return $node;
    }
    
    public function removeAttribute($name)
    {
        foreach ($this->attrs as $i => $attr) {
            if ($attr->nodeName == $name) {
                unset($this->attrs[$i]);
                return $this;
            }
        }
        return $this;
    }
    
    public function isSelfClosingTag()
    {
        return in_array($this->nodeName, $this->selfClosingTags);
    }
    
    public function changeNode($nodeName, $nodeValue = '')
    {
        $this->nodeName = $nodeName;
        $this->nodeValue = $nodeValue;
    }
    
    public function getNextSibling()
    {
        $i = null; //TODO: array search da rateuri??? array_search($node, $this->childNodes, true);
        $siblings = $this->parentNode->childNodes;
        foreach ($siblings as $j => $cn) {
            if ($cn === $this) {
                $i = $j;
                break;
            }
        }
        
        if (isset($siblings[$i+1])) {
            return $siblings[$i+1];
        }
    }
    
    public function getNextSiblings()
    {
        $result = [];
        $i = false; //TODO: array search da rateuri??? array_search($node, $this->childNodes, true);
        $siblings = $this->parentNode->childNodes;
        foreach ($siblings as $cn) {
            if ($cn === $this) {
                $i = true;
                continue;
            }
            if ($i) {
                $result[] = $cn;
            }
        }
        
        return $result;
    }
    
    public function getSrcFile() 
    {
        $root = $this;
        while (!$root->srcFile && $root->nodeName != '#root') {
            $root = $this->parentNode;
        }
        return $root->srcFile;
    }
    
    private function assertNotContained($parent, $append) 
    {
        if ($parent === $append) {
            throw new \Exception('Parent Node is contained by appended Node. This will cause recursivity');
        }
        foreach ($append->childNodes as $cn) {
            $this->assertNotContained($parent, $cn);
        }
    }
    
    public function d()
    {
        echo PHP_EOL;
        echo '<pre>';
        echo htmlentities((string) $this);
        echo '</pre>';
        echo PHP_EOL;
    }
    
    public function dd() 
    {
        $this->d();
        die();
    }
    
    public function querySelector($selector = '')
    {
        return (new QuerySelector($this))->find($selector, false);
    }
    
    public function querySelectorAll($selector = '')
    {
        return (new QuerySelector($this))->find($selector);
    }
}