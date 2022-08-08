<?php

namespace PhpTemplates;

use PhpTemplates\Dom\Parser;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Entities\TextNode;
use PhpTemplates\Entities\SimpleNode;
use PhpTemplates\Entities\Component;
use PhpTemplates\Entities\Slot;
use PhpTemplates\Entities\Template;

class ViewParser
{
    private $document;
    private $configHolder;
    private $eventHolder;
    private $templates =[];
    
    public function __construct(Document$document, ConfigHolder $configHolder, EventHolder $eventHolder) 
    {
        $this->document = $document;
        $this->configHolder = $configHolder;
        $this->eventHolder = $eventHolder;
    }
    
    public function getConfigHolder(): ConfigHolder
    {
        return $this->configHolder;
    }
    
    public function parse(): string // return result path
    {
        $name = $this->document->getInputFile();
        
        $this->resolveComponent($name, $this->configHolder->get());

        //$this->document->addTemplate($name, $tplfn);
        
        $filePath = $this->document->save();
        
        return $filePath;
    }
    
    public function parseNode(DomNode $node, Config $config, AbstractEntity $context = null) 
    {
        //$GLOBALS['x'] = $this->document->getInputFile() == './temp/d';
        if (!$this->document) {
            throw new \Exception('Set the document first by calling parse() method');
        }
        //$GLOBALS['x'] && $node->d();
        if ($context) {
            $fn = explode('\\', get_class($context));
            $fn = end($fn);
            $fn = lcfirst($fn).'Context';
        } else {
            $fn = 'rootContext';
        }

        if ($node->nodeName === '#text') {
            $entity = new TextNode($this, $config, $node, $context);
        }
        elseif ($node->nodeName === 'slot') {
            $entity = new Slot($this, $config, $node, $context);
        }
        elseif ($name = $this->isComponent($node, $config)) {//TODO: intotdeauna intorc cobfih:
            // component load node
            //$this->document->getInputFile() == './temp/d' && d($name);
            $this->resolveComponent($name, $config); // if doc not having this, get it from parser instance cache, or parse it again
            $entity = new Component($this, $config, $node, $name, $context);
        }
        elseif ($node->nodeName === 'template') {
            $entity = new Template($this, $config, $node, $context);
        }
        else {
            $entity = new SimpleNode($this, $config, $node, $context);
        }
        
        $entity->{$fn}();
    }
    
    public function resolveComponent(string $name, Config $config) 
    {//$this->document->getInputFile() == './temp/d' && d($name);
        //strpos($name, 'fg2-1') && dd($name);
        if (strpos($name, ':')) {
            list($cfgKey, $rfilepath) = explode(':', $name);
            $config = $this->configHolder->get($cfgKey);
        } else {
            $rfilepath = $name;
            $name = $config->getName().':'.$rfilepath;
        }
        
        if ($this->configHolder->get()->getName() == $config->getName()) {
            // default config, don tnamespace
            //$name = $rfilepath;
        }
        //strpos($rfilepath, 'fg2-1') && dd($name);
         
         //$GLOBALS['x'] && d($this->templates[$name]);
        if (!isset($this->templates[$name])) {  
            $node = $this->load($rfilepath, $config);
            $this->parseNode($node, $config);
            $tplfn = $this->nodeToTemplateFunction($node);
        
            $this->templates[$name] = $tplfn;            
        }
//$this->document->getInputFile() == './temp/d' && d($name);
       //strpos($name, 'tends/parent2') && dd($this->templates[$name]);
        
        $this->document->addTemplate($name, $this->templates[$name]);
    }
    
    private function parsggeComponent(string $name, Config $config) 
    {
        if ($this->hasTemplate($name)) {
            return;
        }
       

    }
    
    public function nodeToTemplateFunction(DomNode $node, $asSlot = false): string
    {//TODO: prin noduri se pastreaza indent ul
        $templateString = $node->__toString(function($self) {
            dd($self);
        });
        
        if ($asSlot) {
        $fnDeclaration = 'function (/*Context $context*/) use ($context)' . PHP_EOL
        . '{' . PHP_EOL
        //. '$data = array_merge($this->scopeData, $data);' . PHP_EOL
        //. 'extract($data);' . PHP_EOL
        . '?> '. $templateString .' <?php' . PHP_EOL
        . '}';            
        }
        else {
        $fnDeclaration = 'function (Context $context) {' . PHP_EOL
        //. '$data["_attrs"] = isset($data["_attrs"]) ? $data["_attrs"] : [];' . PHP_EOL
        //. 'extract($data);' . PHP_EOL
        . '?> '. $templateString .' <?php' . PHP_EOL
        . '}';
        }

        return $fnDeclaration;
    }
    
    private function load(string $rfilepath, Config $config): DomNode
    {
        $srcFile = $this->resolvePath($rfilepath, $config);
        
        // add file as dependency to template for creating hash of states
        //$this->process->addDependencyFile($srcFile);

        $parser = new Parser();
        $result = $parser->parseFile($srcFile);
        $node = $result->node;
        $cb = $result->callback;
        
        // we create a virtual dom to make impossible loosing actual node inside events (which would break the system)
        $wrapper = new DomNode('#root');
        $wrapper->appendChild($node->detach());
        $name = $config->getName() . ':' . $rfilepath;
        
        // ownerDocument
        
        $this->eventHolder->event('parsing', $name, $node);
        is_callable($cb) && $cb($node, $this->document->getRootNode());
        
        // findout process upper component and assign it as main root
        // dom has only one node which is a component, skip
        // if process already has a root, skip
        // method getRootNode will also check for any possible parents added with phpt callbacks, but no one will do that
        if (!$this->document->getRootNode() && $this->isRootNode($node, $config)) {
            $this->document->setRootNode($wrapper);
        }
        
        return $wrapper;
    }
    
    private function resolvePath($rfilepath, Config $config, $tried = []) 
    {
        $srcFile = null;
        // try to find file on current config, else try to load it from default config
        foreach ($config->getPath() as $srcPath) {
            $filepath = rtrim($srcPath, '/').'/'.$rfilepath.'.template.php';
            if (file_exists($filepath)) {
                $srcFile = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        // file not found in any2 config
        if (!$srcFile) {
            $message = implode(' or ', $tried);
            throw new \Exception("Template file $message not found");
        }        
        
        return $srcFile;
    }
    
    public function isComponent(DomNode $node, Config $config)
    {
        if (!$node->nodeName) {
            return null;
        }
        if ($node->nodeName == 'template') {
            $rfilepath = $node->getAttribute('is');
        } else {
            $rfilepath = $config->getAliased($node->nodeName);
        }
        //strpos($rfilepath, 'fg2-1') && dd($rfilepath);
        if (!$rfilepath) {
            return null;
        }
        
        if (strpos($rfilepath, ':')) {
            $name = $rfilepath;
        } else {
            $name = $config->getName() . ':' . $rfilepath;
        }
        
        return $name;
    }
    
    private function isRootNode(DomNode $node, Config $config) 
    {
        // check equal level nodes 
        // if any siblings tags, or only one nodw, return false
        if ($node->nodeName && $node->nodeName[0] != '#') {
            return !$this->isComponent($node, $config);
        }
        $isRoot = true;
        foreach ($node->childNodes as $cn) {
            $isRoot = $isRoot && $this->isRootNode($cn, $config);
        }

        return $isRoot;
    }
    
    public function hasTemplate(string $name) 
    {
        return isset($this->templates[$name]);
    }
}