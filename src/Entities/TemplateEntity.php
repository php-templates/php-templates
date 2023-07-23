<?php
// todo: this.context.root
namespace PhpTemplates\Entities;

use PhpTemplates\Contracts\Entity as EntityInterface;
use PhpDom\Contracts\DomElementInterface as DomElement;
use PhpTemplates\Dom\SlotAssign;
use PhpTemplates\Event;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\ParsingTemplate;
use PhpTemplates\Dom\WrapperNode;
use PhpTemplates\InvalidNodeException;
use PhpDom\DomNode;
use PhpTemplates\PhpParser;

// todo p-scope tag that throws an error instant ca nu il poti folosi decat pe sloturi, e procesat automat
class TemplateEntity extends Entity
{
    protected string $name;
    protected array $attrs = [
        'is' => null,
    ];

    public function __construct(DomElement $node, EntityInterface $context)
    {
        parent::__construct($node, $context);
        
        $this->name = $node->getAttribute('is');
        
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
        $this->node->appendChild(new PhpNode('', sprintf(
            '$this->comp["%s"] = $this->make("%s", %s)',
            $this->id, $this->name, $dataString)));

        foreach ($slots as $slot) {
            $this->node->appendChild($slot);
            $this->child($slot)->templateContext();            
        }

        $nodeValue = sprintf('$this->comp["%s"]->render()', $this->id);
        $this->node->appendChild(new PhpNode('', $nodeValue));
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
        $template = new ParsingTemplate($this->name, null, null, $this->config);
        
        (new StartupEntity($template, $this->document))->parse();
    }

    /**
     * Returns an associative array containing assigned component slots grouped under their positions
     */
    protected function getValidSlots(DomElement $node): array
    {
        $slots = [];
        $isDefaultSlotWrappedAndNamed = false;
        
        foreach ($node->getChildNodes() as $cn) {
            $pos = null;
            $scopeData = null;
            
            if ($cn instanceof \PhpDom\Contracts\DomNodeInterface) {
                $pos = $cn->getAttribute('slot');
                $cn->removeAttribute('slot');
                $scopeData = $cn->getAttribute('p-scope');
                $cn->removeAttribute('p-scope');
            }
            
            # next we validate for messy slots assignations, duplicates, default slot unwrapped when with named slots
            if ($pos == 'default') {
                $isDefaultSlotWrappedAndNamed = empty($slots['default']);
            }
            
            $pos = $pos ?? 'default';
            if ($pos != 'default' && isset($slots['default'])  && !$isDefaultSlotWrappedAndNamed) {
                throw new InvalidNodeException('When multiple slots are assigned, slot-default must be wrapped under a separate node with position specified as attribute', $cn); // todo test
            }
            
            if ($pos != 'default' && isset($slots[$pos])) {
                throw new InvalidNodeException("Duplicate slot assignment for slot '$pos'", $cn->getParentNode());
            }
            
            if (!isset($slots[$pos])) {
                $slots[$pos] = new SlotAssign($this->id, $pos, $scopeData);
            }
            
            $slots[$pos]->appendChild($cn->detach());
        }

        // support <tpl is=""><slot></slot></tpl> with default in background
        foreach ($slots as &$slot) {
            $firstChild = $slot->getChildNodes()->first();
            $bool = $firstChild instanceof \PhpDom\Contracts\DomNodeInterface;
            $bool = $bool && $slot->getChildNodes()->count() == 1;
            $bool = $bool && $firstChild->getNodeName() == 'slot';
            if ($bool && $firstChild->getChildNodes()->count() == 0) {
                $pos = $firstChild->getAttribute('name') ?? 'default';
                $slot->setAttribute('p-if', "\$this->slots('{$pos}')");
            }
            elseif ($bool && $firstChild->hasAttribute('p-if')) {// todo error if multiple if on node
                $slot->setAttribute('p-if', $firstChild->getAttribute('p-if'));
                $firstChild->removeAttribute('p-if');
            }
        }
        
        return $slots;
    }
}
