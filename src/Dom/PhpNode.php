<?php
// todo scoate context din param fn, il fac bind pe this
namespace PhpTemplates\Dom;

use PhpDom\DomNode;
use function PhpTemplates\enscope_variables;

class PhpNode extends DomNode
{
    protected string $expression;
    protected string $args;
    
    public function __construct(string $args = '', string $expression = '') 
    {
        parent::__construct('');
        $this->expression = trim(strtolower($expression));
        $this->args = $args;
    }
    
    public function __toString()
    {
        // NODE START
        $return = '';
        if ($isLoop = in_array($this->expression, ['foreach', 'for', 'while'])) {
            $return .= "<?php \$this->__loopStart(); ?>\n";
        }

        // wrap in if statement to not throw error
        $args = $this->args;
        if ($this->expression && ($args || $args == '0')) {
            $norm = $this->expression == 'elseif' ? 'if' : $this->expression;
            $expr = enscope_variables("{$norm} ({$args}) {}");
            $expr = preg_replace("/^{$norm} *\(/", $this->expression . ' (', $expr);
            $expr = preg_replace('/\{[\s\t\r\n]*\}/', "{", $expr);
        } elseif ($this->expression) { // case Else
            $expr = $this->expression . " {";
        } else {
            $expr = rtrim(enscope_variables($args . ';'), ';') . ';';
        }

        $return .= "<?php " . $expr . " ?>\n";

        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        // NODE END
        if ($this->expression) {
            $return .= "\n<?php } ?>\n";
        }
        
        if ($isLoop) {
            $return .= "<?php \$this->__loopEnd(); ?>\n";
        }

        return $return;
    }

    public function getNodeName(): string
    {
        return '<?php ' . $this->expression;
    }
}
