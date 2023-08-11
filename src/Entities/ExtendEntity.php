<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\Registry;
use PhpTemplates\Contracts\Entity as EntityInterface;
use PhpDom\Contracts\DomElementInterface as DomElement;

class ExtendEntity extends TemplateEntity
{
    protected string $className;

    protected array $attrs = [
        'is' => null,
        'extends' => null,
    ];

    public function __construct(DomElement $node, EntityInterface $context)
    {
        $name = $node->getAttribute('extends');
        $node->removeAttribute('extends');
        $node->setAttribute('is', $name);
        
        parent::__construct($node, $context);
    }

    /**
     * <div><tpl extends="comp/x"></tpl></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString(); // -> can t bind explicit data to extends, because it shares same context,…  use tpl instead…  so what… 

        $this->node->setNodeName('');
        $slots = $this->getValidSlots($this->node);
        $this->node->appendChild(new PhpNode(sprintf(
            '$this->comp["%s"] = $this->make("%s", %s)->setScope($this->scope->merge('.$dataString.'))',
            $this->id, $this->name, $dataString)));
            
        foreach ($slots as $slot) {
            $this->node->appendChild($slot);
            $this->child($slot)->templateContext();            
        }

        $nodeValue = sprintf('$this->comp["%s"]->render()', $this->id);
        $this->node->appendChild(new PhpNode($nodeValue));
    }
}
