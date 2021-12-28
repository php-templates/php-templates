<?php

namespace DomDocument\PhpTemplates\Entities;

use IvoPetkov\HTML5DOMElement;

interface Mountable 
{
    public function mount(HTML5DOMElement $node): void;
}