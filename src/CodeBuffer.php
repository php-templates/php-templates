<?php

namespace DomDocument\PhpTemplates;

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
            $this->buffer = '<?php';
        }
    }
    
    public function raw($expr) {
        $this->checkInit();
        $this->buffer .= "
    $expr";
    }
     
    public function component(string $name, array $data = []) {
        $data = Helper::arrayToEval($data);
        $this->checkInit();
        $this->buffer .= "\$comp0 = Parsed::template('$name', $data);".PHP_EOL;
    }
     
    public function slot(int $i, string $pos, string $name, array $data = []) {
        $data = Helper::arrayToEval($data);
        $this->checkInit();
        $next = $i+1;
        $this->buffer .= "\$comp{$next} = \$comp{$i}->addSlot('$pos', Parsed::template('$name', $data));".PHP_EOL;
    }
    
    public function __call($expr, $args) {
        $param = $args[0] ? '('.$args[0].')' : '';
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
        
        $this->$i($expr[$i], function() use ($expr, $i) {
            unset($expr[$i]);
            $this->nestedExpression($expr, $cb);
        });
    }
}