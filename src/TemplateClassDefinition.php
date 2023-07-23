<?php

namespace PhpTemplates;

use PhpParser\Node\Stmt\Class_;
use PhpParser\PrettyPrinter;
use PhpParser\BuilderFactory;

class TemplateClassDefinition
{
    private $namespace;
    private $ast;
    private $uses;
    
    public function __construct($ast, $uses = []) 
    {
        $this->ast = $ast;
        $this->uses = $uses;
        $this->namespace = 'PHPT_' . uniqid();
    }
    
    public function getFullName() 
    {
        return $this->namespace . '\\' . $this->getName();
    }
    
    public function getName() 
    {
        return $this->ast->name;
    }
    
    public function addMethod(string $name, string $body, int $flag = 1) 
    {
        $this->ast->stmts[] = new \PhpParser\Node\Stmt\ClassMethod($name, [
            'flags' => $flag,
            'stmts' => [new \PhpParser\Node\Stmt\InlineHTML($body)]
        ]);
    }
    
    public function addProp(string $name, string $value, int $accessLevel = 3) 
    {
        $factory = new BuilderFactory;
        //dd(get_class_methods($factory));
        $prop = $factory->property($name);
        $prop->setDefault($value);
        $prop->makeProtected();
        array_unshift($this->ast->stmts, $prop->getNode());
    }  
        
    public function addConst(string $name, string $value) 
    {
        $factory = new BuilderFactory;
        $prop = $factory->classConst($name, $value);
        array_unshift($this->ast->stmts, $prop->getNode());
   return;
        $prop = $factory->classConst('config', $config);
        array_unshift($ast->stmts, $prop->getNode());
        $prop = $factory->classConst('name', $name);
        array_unshift($ast->stmts, $prop->getNode());
        $prop = $factory->classConst('file', $source->getFile());
        array_unshift($ast->stmts, $prop->getNode());
    }
    
    public function extends(string $class) 
    {
        $parts = array_values(array_filter(explode('\\', $class)));
        if (strpos($class, '\\') === 0) {
            $this->ast->extends = new \PhpParser\Node\Name\FullyQualified($parts);
        }
        else {
            $this->ast->extends->parts = $parts;
        }
        
        return $this;
    }
    
    public function toString(): string
    {
        $prettyPrinter = new PrettyPrinter\Standard;
        $string = $prettyPrinter->prettyPrint([$this->ast]); 
        $string = preg_replace('/\?>([ \t\n\r]*)<\?php/', '$1', $string);
        
        $return = "namespace {$this->namespace} {\n";
        foreach ($this->uses as $use) {
            $return .= "use {$use};\n";
        }
        $return .= str_replace("\n", "    \n", $string) . "\n";
        $return .= "}\n";
        
        return $return;
    }
    
    public function hasMethod(string $m): bool
    {
        foreach ($this->ast->stmts as $stmt) {
            if (! $stmt instanceof \PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            if ($stmt->name == $m) {
                return true;
            }
        }
        
        return false;
    }
    
    public function __toString() 
    {
        return $this->toString();
    }
}
