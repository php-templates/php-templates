<?php

namespace PhpTemplates\Dom\PhpNodes;

use PhpTemplates\Dom\DomNode;

class SlotAssign extends DomNode
{
    private $targetComp;
    private $slotPos;

    public function __construct(string $targetComp, string $slotPos)
    {
        parent::__construct('#php-slot-assign');

        $this->targetComp = $targetComp;
        $this->slotPos = $slotPos;
        
        $this->appendChild(new DomNode('#php', '<?php $context = $context->subcontext(["slot" => new Context(func_get_arg(0))]); ?>'));
    }

    public function __toString()
    {
        // NODE START
        $indentNL = $this->getIndent();
        $return = $indentNL;
        
        $return .= sprintf('<?php $this->comp["%s"]->addSlot("%s", function(array $data = []) use ($context) { ?>' . PHP_EOL, 
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