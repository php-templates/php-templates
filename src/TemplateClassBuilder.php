<?php

namespace PhpTemplates;

use PhpParser\Node\Stmt\Class_;
use PhpParser\PrettyPrinter;

class TemplateClassBuilder
{
    private $ast;
    
    public function __construct(Class_ $ast) 
    {
        $this->ast = $ast;
    }
    
    public function addMethod(string $name, string $body, array $options = []) 
    {
        $this->ast->stmts[] = new \PhpParser\Node\Stmt\ClassMethod($name, [
            'flags' => 1, // todo: option
            'stmts' => [new \PhpParser\Node\Stmt\InlineHTML($body)]
        ]);        
    }
    
    public function getName() 
    {
        return $this->ast->name;
    }
    
    public function __toString()
    {
        $prettyPrinter = new PrettyPrinter\Standard;
        return $prettyPrinter->prettyPrint([$this->ast]);
    }
}