<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNodeAttr;

abstract class AbstractAttributeGroup
{
    const WEIGHT = 0;

    protected $attrs = [];

    public static function test(DomNodeAttr $attr): bool
    {
        return true;
    }

    public function add(DomNodeAttr $attr)
    {
        $this->attrs[] = $attr;
    }

    /**
     * case <div p-bind="['foo' => 'bar']"
     *
     * @return string
     */
    abstract public function bindArrayToNode(): string;

    /**
     * case <div :class="$foo",
     *
     * @return string
     */
    abstract public function bindToNodeAttr(): string;

    /**
     * case <tpl is="x" p-bind="['foo' => 'bar']"
     *
     * @return string
     */
    abstract public function bindArrayToTemplate(): string;

    /**
     * case <tpl is="x" p-bind="$var",
     *
     * @return string
     */
    abstract public function bindToTemplateAttr(): string;
}
