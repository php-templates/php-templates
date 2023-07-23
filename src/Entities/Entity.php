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
use PhpTemplates\Parsed\TemplateFile;
use PhpDom\Contracts\TextNodeInterface;

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
    
    protected TemplateFile $document;

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
                        $directive($node, (string)$a->getValue());

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

        if ($node instanceof TextNodeInterface) {
            return new TextNodeEntity($node, $this);
        }
        
        if ($node->getNodeName() == 'slot') {
            return new SlotEntity($node, $this);
        }
        
        if ($node->hasAttribute('verbatim')) {
            return new VerbatimEntity($node, $this);
        }
        
        if ($node->getNodeName() != 'tpl' && ($rfilepath = $config->getAliased($node->getNodeName()))) {
            $node->setNodeName('tpl');
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
            return new TemplateEntity($node, $this);
        }
        
        if ($node->getNodeName() == 'tpl' && $node->hasAttribute('extends')) {
            $rfilepath = $node->getAttribute('extends');
            if ($rfilepath[0] == '@') {
                $rfilepath = $config->getName() . ':' . ltrim($rfilepath, '@');
                $node->setAttribute('extends', $rfilepath);
            }       
            return new ExtendEntity($node, $this);
        }

        if ($node->getNodeName() == 'tpl') {
            return new AnonymousEntity($node, $this);
        }

        return new SimpleNodeEntity($node, $this);        
    }

    /**
     * Call recursive parse process giving context = this
     */
    public function parse()
    {
        foreach ($this->node->getChildNodes() as $cn) {
            $this->child($cn)->startupContext();
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
    
    public function getDocument(): TemplateFile
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

