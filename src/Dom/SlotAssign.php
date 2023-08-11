<?php

namespace PhpTemplates\Dom;

use PhpDom\DomNode;
use function PhpTemplates\enscope_variables;

class SlotAssign extends DomNode
{
    private $targetComp;
    private $slotPos;
    
    /*
    * scope string assignation: ($var, or ['var' => $var]) will add = $data
    */
    private ?string $scopeData;

    public function __construct(string $targetComp, string $slotPos, ?string $scopeData = null)
    {
        parent::__construct('');
        $this->targetComp = $targetComp;
        $this->slotPos = $slotPos;
        $this->scopeData = $scopeData;
    }

    public function __toString()
    {
        // NODE START
        $return = sprintf('<?php $this->comp["%s"]->addSlot("%s", function($data) { ?>' . PHP_EOL, 
            $this->targetComp,
            $this->slotPos
        );
        
        if ($this->scopeData) {
            $return .= "\n<?php ". enscope_variables($this->scopeData) ." = \$data; ?>";
        }
        
        // NODE CONTENT
        foreach ($this->getChildNodes() as $cn) {
            $return .= $cn;
        }
        
        // NODE END
        $return .= "<?php }, \$this); \n ?>";
        
        return $return;
    }
}