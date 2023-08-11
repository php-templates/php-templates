<?php

namespace PhpTemplates\Dom;

use PhpDom\DomNode;
use PhpTemplates\Exceptions\InvalidNodeException;
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
        if ($line = $this->getLine()) {
            $return = '<?php /*line:' . $line . '*/ ?>';
        }
        
        if ($isLoop = in_array($this->expression, ['foreach', 'for', 'while'])) {
            $return .= "<?php \$this->__loopStart(); ?>\n";
        }

        // wrap in if statement to not throw error
        $args = $this->args;
        if ($this->expression && ($args || $args == '0')) {
            $norm = $this->expression == 'elseif' ? 'if' : $this->expression;
            $expr = $this->enscopeVariables("{$norm} ({$args}) {}");
            $expr = preg_replace("/^{$norm} *\(/", $this->expression . ' (', $expr);
            $expr = preg_replace('/\{[\s\t\r\n]*\}/', "{", $expr);
        } elseif ($this->expression) { // case Else
            $expr = $this->expression . " {";
        } else {
            $expr = rtrim($this->enscopeVariables($args . ';'), ';') . ';';
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
    
    public function getLine() 
    {
        $refNode = $this;
        if ($this->expression) {
            while ($refNode->getChildNodes()->first()) {
                $refNode = $refNode->getChildNodes()->first();
                if ($refNode instanceof \PhpDom\DomNode && $refNode->getLine()) {
                    $this->meta['file'] = $refNode->getFile();
                    $this->meta['line'] = $refNode->getLine();
                    return $refNode->getLine();
                }
            }
            return;
        }
        
        while ($refNode->getParentNode()) {
            $refNode = $refNode->getParentNode();
            if ($refNode instanceof \PhpDom\DomNode && $refNode->getLine()) {
                $this->meta['file'] = $refNode->getFile();
                $this->meta['line'] = $refNode->getLine();
                return $refNode->getLine();
            }
        }
    }
    
    private function enscopeVariables(string $str)
    {
        try {
            return enscope_variables($str);
        } catch (\Throwable $e) {
            throw new InvalidNodeException($e->getRawMessage(), $this);
        }
    }
}
