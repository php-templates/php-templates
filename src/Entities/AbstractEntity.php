<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Process;
use PhpTemplates\Attributes\AttributePack;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\NodeParser;
use PhpTemplates\Registry;

abstract class AbstractEntity 
{
    /**
     * class used to instantiate entities in nodes recursion
     *
     * @var NodeParser
     */
    protected $factory;

    /**
     * Parse process
     *
     * @var Registry
     */
    protected $registry;

    /**
     * The pack of events to each template action
     *
     * @var EventHolder
     */
    protected $eventHolder;

    /**
     * Unique id -> used to parent-child comunication like: this->comp[id]->addSlot(...)
     *
     * @var string
     */
    protected $id;

    /**
     * Recursive parent context
     *
     * @var AbstractEntity $context
     */
    protected $context;

    /**
     * Current inparse DomNode
     *
     * @var DomNode $node
     */
    protected $node;

    /**
     * Found attributes on current node
     *
     * @var array $attrs
     */
    protected $attrs = [];

    /**
     * prefix for special php blocks (p-if, p-for)
     *
     * @var string
     */
    protected $pf = 'p-';

    /**
     * Creating a new instance by giving the main process as param, the node and the contex
     */
    public function __construct(Registry $registry, DomNode $node, AbstractEntity $context)
    {
        $this->registry = $registry;
        $this->node = $node;
        $this->context = $context;
        $this->id = uniqid();
    }

    abstract public function templateContext();
    abstract public function slotContext();
    abstract public function simpleNodeContext();
    abstract public function anonymousContext();
    abstract public function extendContext();
    abstract public function textNodeContext();
    abstract public function verbatimContext();


    /**
     * Wrap node inside control structures and returns the aggregated node datas as array (like :class and class under 1 single key named :class)
     *
     * @param DomNode $node
     * @return AttributePack
     */
    protected function depleteNode(DomNode $node): AttributePack
    {
        $config = $this->getConfig();
        $attributePack = new AttributePack($this->getConfig());
        // dispatch any existing directive
        while ($node->attributes->count()) {
            $attrs = $node->attributes;
            $node->removeAttributes();

            foreach ($attrs as $a) {
                $k = $a->nodeName;
                if (array_key_exists($k, $this->attrs)) {
                    $this->attrs[$k] = $a->nodeValue;
                    continue;
                }

                if (strpos($k, $this->pf) === 0) {
                    // check if is a directive and unpack its result as attributes
                    if ($directive = $config->getDirective(substr($k, strlen($this->pf)))) {
                        $directive($node, $a->nodeValue);

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
     * Call recursive parse process
     */
    public function parse()
    {
        if ($this->context) {
            $fn = explode('\\', get_class($this->context));
            $fn = end($fn);
            $fn = str_replace('Entity', 'Context', lcfirst($fn));
        } else {
            $fn = 'simpleNodeContext';
        }

        return $this->{$fn}();
    }

    // =================================================== //
    // ===================== GETTERS ===================== //
    // =================================================== //

    public function __get($prop) {
        return $this->registry->$prop;
    }

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

    protected function parseTemplate($name) 
    {
        $template = $this->finder->find($name); // name, file, config
        $template += $this->loader->load($template['file'], $template['name']); // returns new class and new TemplateClassBuilder
   
        //$node = $registry->dom->parse(new Source($template['code'], $template['file']));
        $tpl = $this->parser->parse($template, $template['config']); // returns a string which will compose the render 
        $template['class']->addMethod('render', $tpl);
       
        $this->cache->add($template);
        
        return $template;
    }

    public function getConfig(): Config
    {
        // up to startupentity
        return $this->context->getConfig();
    }
    //legacy
    public static function mgake(DomNode $node, AbstractEntity $context, Process $process)
    {
        if ($node->nodeName == '#text') {
            return new TextNodeEntity($node, $context, $process);
        }
        
        if ($node->nodeName == 'slot') {
            return new SlotEntity($node, $context, $process);
        }
        
        if ($node->hasAttribute('verbatim')) {
            return new VerbatimEntity($node, $context, $process);
        }
        
        if ($node->nodeName != 'tpl' && ($rfilepath = $process->config->getAliased($node->nodeName))) {
            $node->changeNode('tpl');
            if ($rfilepath[0] == '@') {
                $rfilepath = $process->config->getName() . ':' . ltrim($rfilepath, '@');
            }
            $node->setAttribute('is', $rfilepath);
        }
        
        if ($node->nodeName == 'tpl' && $node->hasAttribute('is')) {
            $rfilepath = $node->getAttribute('is');
            if ($rfilepath[0] == '@') {
                $rfilepath = $process->config->getName() . ':' . ltrim($rfilepath, '@');
                $node->setAttribute('is', $rfilepath);
            }            
            return new TemplateEntity($node, $context, $process);
        }
        
        if ($node->nodeName == 'tpl' && $node->hasAttribute('extends')) {
            $rfilepath = $node->getAttribute('extends');
            if ($rfilepath[0] == '@') {
                $rfilepath = $process->config->getName() . ':' . ltrim($rfilepath, '@');
                $node->setAttribute('extends', $rfilepath);
            }       
            return new ExtendEntity($node, $context, $process);
        }

        if ($node->nodeName == 'tpl') {
            return new AnonymousEntity($node, $context, $process);
        }

        return new SimpleNodeEntity($node, $context, $process);
    }
}

