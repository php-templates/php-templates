<?php

namespace PhpTemplates\Dom;

class DomNodeAttr
{
    public $nodeName;
    public $nodeValue;

    public function __construct(string $nodeName, string $nodeValue = '')
    {
        $this->nodeName = $nodeName;
        $this->nodeValue = $nodeValue;
    }

    public function __toString()
    {
        if (!$this->nodeName) {
            return $this->nodeValue;
        } elseif (!$this->nodeValue  && $this->nodeValue != '0') {
            return $this->nodeName;
        }

        return $this->nodeName . '="' . $this->nodeValue . '"';
    }
}
