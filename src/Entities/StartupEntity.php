<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Event;
use PhpTemplates\ParsingTemplate;
use PhpTemplates\Document;
use PhpDom\Contracts\DomElementInterface as DomElement;
use PhpDom\DomNode;
use PhpTemplates\Contracts\Entity as EntityInterface;
use PhpTemplates\ProxyNode;

class StartupEntity implements EntityInterface
{
    private Document $document;
    private Config $config;
    private ParsingTemplate $template;
    
    public function __construct(ParsingTemplate $template, Document $document)
    {
        $this->document = $document;
        $this->config = $template->getConfig();
        $this->template = $template;
    }
    
    public function getConfig(): Config
    {
        return $this->config;
    }
    
    public function getDocument(): Document
    {
        return $this->document;
    }
    
    public function startupContext() {}
    
    /**
     * Call recursive parse process giving context = this
     */
    public function parse()
    {
        $name = $this->template->getName();
        $classDefinition = $this->template->getClassDefinition();
        $obj = $this->template->getObject();
        $node = $this->template->getDomNode();
        $wrapper = new DomNode('');
        $wrapper->appendChild($node);

        $proxyNode = new ProxyNode($node, $obj, $name);
        method_exists($obj, 'parsing') && $obj->parsing($proxyNode, $classDefinition);
        Event::trigger('parsing', $name, $proxyNode, $classDefinition);
         
        (new SimpleNodeEntity($wrapper, $this))->startupContext();
        
        // build template function only when all templates are parsed, that because we want to let conponents to register dependencies like scripts to html main
        $this->document->add($name, function() use ($name, $wrapper, $classDefinition, $obj)
        {
            $proxyNode = new ProxyNode($wrapper, $obj, $name);
            Event::trigger('parsed', $name, $proxyNode, $classDefinition);
            method_exists($obj, 'parsed') && $obj->parsed($proxyNode, $classDefinition);
            
            if (! $classDefinition->hasMethod('template')) {
                $classDefinition->addMethod('template', (string)$wrapper);
            }
            $classDefinition->addProp('__name', $name, 3);
            $classDefinition->addProp('__config', $this->template->getConfig()->getName(), 3);
            
            return $this->template;
        });        
    }
}