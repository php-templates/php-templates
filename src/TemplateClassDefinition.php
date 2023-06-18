<?php

namespace PhpTemplates;

use PhpParser\Node\Stmt\Class_;
use PhpParser\PrettyPrinter;

class TemplateClassDefinition
{
    private $ast;
    private $uses;
    
    public function __construct($ast, $uses = []) 
    {
        $this->ast = $ast;
        $this->uses = $uses;
    }
    
    public function addMethod(string $name, string $body, int $flag = 1) 
    {
        $this->ast->stmts[] = new \PhpParser\Node\Stmt\ClassMethod($name, [
            'flags' => $flag,
            'stmts' => [new \PhpParser\Node\Stmt\InlineHTML($body)]
        ]);
    }
    
    public function __toString() 
    {
        $prettyPrinter = new PrettyPrinter\Standard;
       
        return $prettyPrinter->prettyPrint([$this->ast]);        
    }
}
