<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Parser;
use PhpTemplates\Config;
use PhpTemplates\Process;
use PhpTemplates\Dom\AttributePack;
use PhpDom\DomNode;
use PhpDom\Contracts\DomNodeInterface;
use PhpDom\Contracts\DomElementInterface as DomElement;
use PhpTemplates\Contracts\Entity as EntityInterface;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\NodeParser;
use PhpTemplates\Registry;
use PhpTemplates\Dom\PhpRefNode;
use PhpTemplates\Dom\ProxyNode;
use PhpTemplates\Document;
use PhpDom\Contracts\TextNodeInterface;
use PhpTemplates\Exceptions\InvalidNodeException;
use function PhpTemplates\enscope_variables;

/**
 * Startup entity
 */
abstract class Entity implements EntityInterface
{
    /**
     * Unique id -> used to parent-child comunication like: this->comp[id]->addSlot(...)
     */
    protected string $id;

    /**
     * Recursive parent context
     */
    protected EntityInterface $context;

    /**
     * Current inparse DomNode
     */
    protected ?DomElement $node;
    
    /**
     * Current inparse Config used
     */
    protected Config $config;

    /**
     * Found attributes on current node
     */
    protected array $attrs = [];
    
    protected Document $document;

    /**
     * prefix for special php blocks (p-if, p-for)
     */
    protected string $pf = 'p-';

    /**
     * Creating a new instance by giving the main process as param, the node and the contex
     */
    public function __construct(?DomElement $node, EntityInterface $context)
    {
        $this->id = uniqid();
        $this->node = $node;
        $this->context = $context;
        $this->config = $context->getConfig();
        $this->document = $context->getDocument();
    }

    /**
     * Wrap node inside control structures and returns the aggregated node datas as array (like :class and class under 1 single key named :class)
     */
    protected function depleteNode(DomElement $node): AttributePack
    {
        $config = $this->config;
        $attributePack = new AttributePack($this->getConfig());
        
        // dispatch any existing directive
        while ($attrs = $node->getAttributes())
        {
            foreach ($attrs as $a) {
                $k = $a->getName();
                if (array_key_exists($k, $this->attrs)) {
                    $this->attrs[$k] = trim($a->getValue());
                    continue;
                }

                if (strpos($k, $this->pf) === 0) {
                    // check if is a directive and unpack its result as attributes
                    if ($directive = $config->getDirective(substr($k, strlen($this->pf)))) 
                    {
                        // we send a node with limited access around it because parent nodes are already processed in this step and changing them would make possible problems
                        // $proxyNode = new ProxyNode($node); todo
                        $directive($node, (string)$a->getValue());
                        // directive unpacked his data, next attr!!!
                        continue;
                    }
                }

                $attributePack->add($a);
            }
            
            // keep in mind that directives may insert other directives too
            // so we want to remove only current nest level attributes and further parse these directives
            foreach ($attrs as $a) {
                $node->removeAttribute($a);
            }
        }

        return $attributePack;
    }
    
    /**
     * Called recursively from each context function
     */
    public function child(DomElement $node): Entity
    {
        $config = $this->config;

        if ($node instanceof TextNodeInterface) {
            return new TextNodeEntity($node, $this);
        }
        
        if ($node->getNodeName() == 'slot') {
            if ($node->hasAttribute('name') && !trim($node->getAttribute('name'))) {
                throw new InvalidNodeException('No slot name given', $node);
            }
            return new SlotEntity($node, $this);
        }
        
        if ($node->hasAttribute('verbatim')) {
            return new VerbatimEntity($node, $this);
        }
        
        // normalize aliased names
        if ($node->getNodeName() != 'tpl' && ($rfilepath = $config->getAliased($node->getNodeName()))) {
            $node->setNodeName('tpl');
            $node->setAttribute('is', $rfilepath);
        }
        
        // validate component or extended
        if ($node->getNodeName() == 'tpl') {
            $this->validateTplNode($node);
        }
        else {
            $this->validateNodeAttributes($node);
        }
        
        if ($node->getNodeName() == 'tpl' && $node->hasAttribute('is')) {
            $rfilepath = trim($node->getAttribute('is'));
            if (! $rfilepath) {
                throw new InvalidNodeException("No template name given", $node);
            }            
            
            return new TemplateEntity($node, $this);
        }
        
        if ($node->getNodeName() == 'tpl' && $node->hasAttribute('extends')) {
            $rfilepath = trim($node->getAttribute('extends'));
            if (! $rfilepath) {
                throw new InvalidNodeException("No template name given", $node);
            }
            
            return new ExtendEntity($node, $this);
        }
        
        if ($node->getNodeName() == 'tpl' && $node->hasAttribute('include')) {
            $rfilepath = trim($node->getAttribute('include'));
            if (! $rfilepath) {
                throw new InvalidNodeException("No template name given", $node);
            }
            
            return new IncludeEntity($node, $this);
        }

        if ($node->getNodeName() == 'tpl') {
            return new AnonymousEntity($node, $this);
        }

        return new SimpleNodeEntity($node, $this);        
    }
    
    private function validateTplNode($node)
    {
        if ($node->hasAttribute('is') && $node->hasAttribute('extends')) {
            throw new InvalidNodeException("Cannot use 'is' and 'extends' on same node", $node);
        }
        
        $this->validateNodeAttributes($node);
    } 
    
    private function validateNodeAttributes($node) 
    {
        $duplicates = [];
        foreach ($node->getAttributes() as $attr) {
            $k = $attr->getName();
            if ($k == 'p-scope') {
                throw new InvalidNodeException('p-scope directive can be used only in component scopes context', $node);
            }
            
            if (isset($duplicates[$k]) && !in_array($k, [':class', 'p-bind', 'p-raw'])) {
                throw new InvalidNodeException("Duplicate attribute $k", $node);
            }
            $duplicates[$k] = true;
        }        
    }
    
    protected function enscopeVariables(string $str)
    {
        try {
            return enscope_variables($str);
        } catch (\Throwable $e) {
            throw new InvalidNodeException($e->getRawMessage(), $this->node);
        }
    }

    // =================================================== //
    // ===================== GETTERS ===================== //
    // =================================================== //

    public function getId(): string
    {
        return $this->id;
    }
/*
    public function getAttrs(): array
    {
        return $this->attrs;
    }

    public function getAttr(string $key)
    {
        return $this->attrs[$key] ?? null;
    }*/

    public function getConfig(): Config
    {
        return $this->config;
    }
    
    public function getDocument(): Document
    {
        return $this->document;
    }
    
    
    // =================================================== //
    // ===================== HELPERS ===================== //
    // =================================================== //
    
    public function __call($m, $args)
    {
        if (strpos($m, 'Context') && !method_exists($this, $m)) {
            $m = 'startupContext';
        }
        
        return call_user_func_array([$this, $m], $args);
    }
    
    public function startupContext() {}
}

