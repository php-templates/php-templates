<?php

namespace PhpTemplates;

use PhpTemplates\Contracts\EventDispatcher;
use PhpTemplates\Contracts\Cache;
use PhpTemplates\Dom\WrapperNode;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Entities\SimpleNodeEntity;
use PhpTemplates\Entities\SlotEntity;
use PhpTemplates\Entities\TextNodeEntity;
use PhpTemplates\Entities\TemplateEntity;
use PhpTemplates\Entities\AnonymousEntity;
use PhpTemplates\Entities\Entity;
use PhpTemplates\Entities\ExtendEntity;
use PhpTemplates\Entities\VerbatimEntity;
use PhpTemplates\Entities\StartupEntity;
use PhpDom\DomNode;

class Parser
{
    private EventDispatcher $event;
    private $parsed = [];

    public function __construct(EventDispatcher $event) 
    {        
        $this->event = $event;
    }
    
    /**
     * Pass parser in each entity, at the end gather an array of every parsed templates assigned to cache object
     */
    public function parse(ParsingTemplate $template)
    {
        if ( isset($this->parsed[$template->getName()]) ) {
            return $this->parsed;
        }
       
        $node = $template->getDomNode();
        $config = $template->getConfig();
        $obj = $template->getObject();
        $classDefinition = (new PhpParser())->parse($template);
        
        // wrap node in case anyone wants to wrap node with another node using events
        $wrapper = new WrapperNode();
        $wrapper->appendChild($node);
        $this->event->trigger('parsing', $template->getName(), $wrapper, $classDefinition);
        method_exists($obj, 'parsing') && $obj->parsing($wrapper);
        $entity = new Entity($wrapper, new StartupEntity($this, $config));
        $entity->parse();
        $this->event->trigger('parsed', $template->getName(), $wrapper, $classDefinition);
        method_exists($obj, 'parsed') && $obj->parsed($wrapper);
    
        # add render function
        $classDefinition->addMethod('template', (string)$wrapper);
        $classDefinition->addProp('__name', $template->getName(), 3);
        $classDefinition->addProp('__config', $template->getConfig()->getName(), 3);

        # build a nested object to be passed to cache writer
        $this->parsed[$template->getName()] = new ParsedTemplate($template->getFile(), $template->getName(), $template->getConfig(), $classDefinition);
        
        return $this->parsed;
    }
}