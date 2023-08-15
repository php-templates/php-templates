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

class TemplateEntity extends Entity
{
    protected string $name;
    protected array $attrs = [
        'is' => null,
    ];

    public function __construct(DomElement $node, EntityInterface $context)
    {
        parent::__construct($node, $context);
        
        $name = $node->getAttribute('is');
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
    
    public function startupContext() {
        $this->simpleNodeContext();
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
            '$this->comp["%s"] = $this->make("%s", %s)',
            $this->id, $this->name, $dataString)));

        foreach ($slots as $slot) {
            $this->node->appendChild($slot);
            $this->child($slot)->templateContext();            
        }

        $nodeValue = sprintf('$this->comp["%s"]->render()', $this->id);
        $this->node->appendChild(new PhpNode($nodeValue));
    }

    /**
     * <slot><tpl is="comp/x"></tpl></slot>
     */
    public function slotContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * <tpl><tpl is="comp/x"></tpl></tpl>
     */
    public function anonymousContext()
    {
        $this->simpleNodeContext();
    }
    
    private function resolve() 
    {
        try {
            $template = new ParsingTemplate($this->name, null, null, $this->config);
        } catch (TemplateNotFoundException $e) {
            throw new InvalidNodeException($e->getMessage(), $this->node);
        }
        
        (new StartupEntity($template, $this->document))->parse();
    }

    /**
     * Returns an associative array containing assigned component slots grouped under their positions
     */
    protected function getValidSlots(DomElement $node): array
    {
        $slots = [];
        $orphanNodes = []; // gonna be slot defaults
        $defaultScopeData = null;
        
        foreach ($node->getChildNodes() as $cn) {
            $pos = null;
            $scopeData = null;
            
            if ($cn instanceof \PhpDom\Contracts\DomNodeInterface) {
                if ($cn->hasAttribute('slot')) 
                {
                    $pos = trim($cn->getAttribute('slot'));
                    $cn->removeAttribute('slot');
                    
                    if (!$pos) {
                        throw new InvalidNodeException('No slot position given', $cn);
                    }
                    
                    $scopeData = $this->getScopeData($cn);
                    
                    if (isset($slots[$pos])) {
                        throw new InvalidNodeException("Duplicate slot assignment for slot '$pos'", $cn);
                    }
                    
                    $slots[$pos] = new SlotAssign($this->id, $pos, $scopeData);
                    $slots[$pos]->appendChild($cn->detach());
                } else {
                    $orphanNodes[] = $cn;
                    $defaultScopeData = $this->getScopeData($cn);                 
                }
            } else {
                $orphanNodes[] = $cn;
            }
        }
        
        if ($defaultScopeData && count($orphanNodes) > 1) {
            throw new InvalidNodeException('When using p-scope, passed default slots must be wrapped under a single node', $node);
        }
        
        if ($orphanNodes && $slots) {
            throw new InvalidNodeException('When multiple slots are assigned, slot-default must be wrapped under a separate node with position specified as attribute', $node);
        }
        
        if ($orphanNodes) {
            $slots['default'] = new SlotAssign($this->id, 'default', $defaultScopeData);
        }
        // add orphan nodes to slot default
        foreach ($orphanNodes as $cn) {
            $slots['default']->appendChild($cn->detach());
        }

        // support <tpl is=""><slot></slot></tpl> with default in background
        foreach ($slots as &$slot) {
            $firstChild = $slot->getChildNodes()->first();
            $bool = $firstChild instanceof \PhpDom\Contracts\DomNodeInterface;
            $bool = $bool && $slot->getChildNodes()->count() == 1;
            $bool = $bool && $firstChild->getNodeName() == 'slot';
            if ($bool && $firstChild->getChildNodes()->count() == 0) {
                $pos = trim($firstChild->getAttribute('name') ?? 'default');
                $slot->setAttribute('p-if', "\$this->slots('{$pos}')");
            }
            elseif ($bool && $firstChild->hasAttribute('p-if')) {
                $slot->setAttribute('p-if', $firstChild->getAttribute('p-if'));
                $firstChild->removeAttribute('p-if');
            }
        }
        
        return $slots;
    }
    
    private function getScopeData($node) 
    {
        $defaultScopeData = null;
        if ($defaultScopeData = $node->getAttribute('p-scope')) {
            try { enscope_variables($defaultScopeData); } 
            catch (\Throwable $e) {
                throw new InvalidNodeException($e->getRawMessage(), $node);
            }
        }
        $node->removeAttribute('p-scope');
        
        return $defaultScopeData;
    }
}
