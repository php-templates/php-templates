<?php

namespace PhpTemplates;

class CodeBuffer
{
    private $buffer = null;
    
    public function isInit()
    {
        return $this->buffer !== null;
    }
    
    private function checkInit()
    {
        if ($this->buffer === null) {
            $this->buffer = '<?php ';
        }
    }
    
    public function raw($expr) {
        $this->checkInit();
        $this->buffer .= "
    $expr";
    }
     
    public function component(string $name, array $nodeData = []) {
        //nu trb sa fie asa, trb scos la suprafata na
        $data = Helper::arrayToEval($nodeData);
        $this->checkInit();
        $this->buffer .= "\$this->comp[0] = Parsed::template('$name', $data);".PHP_EOL;
    }
     
    public function slot(int $i, string $pos, string $name, $nodeData) {
        $data = Helper::arrayToEval($nodeData);
        $this->checkInit();
        $next = $i+1;
        $this->buffer .= "\$this->comp[{$next}] = \$this->comp[{$i}]->addSlot('$pos', Parsed::template('$name', $data));".PHP_EOL;
    }
    
    public function block($name) {
        $this->checkInit();
        $this->buffer .= "\$this->block['$name'] = Parsed::raw('$name', function(\$data, \$slots) {
            extract(\$data);
            if (isset(\$this->slots['$name'])) {
                usort(\$this->slots['$name'], function(\$a, \$b) {
                    \$i1 = isset(\$a->data['_index']) ? \$a->data['_index'] : 0;
                    \$i2 = isset(\$b->data['_index']) ? \$b->data['_index'] : 0;
                    return \$i1 - \$i2;
                });
                foreach (\$this->slots['$name'] as \$slot) {
                    \$slot->render(\$data);
                }
            }
        })->setSlots(\$slots);";
    }
    
    public function blockItem($bname, $name, $data)
    {
        $data = Helper::arrayToEval($data);
        $this->buffer .= PHP_EOL."\$this->block['$bname']->addSlot('$bname', Parsed::template('$name', $data))->setSlots(\$slots);";
    }
    
    public function render($type, $name)
    {
        $this->buffer .= PHP_EOL."\$this->$type"."['$name']->render(\$data);";
    }
    
    public function __call($expr, $args) {
        $param = $args[0] || $args[0] === '0' ? '('.$args[0].')' : '';
        $callback = $args[1];
        $this->checkInit();
        $this->buffer .= "
    $expr $param {";
        $callback();
    $this->buffer .= '
    }';
    }
    
    public function getStream($reset = false)
    {
        $r = $this->buffer;
        if ($reset) {
            $r .= ' ?>';
            $this->buffer = null;
        }

        return $r;
    }
    
    public static function getTemplateFunction(string $templateString, $html = true) {
        preg_match_all('/\$([a-zA-Z0-9_]+)/', $templateString, $m);
        $used = Helper::arrayToEval(array_values(array_unique($m[1])));//var_dump($used);die();
        $used = preg_replace('/\s*[\r\n]*\s*/', '', $used);
        if ($html) {
            $templateString = " ?>$templateString<?php ";
        }
        $fnDeclaration = 
        "function (\$data, \$slots) {
    extract(\$data); \$_attrs = array_intersect_key(\$data, array_flip(array_diff(\$_attrs, $used)));
    $templateString
}";
        return $fnDeclaration;
    }
    
    public function nestedExpression(array $expr, $cb)
    {
        if (count($expr) === 0) {
            $cb();
            return;
        }
        
        $i = array_keys($expr);
        $i = reset($i);
        
        if (count($expr) === 1) {
            $this->$i($expr[$i], $cb);
            return;
        }
        
        $this->$i($expr[$i], function() use ($expr, $i, $cb) {
            unset($expr[$i]);
            $this->nestedExpression($expr, $cb);
        });
    }
    
    public function __toString()
    {
        return $this->buffer;
    }
}