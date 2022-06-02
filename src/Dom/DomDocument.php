<?php

namespace PhpTemplates\Dom;

use voku\helper\HtmlDomParser;
use voku\helper\SimpleHtmlDomNode;
use voku\helper\SimpleHtmlDom;

class DomDocument
{
    private $dom;
    
    private $nodeName = '#document';
    private $parentNode = null;
    
    public function loadHtml(string $str)
    {
        $this->dom = HtmlDomParser::str_get_html($str);
    }
    
    /* GETTERS */
    public function __get($prop) 
    {
        if (method_exists($this, 'get'.ucfirst($prop))) {
            return $this->{'get'.ucfirst($prop)}();
        }
        return $this->{$prop};
    }
    
    public function getChildNodes()
    {
        $elements = new SimpleHtmlDomNode();
        foreach ($this->dom->getDocument()->childNodes as $node) {
            $elements[] = new SimpleHtmlDom($node);
        }
        return new DomNodeList($elements);
    }
}