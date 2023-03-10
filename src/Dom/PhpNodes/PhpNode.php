<?php
// todo scoate context din param fn, il fac bind pe this
namespace PhpTemplates\Dom\PhpNodes;

use PhpTemplates\Dom\DomNode;

class PhpNode extends DomNode
{
    public function __toString()
    {
        if (in_array($this->nodeName, ['foreach'])) {
            return $this->toScopedLoop();
        }
        
        // NODE START
        $indentNL = $this->getIndent();
        $return = $indentNL;

        if ($this->nodeName && $this->nodeName != '#text' && ($this->nodeValue || $this->nodeValue == '0')) {
            $expr = "{$this->nodeName} ({$this->nodeValue}) {";
        } elseif ($this->nodeName && $this->nodeName != '#text') { // case Else
            $expr = $this->nodeName . ' {';
        } else {
            $expr = $this->nodeValue . ';';
        }
        $return .= '<?php ' . $expr . ' ?>';

        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        // NODE END
        if ($this->nodeName && $this->nodeName != '#text') {
            $return .= $indentNL . '<?php } ?>';
        }

        return $return;
    }

    public function getNodeName()
    {
        return '#php-' . $this->nodeName;
    }
    
    private function toScopedLoop()
    {
        // NODE START
        $indentNL = $this->getIndent();
        $return = $indentNL;
        
        $tmp = explode('as', $this->nodeValue);
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
        $return .= $indentNL . "<?php }); ?>";
        
        return $return;
    }
}
