<?php

namespace PhpTemplates\Dom;

use voku\helper\HtmlDomParser;

class DomNode
{
    private $node;
    
    public function __construct($node)
    {
        $this->node = $node;
    }
    
    /* GETTERS */
    public function __get($prop) 
    {
        if (method_exists($this, 'get'.ucfirst($prop))) {
            return $this->{'get'.ucfirst($prop)}();
        }
        return $this->{$prop};
    }
    
    public function getNodeName()
    {
        return $this->node->getNode()->nodeName;
    }
    
    public function getParentNode()
    {
        return new DomNode($this->node->parentNode());
    }
    
    public function getOwnerDocument()
    {dd($this->node->parentNode());
        if ($this->node->getNode()->ownerDocument) {
            return new DomDocument(new HtmlDomParser($this->node->getNode()->ownerDocument));
        }
        return null;
    }
}