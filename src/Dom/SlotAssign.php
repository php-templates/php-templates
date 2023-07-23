<?php
// todo scoate use context, il am pe this context, renunta la fngetargs
namespace PhpTemplates\Dom;

use PhpDom\DomNode;
use function PhpTemplates\enscope_variables;

// todo error reserved tags
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
// todo enscope somehow scope render foreach
    public function __toString()
    {// todo handle error syntax assign
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