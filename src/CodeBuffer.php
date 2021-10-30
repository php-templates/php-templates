<?php

namespace DomDocument\PhpTemplates;

class CodeBuffer
{
    private $buffer = null;
    
    private function checkInit()
    {
        if ($this->buffer === null) {
            $this->buffer = '<?php
            ';
        }
    }
    
    public function push($expr) {
        $this->checkInit();
        $this->buffer .= ($expr);
    }
    
    public function __call($expr, $args) {
        $param = $args[0] ? '('.$args[0].')' : '';
        $callback = $args[1];
        $this->checkInit();
        $this->buffer .= "$expr $param {
        ";
        $callback();
        $this->buffer .= '}
        ';
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
    
    public function getTemplateFunction(string $name, $templateString) {
        $fnDeclaration = 
        '<?php function '.$name.'($data, $slots) {
extract($data);?>';
        $fnDeclaration .= "
        $templateString";
        $fnDeclaration .= '
        <?php } ?>';
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