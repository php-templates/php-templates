<?php

namespace PhpTemplates\Dom;

class PhpSlotAssignNode extends DomNode
{
    private $targetComp;
    private $slotPos;

    public function __construct(string $targetComp, string $slotPos, string $scopeData = null)
    {
        parent::__construct('#php-slot-assign');

        $this->targetComp = $targetComp;
        $this->slotPos = $slotPos;
        if ($scopeData) {
            $this->appendChild(new DomNode('#php', '<?php $context = $context->subcontext(["'.trim(ltrim($scopeData, '$')).'" => new Context(func_get_args()[0])]); ?>'));
        }
    }

    public function __toString()
    {
        // NODE START
        $indentNL = $this->getIndent();
        $return = $indentNL;
        
        $return .= sprintf('<?php $this->comp["%s"]->addSlot("%s", function(array $data = []) use ($context) { ?>', 
            $this->targetComp,
            $this->slotPos
        );
        
        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }
        
        // NODE END
        $return .= $indentNL . '<?php }); ?>';
        
        return $return;
    }
    
    public function getNodeName()
    {
        return '#php-'.$this->nodeName;
    }
}