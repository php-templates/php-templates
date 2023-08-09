<?php

namespace PhpTemplates\Contracts;

use PhpTemplates\TemplateClassDefinition;
use PhpDom\Contracts\DomElementInterface as DomElement;

interface EventDispatcher
{
    /**
     * Trigger Event
     *
     * @param string $ev - parsing, parsed or rendering
     * @param string $name - template name
     * @param DomNode $template - template instance
     * @return void
     */
    public function trigger(string $ev, string $name, DomElement $node, TemplateClassDefinition $classDefinition);
        
    /**
     * Add event listener to given process
     *
     * @param string $ev - parsing, parsed or rendering
     * @param string $name - template name
     * @param callable $cb - listener / event callback
     * @param integer $weight - weighter callbacks are executed first
     * @return void
     */
    public function on(string $ev, $name, callable $cb, $weight = 0);
    // todo comments
    public function parsing($name, callable $cb, $weight = 0);
    public function parsed($name, callable $cb, $weight = 0);
    public function rendering($name, callable $cb, $weight = 0);
}