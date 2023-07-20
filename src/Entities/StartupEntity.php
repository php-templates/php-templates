<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Event;
use PhpTemplates\ParsingTemplate;
use PhpTemplates\Parsed\TemplateFile;
use PhpDom\Contracts\DomElementInterface as DomElement;
use PhpDom\DomNode;
use PhpTemplates\Contracts\Entity as EntityInterface;

class StartupEntity implements EntityInterface
{
    private TemplateFile $document;
    private Config $config;
    private ParsingTemplate $template;
    
    public function __construct(ParsingTemplate $template, TemplateFile $document)
    {
        $this->document = $document;
        $this->config = $template->getConfig();
        $this->template = $template;
    }
    
    public function getConfig(): Config
    {
        return $this->config;
    }
    
    public function getDocument(): TemplateFile
    {
        return $this->document;
    }
    
    public function startupContext() {}
    
    /**
     * Call recursive parse process giving context = this
     */
    public function parse()// todo add in interface
    {
        $name = $this->template->getName();
        $classDefinition = $this->template->getClassDefinition();
        $obj = $this->template->getObject();
        $node = $this->template->getDomNode();
        $wrapper = new DomNode('');
        $wrapper->appendChild($node);
        
        Event::trigger('parsing', $name, $node, $classDefinition);
        method_exists($obj, 'parsing') && $obj->parsing($node, $classDefinition);
         
        (new SimpleNodeEntity($wrapper, $this))->startupContext();
        
        // build template function only when all templates are parsed, that because we want to let conponents to register dependencies like scripts to html main
        $this->document->add($name, function() use ($name, $wrapper, $classDefinition, $obj)
        {
            Event::trigger('parsed', $name, $wrapper, $classDefinition);
            method_exists($obj, 'parsed') && $obj->parsed($wrapper, $classDefinition);
            
            $classDefinition->addMethod('template', (string)$wrapper);
            $classDefinition->addProp('__name', $name, 3);
            $classDefinition->addProp('__config', $this->template->getConfig()->getName(), 3);
            
            return $this->template;
        });        
    }
}