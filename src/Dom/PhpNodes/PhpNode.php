<?php

namespace PhpTemplates\Dom\PhpNodes;

use PhpTemplates\Dom\DomNode;

class PhpNode extends DomNode
{
    public function __toString()
    {
        if ($this->nodeName == 'foreach') {
            return $this->toScopedLoop();
        }
        
        // NODE START
        $indentNL = $this->getIndent();
        $return = $indentNL;
        $isLoop = in_array($this->nodeName, ['for']);

        if ($this->nodeName && $this->nodeName != '#text' && ($this->nodeValue || $this->nodeValue == '0')) {
            $expr = "{$this->nodeName} ({$this->nodeValue}) {";
        } elseif ($this->nodeName && $this->nodeName != '#text') {
            $expr = $this->nodeName . ' {';
        } else {
            $expr = $this->nodeValue . ';';
        }
        $return .= '<?php ' . ($isLoop ? '$loopStart(); ' : '') . $expr . ' ?>';

        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        // NODE END
        if ($this->nodeName && $this->nodeName != '#text') {
            $return .= $indentNL . '<?php } ' . ($isLoop ? '$loopEnd(); ' : '') . '?>';
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

        $return .= "<?php (new Loop(\$_context, $subject))->run(function(\$context) { ?>";

        // NODE CONTENT
        foreach ($this->childNodes as $cn) {
            $return .= $cn;
        }

        // NODE END
        $return .= $indentNL . "<?php }, $value, $key); ?>";
        
        return $return;
    }
}
