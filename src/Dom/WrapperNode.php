<?php

namespace PhpTemplates\Dom;

use PhpDom\Contracts\DomNodeAttrInterface;
use PhpDom\Contracts\DomNodeInterface;
use PhpDom\Traits\DomElement;
use PhpDom\Traits\QuerySelector;

/**
 * @inheritdoc
 */
class WrapperNode implements DomNodeInterface
{// todo: validari
    use DomElement;
    //use QuerySelector;

    public function __toString(): string
    {
        $return = '';
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        return $return;
    }

    public function getNodeName(): string
    {
        return '';
    }

    public function setNodeName(string $name): DomNodeInterface
    {
        return $this;
    }

    public function getAttributes(): array
    {
        return [];
    }

    public function getAttribute(string $name)
    {
        return null;
    }

    public function setAttribute($name, $value = null): DomNodeInterface
    {
        return $this;
    }


    public function hasAttribute(string $name): bool
    {
        return false;
    }

    public function removeAttribute(string $name): self
    {
        return $this;
    }
}
