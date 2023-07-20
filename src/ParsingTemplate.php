<?php

namespace PhpTemplates;

use PhpDom\Source;
use PhpDom\Contracts\DomElementInterface as DomNode;
use PhpTemplates\Parsed\View;
use PhpDom\Parser as DomParser;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\BuilderFactory;
use PhpParser\Node\Name\FullyQualified;

class ParsingTemplate
{
    private string $name;
    private ?string $file;
    private ?string $html;
    private Config $config;
    private DomNode $node;
    private $obj;
    private $classDefinition;
    private string $code = '<?php return new class extends View {};';
    
    public function __construct(string $name, ?string $file, ?string $html, Config $config)
    {// todo setup from name?
        [$this->name, $this->config] = $this->parsePath($name, $config);
        $this->file = $file;
        $this->html = $html;
        $this->obj = new class extends View {};

        # init
        $this->node = $this->getDomNode();//$this->setAstObject();
        //strpos($name, 'orm-gr') && print_r('->->->'.$this->node."");
    }
    
    public function getDomNode(): DomNode
    {
        if (isset($this->node)) {
            return $this->node;
        }
        
        # load file html code and parse it
        $domParser = new DomParser();
        $source = new Source($this->getHtml(), $this->getFile());
        $this->node = $domParser->parse($source);
        
        return $this->node;
    }
    
    public function getFile()
    {
        if ($this->file) {
            return $this->file;        
        }
        
        $file = explode(':', $this->name);
        $file = end($file);
        # find file
        // try to find file on current config, else try to load it from default config
        $srcFile = null;
        foreach ($this->config->getPath() as $srcPath) {
            $filepath = rtrim($srcPath, '/') . '/' . $file . '.t.php';
            if (file_exists($filepath)) {
                $this->file = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        // file not found in any2 config
        if (! $this->file) {
            $pf = $this->config->isDefault() ? $this->config->getName() . ':' : '';
            throw new TemplateNotFoundException("View file '". $pf . $this->name ."' not found");
        }

        return $this->file;        
    }
    
    public function getHtml()
    {
        if ($this->html) {
            return $this->html;        
        }        
        
        # load code
        $file = $this->getFile();
        ob_start();
        $obj = require($file);
        $html = ob_get_contents();
        ob_end_clean();
        // object returned by template, serving as logic holder
        if (!is_object($obj)) {
            $obj = new class extends View {};
        } else {
            $this->code = file_get_contents($file);
        }
        
        if (! $obj instanceof View) {
            throw new \Exception("Template file {$file} must return a valid object extending View::class");
        }
        
        $this->obj = $obj;
        $this->html = $html;
        
        return $this->html;        
    }
    
    private function parsePath(string $name, Config $config)
    {
        if (strpos($name, ':') !== false) 
        {
            list($cfgkey, $name) = explode(':', $name);
            $config = $config->getRoot()->find($cfgkey);
        }

        if (! $config->isDefault()) {
            $name = $config->getName() . ':' . $name;
        }
        
        return [$name, $config];
    }
    
    public function getCode(): string
    {
        $this->getHtml();
        
        return $this->code;
    }
    
    public function getClassDefinition() 
    {
        if (! $this->classDefinition) {
            $this->classDefinition = (new PhpParser())->parse($this);
        }
        
        return $this->classDefinition;
    }
    
    protected function sgfgghetAstObject()
    {// todo throw error if not anon class returned or extends something
        if (!$this->getFile()) {
            $source = file_get_contents($this->getFile());
        } else {
            $source = 'new class {}';
        }
            //$source = 'new class {}';

        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $asts = $parser->parse($source);

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
        
        $this->ast = $ast;
        $ast->name = 'PHPT_' . str_replace('/', '_', $this->name);// todo replace non alfanum
        $ast->extends = new FullyQualified(['PhpTemplates', 'Parsed', '_View']);

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
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getObject()
    {
        return $this->obj;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
    
    public function hasRenderFunction()
    {
        return method_exists($this->obj, 'render');
    }
}