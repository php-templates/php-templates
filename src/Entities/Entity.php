<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Parser;
use PhpTemplates\Config;
use PhpTemplates\Process;
use PhpTemplates\Dom\AttributePack;
use PhpDom\DomNode;
use PhpDom\Contracts\DomNodeInterface;
use PhpDom\Contracts\DomElementInterface as DomElement;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\NodeParser;
use PhpTemplates\Registry;

/**
 * Startup entity
 */
class Entity 
{
    /**
     * Unique id -> used to parent-child comunication like: this->comp[id]->addSlot(...)
     */
    protected string $id;

    /**
     * Recursive parent context
     */
    protected ?Entity $context;

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

    /**
     * prefix for special php blocks (p-if, p-for)
     */
    protected string $pf = 'p-';

    /**
     * Creating a new instance by giving the main process as param, the node and the contex
     */
    public function __construct(Parser $parser, ?DomElement $node, ?Entity $context = null, Config $config = null)
    {
        $this->id = uniqid();
        $this->parser = $parser;
        $this->node = $node;
        $this->context = $context;
        if ($config) {
            $this->config = $config;
        }
        elseif ($context && !$config) {
            $this->config = $context->getConfig();
        }
        else {
            throw new \Exception('Context or config must be given');
        }
    }

    /**
     * Wrap node inside control structures and returns the aggregated node datas as array (like :class and class under 1 single key named :class)
     */
    protected function depleteNode(DomElement $node): AttributePack
    {
        $config = $this->getConfig();
        $attributePack = new AttributePack($this->getConfig());
        // dispatch any existing directive
        while ($attrs = $node->getAttributes()) 
        {
            $node->removeAttribute('*');

            foreach ($attrs as $a) {
                $k = $a->getName();
                if (array_key_exists($k, $this->attrs)) {
                    $this->attrs[$k] = $a->getValue();
                    continue;
                }

                if (strpos($k, $this->pf) === 0) {
                    // check if is a directive and unpack its result as attributes
                    if ($directive = $config->getDirective(substr($k, strlen($this->pf)))) {
                        $directive($node, $a->getValue());

                        // directive unpacked his data, next attr!!!
                        continue;
                    }
                }

                $attributePack->add($a);
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

        if ($node->getNodeName() == '#text') {
            return new TextNodeEntity($this->parser, $node, $this);
        }
        
        if ($node->getNodeName() == 'slot') {
            return new SlotEntity($this->parser, $node, $this);
        }
        
        if ($node->hasAttribute('verbatim')) {
            return new VerbatimEntity($this->parser, $node, $this);
        }
        
        if ($node->getNodeName() != 'tpl' && ($rfilepath = $config->getAliased($node->getNodeName()))) {
            $node->changeNode('tpl');
            if ($rfilepath[0] == '@') {
                $rfilepath = $config->getName() . ':' . ltrim($rfilepath, '@');
            }
            $node->setAttribute('is', $rfilepath);
        }
        
        if ($node->getNodeName() == 'tpl' && $node->hasAttribute('is')) {
            $rfilepath = $node->getAttribute('is');
            if ($rfilepath[0] == '@') {
                $rfilepath = $config->getName() . ':' . ltrim($rfilepath, '@');
                $node->setAttribute('is', $rfilepath);
            }            
            return new TemplateEntity($this->parser, $node, $this);
        }
        
        if ($node->getNodeName() == 'tpl' && $node->hasAttribute('extends')) {
            $rfilepath = $node->getAttribute('extends');
            if ($rfilepath[0] == '@') {
                $rfilepath = $config->getName() . ':' . ltrim($rfilepath, '@');
                $node->setAttribute('extends', $rfilepath);
            }       
            return new ExtendEntity($this->parser, $node, $this);
        }

        if ($node->getNodeName() == 'tpl') {
            return new AnonymousEntity($this->parser, $node, $this);
        }

        return new SimpleNodeEntity($this->parser, $node, $this);        
    }

    /**
     * Call recursive parse process giving context = this
     */
    public function parse()
    {
        if ($this->context) {
            $fn = explode('\\', get_class($this->context));
            $fn = end($fn);
            if ($fn == 'Entity') {
                $fn = 'startupContext';
            } else {
                $fn = str_replace('Entity', 'Context', lcfirst($fn));
            }
        } else {
            $fn = 'simpleNodeContext';
        }

        return $this->{$fn}();
    }

    // =================================================== //
    // ===================== GETTERS ===================== //
    // =================================================== //

    public function getId(): string
    {
        return $this->id;
    }

    public function getAttrs(): array
    {
        return $this->attrs;
    }

    public function getAttr(string $key)
    {
        return $this->attrs[$key] ?? null;
    }

    public function getConfig(): Config
    {
        // up to startupEntity
        if (! $this->context) {
            return $this->config;
        }
        
        return $this->context->getConfig();
    }
    
    /**
     * TO BE FILLED
     */
    public function templateContext()
    {
    }
    public function slotContext()
    {
    }
    public function simpleNodeContext()
    {
    }
    public function anonymousContext()
    {
    }
    public function verbatimContext()
    {
    }
    public function textNodeContext()
    {
    }
    public function extendContext()
    {
    }
    
    // =================================================== //
    // ===================== HELPERS ===================== //
    // =================================================== //
    
    protected function replaceNode(DomNodeInterface $node, DomNodeInterface $with) 
    {
        foreach ($node->getChildNodes() as $cn) {
            $with->appendChild($cn);
        }
        
        $with->insertBefore($node);
        $node->detach();
        
        return $with;
    }
}

