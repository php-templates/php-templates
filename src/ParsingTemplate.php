<?php

namespace PhpTemplates;

use PhpDom\Source;
use PhpDom\Contracts\DomElementInterface as DomNode;
use PhpTemplates\View;
use PhpTemplates\Exceptions\TemplateNotFoundException;
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
    private string $code = '<?php return new class {};';
    
    public function __construct(string $name, ?string $file, ?string $html, Config $config)
    {
        [$this->name, $this->config] = $this->parsePath($name, $config);
        $this->file = $file;
        $this->html = $html;
        $this->obj = new class {};

        # init
        $this->node = $this->getDomNode();
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
        if (!is_null($this->file)) {
            return $this->file;        
        }
        
        $file = explode(':', $this->name);
        $file = end($file);
        # find file
        // try to find file on current config, else try to load it from default config
        $srcFile = null;
        $tried = [];
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
            throw new TemplateNotFoundException("View file '". $pf . $this->name ."' not found", $tried);
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
            $obj = new class {};
        } else {
            $this->code = file_get_contents($file);
        }
        
        if (get_parent_class($obj)) {
            throw new \Exception("Template file {$this->file} must return a new class {} without parent");
        }

        if (strpos(get_class($obj), 'class@anonymous') !== 0) {
            throw new \Exception("Template file {$file} must return a new class {}");
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
}