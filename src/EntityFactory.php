<?php

namespace PhpTemplates;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Entities\Component;
use PhpTemplates\Entities\Slot;
use PhpTemplates\Entities\SimpleNode;
use PhpTemplates\Entities\TextNode;
use PhpTemplates\Entities\Template;
use PhpTemplates\Document;
use PhpTemplates\EventHolder;
use PhpTemplates\ConfigHolder;

//TODO: RENAME INTO NODEPARSER
class EntityFactory
{
    private $document;
    private $configHolder;
    private $eventHolder;
    
    public function __construct(Document $document, ConfigHolder $configHolder, EventHolder $eventHolder) 
    {
        $this->document = $document;
        $this->configHolder = $configHolder;
        $this->eventHolder = $eventHolder;
    }
    
    public function make(DomNode $node, ?AbstractEntity $context = null, Config $config = null) 
    {
        if (!$this->document) {
            //throw new \Exception('Set the document first by calling parse() method');
        }
        //$GLOBALS['x'] && $node->d();
        //if ($context) {

        //} else {
            //$fn = 'rootContext';
        //}
        if (!$config) {
            $config = $context->getConfig();
        }

        if ($node->nodeName === '#text') {
            $entity = new TextNode($node, $config, $context, $this->document, $this, $this->eventHolder);
        }
        elseif ($node->nodeName === 'slot') {
            $entity = new Slot($node, $config, $context, $this->document, $this, $this->eventHolder);
        }
        elseif ($entity = $this->isComponent($node, $context)) {//TODO: intotdeauna intorc cobfih:
            //$entity->resolve($this->document, $this->eventHolder);
            // component load node
            //$this->document->getInputFile() == './temp/d' && d($name);
            //$this->resolveComponent($name, $config); // if doc not having this, get it from parser instance cache, or parse it again
            //$entity = new Component($this, $config, $node, $name, $context);
            // todo: resolve component pe component entity
        }
        elseif ($node->nodeName === 'template') {
            $entity = new Template($node, $config, $context, $this->document, $this, $this->eventHolder);
        }
        else {
            $entity = new SimpleNode($node, $config, $context, $this->document, $this, $this->eventHolder);
        }
        return $entity;
    }
    
    private function isComponent(DomNode $node, ?AbstractEntity $context)
    {
        if (!$node->nodeName) {
            return null;
        }
        if ($context) {
            $config = $context->getConfig();
        } else {
            $config = $this->configHolder->get();
        }
        
        if ($node->nodeName == 'template' && $node->hasAttribute('is')) {
            $rfilepath = $node->getAttribute('is');
        } else {
            $rfilepath = $config->getAliased($node->nodeName);
        }
        //strpos($rfilepath, 'fg2-1') && dd($rfilepath);
        if (!$rfilepath) {
            return null;
        }
        
        if (strpos($rfilepath, ':')) {
            list($cfgKey, $rfilepath) = explode(':', $rfilepath);
            $config = $this->configHolder->get($cfgKey);
        }
        
        if (!$config->isDefault()) {
            $rfilepath = $config->getName() . ':' . $rfilepath;
        }
        $node->changeNode('template');
        $node->setAttribute('is', $rfilepath);
        
        return new Component($node, $config, $context, $this->document, $this, $this->eventHolder);
    }
}