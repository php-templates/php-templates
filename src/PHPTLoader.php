<?php

namespace PhpTemplates;

use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\BuilderFactory;
use PhpParser\Node\Name\FullyQualified;
use PhpTemplates\Dom\DomNode;

class PHPTLoader
{
    private $registry;
    
    public function __construct($registry) {
        $this->registry = $registry;
    }
    
    public function load(string $file, string $name) 
    {
        $template = [];
        
        ob_start();
        $view = require($file);
        $source = ob_get_contents();
        ob_end_clean();
        
        if (is_object($view) && !strstr(get_class($view), 'class@anonymous')) {
            throw new \Exception('Template file may return only class@anonymous objects, ' . get_class($view) . ' returned from: ' . $file);
        }
        
        if (is_object($view)) {
            $template['object'] = $view;
            $php = file_get_contents($file);
        }
        else {
            $template['object'] = new class {};
            $php = '<?php return new class {};';
        }
        
        $template['class'] = $this->templateClassBuilder(new Source($php, $file), $name);

        $source = new Source($source, $file);
        $node = $this->registry->dom->parse($source);
        $wrapper = new DomNode('#root');
        $wrapper->appendChild($node->detach());
        $template['node'] = $wrapper;
                
        return $template;
    }
    
    public function loadSource(Source $source) 
    {// todo: test this
        if (is_file($source->getFile())) {
            return $this->load($source->getFile(), $source->getFile());
        }
        
        $template = [];
        
        $file = $name = $source->getFile();
        $source = (string)$source;
        
        $template['object'] = new class {};
        $php = '<?php return new class {};';
        
        $template['class'] = $this->templateClassBuilder(new Source($php, $file), $name);

        $source = new Source($source, $file);
        $node = $this->registry->dom->parse($source);
        $wrapper = new DomNode('#root');
        $wrapper->appendChild($node->detach());
        $template['node'] = $wrapper;
                
        return $template;
    }
    
    private function templateClassBuilder(Source $source, string $name): TemplateClassBuilder
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $asts = $parser->parse((string)$source);
        $ast = null;
        foreach ($asts as $_ast) {
            if ($_ast instanceof \PhpParser\Node\Stmt\Use_) {
                $use = implode('\\', $_ast->uses[0]->name->parts);
                if (!empty($_ast->uses[0]->alias->name)) {
                    $use .= ' as ' . $_ast->uses[0]->alias->name;
                }
                if (!in_array($use, $this->registry->uses)) {
                    $this->registry->uses[] = $use;
                }
            }
            if ($_ast instanceof \PhpParser\Node\Stmt\Return_) {
                $ast = $_ast;
                break;
            }
        }
        
        if (!$ast) {
            throw new \Exception("Error parsing template");
        }
        
        $ast = $ast->expr->class;
        if (!empty($ast->extends)) {
            throw new \Exception('Template files may return only class@anonymous objects (without extends): ' . $source->getFile());
        }    
        
        $ast->name = 'PHPT_' . md5($source->getFile());
        $ast->extends = new FullyQualified(['PhpTemplates', 'View']);

        foreach ($ast->stmts as $i => $stmt) {
            if (! $stmt instanceof \PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            if (in_array($stmt->name, ['render', 'parsing', 'parsed'])) {
                unset($ast->stmts[$i]);
            }
        }
        
        $factory = new BuilderFactory;
        $config = '';
        if (strpos($name, ':')) {
            list($config) = explode(':', $name);
        }
        $prop = $factory->classConst('config', $config);
        array_unshift($ast->stmts, $prop->getNode());
        $prop = $factory->classConst('name', $name);
        array_unshift($ast->stmts, $prop->getNode());
        $prop = $factory->classConst('file', $source->getFile());
        array_unshift($ast->stmts, $prop->getNode());
        
        return new TemplateClassBuilder($ast);
    }
}