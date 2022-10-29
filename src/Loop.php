<?php

namespace PhpTemplates;

class Loop
{
    private $context;
    private $subject;
    private $i;
    
    public function __construct(Context $context, $subject) 
    {
        $this->context = $context->subcontext();
        $this->subject = (array)$subject;
        $this->context->loop = $this;
    }
    
    public function run(\Closure $cb, $value, $key = null)
    {
        $this->i = 0;
        
        if (!$key) {
            foreach ($this->subject as $this->context->{$value}) {
                $cb($this->context);
                $this->i++;
            }
        }
        else {
            foreach ($this->subject as $this->context->{$key} => $this->context->{$value}) {
                $cb($this->context);  
                $this->i++;
            }
        }
    }
    
    public function isFirst() 
    {
        return $this->i === 0;
    }
    
    public function isLast() 
    {
        return $this->i === count($this->subject) -1;
    }  
}