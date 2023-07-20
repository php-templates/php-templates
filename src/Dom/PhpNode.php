<?php
// todo scoate context din param fn, il fac bind pe this
namespace PhpTemplates\Dom;

use PhpDom\DomNode;
use function PhpTemplates\enscope_variables;

class PhpNode extends DomNode
{
    protected string $expression;
    protected string $args;
    
    public function __construct(string $expression, string $args = '') 
    {
        parent::__construct('');
        $this->expression = strtolower($expression);
        $this->args = $args;
    }
    
    public function __toString()
    {
        // NODE START
        $return = '';
        if ($isLoop = in_array($this->expression, ['foreach', 'for', 'while'])) {
            $return .= "<?php \$this->__loopStart(); ?>\n";
            // return $this->toScopedLoop();
        }
        // wrap in if statement to not throw error
        $args = $this->args;
        if ($isLoop) {}
        elseif ($this->args || $this->args == '0') {
            $args = enscope_variables('if ('. $this->args .') {}');
            $args = substr(substr($args, 4), 0, -5);
        }

        if ($this->expression && ($args || $args == '0')) {
            $expr = "{$this->expression} ({$args}) {";
        } elseif ($this->expression) { // case Else
            $expr = $this->expression . ' {';
        } else {
            $expr = $args . ';';
        }
       
        if ($isLoop) {
            $expr = rtrim(enscope_variables($expr . '}'), '}');
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
        
        if ($isLoop) {
            $return .= "<?php \$this->__loopEnd(); ?>\n";
        }

        return $return;
    }

    public function getNodeName(): string
    {
        return '<?php ' . $this->expression;
    }
    
    private function toScopedLoop()
    {// todo: oare mai am nevoie de loop class
        // NODE START
        $return = '';
        
        $tmp = explode('as', $this->args);
        $subject = enscope_variables(trim($tmp[0]));
        $tmp = explode('=>', $tmp[1]);
        if (isset($tmp[1])) {
            $key = "'" . trim($tmp[0], ' $') . "'";
            $value = "'" . trim($tmp[1], ' $') . "'";
        }
        else {
            $value = "'" . trim($tmp[0], ' $') . "'";
            $key = 'null';
        }

        $return .= "<?php \n (new Loop(\$this, $subject, $value, $key))->run(function() { \n ?>";

        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        // NODE END
        $return .= "<?php \n }); \n ?>";
        
        return $return;
    }
}
