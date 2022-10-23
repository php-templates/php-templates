<?php

namespace PhpTemplates\Dom;

use PhpTemplates\Source;

class DomNode
{
    private static $last_id = 0;

    /**
     * A list of all self closing tags (used by __toString method in order to know when or not to close a html tag)
     *
     * @var array
     */
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

    /**
     * node unique id, used for debugging
     *
     * @var string
     */
    protected $nodeId;

    /**
     * DomNodeElement name, like input, textarea, div, etc.
     * Nodes without rendering tags (like textnodes) will start with '#' and they will output only their 'nodeValue'
     *
     * @var string
     */
    protected $nodeName;

    /**
     * Node value outputed only by textnodes, prefixed with # in nodeName
     *
     * @var [type]
     */
    protected $nodeValue;

    /**
     * Array of node attributes
     *
     * @var array
     */
    protected $attrs = [];

    /**
     * Parent node, null if rootnode
     *
     * @var self|null
     */
    protected $parentNode;

    /**
     * Array of childNodes
     *
     * @var array
     */
    protected $childNodes = [];

    /**
     * Used for rendering, it says if parsed syntax was like: <div/>, or in case of false: <div></div>
     *
     * @var boolean
     */
    public $shortClose = false;

    /**
     * For debugging, we keep the line number where node was found in source input string
     *
     * @var integer
     */
    public $lineNumber = 0;

    /**
     * For debugging, we keep the file path of the source input string
     *
     * @var string
     */
    public $srcFile;

    /**
     * Used by __toString to determine if should insert "PHP_EOL . $indent_level" after &lt;open-tag&gt;
     *
     * @var boolean
     */
    public $indentStart = true;

    /**
     * Used by __toString to determine if should insert "PHP_EOL . $indent_level" before &lt;/close-tag&gt;
     *
     * @var boolean
     */
    public $indentEnd = true;

    /**
     * @param string $nodeName - div, span, etc. In case of textnode, prefix it with '#' and name it as you wish
     * @param mixed $nodeValue - if textnode, it should be string. If domNode, it can be a key => value array containing attributes.
     * ex: ['class' => 'foo bar']
     */
    public function __construct(string $nodeName, $nodeValue = '')
    {
        self::$last_id++;
        $this->nodeId = self::$last_id;

        $this->nodeName = trim($nodeName);

        // short node declaration syntax
        if (is_array($nodeValue))
        {
            foreach ($nodeValue as $k => $val) {
                if (is_array($val)) {
                    $val = var_export($val, true);
                }
                $this->addAttribute($k, $val);
            }
        }
        else {
            $this->nodeValue = $nodeValue;
        }

        $this->nodeName = $this->nodeName ? $this->nodeName : '#text';
        if ($this->nodeName == '#text' && strpos($this->nodeValue, "\n") === false) {
            $this->indentStart = $this->indentEnd = false;
        }
    }

    /**
     * Actual print process
     *
     * @return string
     */
    public function __toString()
    {
        $indentEnd = $this->indentEnd;
        if ($indentEnd) {
            $indentEnd = !!array_filter($this->childNodes, function ($cn) {
                // nu face indent daca ultimul child e text
                return $cn->nodeName != '#text';
            });
        }
        $this->indentEnd = $indentEnd;

        // NODE START
        // don t indent texts
        $return = $this->indentStart ? $this->getIndent() : '';
        if ($this->nodeName[0] != '#' && $this->nodeName) {
            $attrs = implode(' ', $this->attrs);
            $attrs = $attrs ? ' ' . $attrs : '';
            $return .= '<' . $this->nodeName . $attrs . ($this->shortClose ? '/>' : '>');
        }
        //$this->nodeName == 'x' && d($return);
        if ($this->nodeName == '#text' || !$this->nodeName) {
            $return .= $this->nodeValue;
            return $return;
        } elseif ($this->nodeName[0] == '#' && trim($this->nodeValue)) {
            $return .= $this->nodeValue;
        }

        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        // NODE END
        if (!$this->shortClose && $this->nodeName[0] != '#' && $this->nodeName && !$this->isSelfClosingTag()) {
            $return .= $this->indentEnd ? $this->getIndent() : '';
            $return .= "</{$this->nodeName}>";
        }

        return $return;
    }

    /**
     * Create a new dom structure from a given string.
     * This fn will try to capture its call location in order to give relevant data for debugging
     *
     * @param string $str
     * @return self
     */
    public static function fromString(string $str): self
    {
        // for debug
        $bt = debug_backtrace(5);
        while (count($bt) > 1 &&  strpos($bt[0]['file'], 'DomNode.php') !== false) {
            array_shift($bt);
        }

        $srcFile = $bt[0]['file'];
        $startLine = $bt[0]['line'];
        $source = new Source($str, $srcFile, $startLine);
        $parser = new Parser();

        return $parser->parse($source);
    }

    /**
     * Create a new dom structure from a given array.
     * The array should be in the given format: ['nodeName' => '...', 'nodeValue' => ('string'|array of attributes), 'childNodes' => __recursion]
     * This fn will try to capture its call location in order to give relevant data for debugging
     *
     * @param array $arr
     * @return self
     */
    public static function fromArray(array $arr): self
    {
        // for debug
        $bt = debug_backtrace(5);
        while (count($bt) > 1 &&  strpos($bt[0]['file'], 'DomNode.php') !== false) {
            array_shift($bt);
        }
        $srcFile = $bt[0]['file'];

        $node = new DomNode($arr['nodeName'], $arr['nodeValue']);
        $node->srcFile = $srcFile;
        foreach ($arr['attrs'] as $attr) {
            $node->addAttribute($attr['nodeName'], $attr['nodeValue']);
        }

        foreach ($arr['childNodes'] as $cn) {
            $cn = self::fromArray($cn);
            $cn->srcFile = $srcFile;
            $node->appendChild($cn);
        }

        return $node;
    }

    /**
     * Add an attribute to node
     *
     * @param string|DomNodeAttr $nodeName
     * @param string $nodeValue
     * @return void
     */
    public function addAttribute($nodeName, string $nodeValue = '')
    {
        if ($nodeName instanceof DomNodeAttr) {
            $incoming = $nodeName;
        }
        else {
            $incoming = new DomNodeAttr($nodeName, $nodeValue);
        }

        $this->attrs[] = $incoming;
    }

    /**
     * Add an attribute to node. If an already existing attribute will be found by given name, its value will be overriden
     *
     * @param string $nodeName
     * @param string $nodeValue
     * @return void
     */
    public function setAttribute(string $nodeName, string $nodeValue = '')
    {
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName == $nodeName) {
                $attr->nodeValue = $nodeValue;
                return;
            }
        }

        $this->addAttribute(new DomNodeAttr($nodeName, $nodeValue));
    }

    /**
     * Get node attribute value by attribute name, null if no attribute found
     *
     * @param string $name
     * @return mixed
     */
    public function getAttribute(string $name)
    {
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName == $name) {
                return $attr->nodeValue;
            }
        }

        return null;
    }

    /**
     * Determine if an attribute exists on current node, by its name
     *
     * @param string $name
     * @return boolean
     */
    public function hasAttribute(string $name): bool
    {
        foreach ($this->attrs as $attr) {
            if ($attr->nodeName == $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * Remove node attribute, return node instance
     *
     * @param string $name
     * @return self
     */
    public function removeAttribute(string $name): self
    {
        foreach ($this->attrs as $i => $attr) {
            if ($attr->nodeName == $name) {
                unset($this->attrs[$i]);
                return $this;
            }
        }
        return $this;
    }

    /**
     * Remove all node attributes
     *
     * @return void
     */
    public function removeAttributes()
    {
        $this->attrs = [];
    }

    /**
     * Append a new child node to current node and returns appended child instance.
     * If appended node already exists in this node flow, it will throw an error to prevent infinite recursion
     *
     * @param self|string $node - when string, we will call self::fromString to obtain a virtual node
     * @return self
     */
    public function appendChild($node)
    {
        if (is_string($node)) {
            $node = self::fromString($node);
        }
        else {
            $this->assertNotContained($this, $node);
        }

        // set parent node first
        $node->parent($this);
        $this->childNodes[] = $node;

        return $node;
    }

    /**
     * Insert a child node before another given childnode
     * If appended node already exists in this node flow, it will throw an error to prevent infinite recursion
     *
     * @param self|string $node - when string, we will call self::fromString to obtain a virtual node
     * @return self
     */
    public function insertBefore($node, self $refNode)
    {
        if (is_string($node)) {
            $node = self::fromString($node);
        }
        else {
            $this->assertNotContained($this, $node);
        }

        $node->parent($this);
        $i = null;
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

    /**
     * Insert a child node after another given childnode
     * If appended node already exists in this node flow, it will throw an error to prevent infinite recursion
     *
     * @param self|string $node - when string, we will call self::fromString to obtain a virtual node
     * @return self
     */
    public function insertAfter($node, self $refNode)
    {
        if (is_string($node)) {
            $node = self::fromString($node);
        }
        else {
            $this->assertNotContained($this, $node);
        }

        $node->parent($this);
        $i = null;
        foreach ($this->childNodes as $j => $cn) {
            if ($cn === $refNode) {
                $i = $j;
                break;
            }
        }

        if (!is_null($i)) {
            array_splice($this->childNodes, $i - 1, 0, [$node]);
        } else {
            $this->appendChild($node);
        }

        return $node;
    }

    /**
     * Remove given childnode
     *
     * @param self $node
     * @return void
     */
    public function removeChild(self $node)
    {
        $i = array_search($node, $this->childNodes, true);
        if ($i >= 0) {
            $this->childNodes[$i]->parentNode && $this->childNodes[$i]->detach();
            unset($this->childNodes[$i]);
            $this->childNodes = array_values($this->childNodes);
        }
    }

    /**
     * Remove all childnode
     *
     * @return void
     */
    public function empty()
    {
        $this->childNodes = [];
    }

    /**
     * Remove childnode from its parent and returns it available to be attached (insert,append) elsewhere
     *
     * @return void
     */
    public function detach()
    {
        if ($this->parentNode) {
            $parent = $this->parentNode;
            $this->parentNode = null;
            $parent->removeChild($this);
        }
        return $this;
    }

    /**
     * Returns an exact node clone, excluding its parent
     *
     * @return void
     */
    public function cloneNode()
    {
        $arr = $this->__toArray();
        $clone = self::fromArray($arr);
        $clone->srcFile = $this->srcFile;
        $clone->lineNumber = $this->lineNumber;
        return $clone;
    }

    public function getPrevSibling()
    {
        $i = null;
        $siblings = $this->parentNode->childNodes;
        foreach ($siblings as $j => $cn) { //d($cn->nodeName);
            if ($cn === $this) {
                $i = $j;
                break;
            }
        }

        if (isset($siblings[$i - 1])) {
            return $siblings[$i - 1];
        }
    }

    public function getNextSibling()
    {
        $i = null;
        $siblings = $this->parentNode->childNodes;
        foreach ($siblings as $j => $cn) {
            if ($cn === $this) {
                $i = $j;
                break;
            }
        }

        if (isset($siblings[$i + 1])) {
            return $siblings[$i + 1];
        }
    }

    public function getNextSiblings()
    {
        $result = [];
        $i = false;
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

    /**
     * non complex css selectors supported
     *
     * @param string $selector
     * @return self|null - returns first childNodes matching the given selector. May return null in case of nothing found
     */
    public function querySelector(string $selector)
    {
        return (new QuerySelector($this))->find($selector, false);
    }

    /**
     * non complex css selectors supported
     *
     * @param string $selector
     * @return array - returns an array of childNodes matching the given selector
     */
    public function querySelectorAll(string $selector)
    {
        return (new QuerySelector($this))->find($selector);
    }

    /**
     * returns an array representation of dom structure
     *
     * @return void
     */
    public function debug()
    {
        $x = ['tag' => $this->nodeName, 'node_id' => $this->nodeId, 'file' => $this->srcFile, 'line' => $this->lineNumber];
        if ($this->nodeName == '#text') {
            $x['text'] = $this->nodeValue;
        }
        foreach ($this->attrs as $a) {
            $x['attrs'][$a->nodeName] = $a->nodeValue;
        }
        foreach ($this->childNodes as $cn) {
            $x['childs'][] = $cn->debug();
        }
        return $x;
    }

    /**
     * returns an array representation of node
     *
     * @return array
     */
    public function __toArray(): array
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

    /**
     * Set node parent, if node already has a parent, an error will be thrown
     *
     * @param [type] $parentNode
     * @return void
     */
    public function parent($parentNode)
    {
        if ($this->parentNode) {
            //debug_print_backtrace(2);
            throw new \Exception("Node already has a parent, detach it first");
        }
        $this->parentNode = $parentNode;
    }

    /**
     * Get indent leveled by node depth
     *
     * @return void
     */
    public function getIndent()
    {
        $level = 0;
        $c = $this;
        while ($c->parentNode) {
            $c = $c->parentNode;
            if ($c->nodeName && $c->nodeName[0] != '#') {
                $level++;
            }
        }
        //$level--;
        if ($level <= 0) {
            return PHP_EOL;
        }
        return PHP_EOL . str_repeat('  ', $level);
    }

    /**
     * Determine if is self closing tag
     *
     * @return boolean
     */
    public function isSelfClosingTag(): bool
    {
        return in_array($this->nodeName, $this->selfClosingTags);
    }

    /**
     * Change node name and value
     *
     * @param string $nodeName
     * @param string $nodeValue
     * @return void
     */
    public function changeNode(string $nodeName, string $nodeValue = '')
    {
        $this->nodeName = $nodeName;
        $this->nodeValue = $nodeValue;
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
        echo ((string) $this);
        echo '</pre>';
        echo PHP_EOL;
    }

    public function dd()
    {
        $this->d();
        die();
    }

    // =================================================== //
    // ===================== GETTERS ===================== //
    // =================================================== //
    public function __get($prop)
    {
        if (method_exists($this, 'get' . ucfirst($prop))) {
            return $this->{'get' . ucfirst($prop)}();
        }
        return $this->{$prop};
    }

    public function getSrcFile()
    {
        $root = $this;
        while (!$root->srcFile && $root->nodeName != '#root') {
            $root = $this->parentNode;
        }
        return $root->srcFile;
    }

    public function getNodeName()
    {
        return $this->nodeName;
    }

    public function getParentNode()
    {
        return $this->parentNode;
    }

    public function getAttributes(): DomNodeAttrList
    {
        return new DomNodeAttrList($this->attrs);
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
}
