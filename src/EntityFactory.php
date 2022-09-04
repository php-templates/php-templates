<?php

namespace PhpTemplates;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Entities\EntityInterface;
use PhpTemplates\Entities\Component;
use PhpTemplates\Entities\Slot;
use PhpTemplates\Entities\SimpleNode;
use PhpTemplates\Entities\TextNode;
use PhpTemplates\Entities\Template;
use PhpTemplates\Entities\Extend;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\ConfigHolder;

//TODO: RENAME INTO NODEPARSER
class EntityFactory
{
    private $document;
    private $configHolder;
    private $eventHolder;
    
    private $entities = [];
    
    public function __construct(CacheInterface $document, ConfigHolder $configHolder, EventHolder $eventHolder) 
    {
        $this->document = $document;
        $this->configHolder = $configHolder;
        $this->eventHolder = $eventHolder;
        
        $this->globEntities();
    }
    
    public function make(DomNode $node, EntityInterface $context) 
    {
        if (!$this->document) {
            //throw new \Exception('Set the document first by calling parse() method');
        }
        //$GLOBALS['x'] && $node->d();
        //if ($context) {

        //} else {
            //$fn = 'rootContext';
        //}
        
        foreach ($this->entities as $entity) {
            if ($entity::test($node, $context)) {
                return new $entity($node, $context->getConfig(), $context, $this->document, $this, $this->eventHolder);
            }
        }

        return;
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
        } 
        elseif ($node->nodeName == 'template' && $node->hasAttribute('extends')) {
            $rfilepath = $node->getAttribute('extends');
        }
        else {
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
        
        if ($node->hasAttribute('extends')) {
            
            return new Extend($node, $config, $context, $this->document, $this, $this->eventHolder);
        } 
        
        return new Component($node, $config, $context, $this->document, $this, $this->eventHolder);
        
    }
    
    private function globEntities() 
    {
        $files = array_filter(glob(__DIR__ . '/Entities/*'), 'is_file');
        
        $entities = [];
        foreach ($files as $file) {
            if (strpos($file, 'Abstract') || strpos($file, 'Interface') || strpos($file, 'StartupEntity')) {
                continue;
            }
            
            $entity = preg_split('/(\\/|\\\)/', $file);
            $entity = str_replace('.php', '', end($entity));
            $entity = '\\PhpTemplates\\Entities\\' . $entity;
            $entities[] = $entity;
        }
        
        usort($entities, function($b, $a) {
            return $a::WEIGHT - $b::WEIGHT;
        });
        
        $this->entities = $entities;
    }
}