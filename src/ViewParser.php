<?php

namespace PhpTemplates;

class ViewParser
{
    private $entityFactory;
    
    public function __construct(EntityFactory $entityFactory) 
    {
        $this->entityFactory = $entityFactory;
    }
    
    public function parse(Document $document): string // return result path
    {
        // enter in parsing recursion process by making an artificial component tag node
        //$node = new DomNode('template', ['is' => $document->getName()]);
        node = $this->document->load(x); // will register dependencies
        this document register(node, name, config to be passed further) aka new root
        //$entity = $this->entityFactory->make($node, $name = '', $context = null);
        
        
        $config = $this->configHolder->getConfig();
        (new Component($document, $node, $config, $this->eventHolder))->rootContext();
        //$document->setContent($process->getResult());
        $path = $document->save();
    }
}