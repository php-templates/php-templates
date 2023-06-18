<?php
// todo scoate context din param fn, il fac bind pe this
namespace PhpTemplates\Dom;

use PhpDom\DomNode;

class PhpNode extends DomNode
{
    protected string $expression;
    protected string $args;
    
    public function __construct(string $expression, string $args = '') 
    {
        parent::__construct($expression);
        $this->expression = $expression;
        $this->args = $args;
    }
    
    public function __toString()
    {
        if (in_array($this->expression, ['foreach'])) {
            return $this->toScopedLoop();
        }
        
        // NODE START
        $return = '';

        if ($this->expression && ($this->args || $this->args == '0')) {
            $expr = "{$this->expression} ({$this->args}) {";
        } elseif ($this->expression) { // case Else
            $expr = $this->expression . ' {';
        } else {
            $expr = $this->args . ';';
        }
        $return .= '<?php ' . $expr . ' ?>';

        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        // NODE END
        if ($this->expression) {
            $return .= '<?php } ?>';
        }

        return $return;
    }

    public function getNodeName(): string
    {
        return '<?php';
    }
    
    private function toScopedLoop()
    {
        // NODE START
        $return = '';
        
        $tmp = explode('as', $this->args);
        $subject = trim($tmp[0]);
        $tmp = explode('=>', $tmp[1]);
        if (isset($tmp[1])) {
            $key = "'" . trim($tmp[0], ' $') . "'";
            $value = "'" . trim($tmp[1], ' $') . "'";
        }
        else {
            $value = "'" . trim($tmp[0], ' $') . "'";
            $key = 'null';
        }

        $return .= "<?php (new Loop(\$this, $subject, $value, $key))->run(function() { ?>";

        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        // NODE END
        $return .= "<?php }); ?>";
        
        return $return;
    }
}
