<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Contracts\Entity as EntityInterface;
use PhpDom\Contracts\DomElementInterface as DomElement;
use PhpTemplates\Dom\SlotAssign;
use PhpTemplates\Event;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\ParsingTemplate;
use PhpTemplates\Dom\WrapperNode;
use PhpTemplates\Exceptions\InvalidNodeException;
use PhpDom\DomNode;
use PhpTemplates\PhpParser;
use PhpTemplates\Exceptions\TemplateNotFoundException;
use function PhpTemplates\enscope_variables;

class IncludeEntity extends TemplateEntity
{
    protected string $name;
    protected array $attrs = [
        'include' => null,
    ];

    public function __construct(DomElement $node, EntityInterface $context)
    {        
        $this->id = uniqid();
        $this->node = $node;
        $this->context = $context;
        $this->config = $context->getConfig();
        $this->document = $context->getDocument();

        $name = $node->getAttribute('include');
        if (strpos($name, ':')) {
            [$cfg, $name] = explode(':', $name);
            if ($cfg != 'default') {
                $name = $cfg . ':' . $name;
            }
        } 
        elseif (! $this->config->isDefault()) {
            $name = $this->config->getName() . ':' . $name;
        }
        
        $this->name = $name;
        
        if (!$this->document->has($this->name)) {
            $this->resolve();
        }
    }
    
    /**
     * <div><tpl is="comp/x"></tpl></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $this->node->setNodeName('');
        $slots = $this->getValidSlots($this->node);
        $this->node->appendChild(new PhpNode(sprintf(
            '$this->comp["%s"] = $this->make("%s", %s)->setScope($this->scope->innerScope(%s))',
            $this->id, $this->name, $dataString, $dataString)));

        foreach ($slots as $slot) {
            $this->node->appendChild($slot);
            $this->child($slot)->templateContext();            
        }

        $nodeValue = sprintf('$this->comp["%s"]->render()', $this->id);
        $this->node->appendChild(new PhpNode($nodeValue));
    }
}
