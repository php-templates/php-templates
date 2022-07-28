<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\Parser;
use PhpTemplates\DomEvent;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Template;
use PhpTemplates\Traits\CanParseNodes;
use PhpTemplates\Process;

class Root extends AbstractEntity
{
    /**
     * the name ID of the template file
     *
     * @var string $name 
     */
    private $namespacePath;
    private $name;

    /**
     * Gain a singlethon process as param and every entity will push/register data to it
     *
     * @param Process $process
     * @param DomNode $node
     * @param string $withName
     */
    public function __construct(Process $process, DomNode $node = null, string $name, $context = null)
    {
        $this->name = $name;
        $this->context = $context;
        $this->process = $process;
        
        if (is_null($node) && !$name) {
            throw new \Exception('Node or name must be given');
        }
        elseif (is_null($node) && $name) 
        {
            // find config file, load e de abstract entitiy, nu de process si va chema parser.parsefile iar parser va fi cel care executa callback ul, si intoarce doar un nod, atata
            $node = $this->load($name);
        }
        
        parent::__construct($process, $node, $context);
        $this->depth = 0;
    }

    /**
     * Load the given route document using this.document settings with fallback on default settings
     * @param string $name can contin config namespace with a form like: Ns:template/name 
     */
    public function load(string $name)
    {
        // obtaining config prefix pointing to settings collection then assign it to current process but preserve old config key to return to initial state
        $path = array_filter(explode(':', $name));
        $this->namespacePath = count($path) > 1 ? $path[0] : $this->process->config->name;
        
        // obtaining relative template file path and load it using config's src path
        $rfilepath = end($path);

        // obtaining the template file path using multi-config mode
        $srcFile = null;
        $tried = [];

        // try to find file on current config, else try to load it from default config
        foreach ($this->getSrcPaths($this->namespacePath) as $srcPath) {
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
        
        // add file as dependency to template for creating hash of states
        $this->process->addDependencyFile($srcFile);

        $parser = new Parser();
        // we create a virtual dom to make impossible loosing actual node inside events (which would break the system)
        $wrapper = new DomNode('#root');
        
        $parser->beforeCallback(function($node) use ($wrapper, $name) {
            $wrapper->appendChild($node->detach());
            //events before parsing a template
            $wrapper->parent($this->process->getRootNode());
            DomEvent::event('parsing', $name, $node);
        });
        $node = $parser->parseFile($srcFile);
        
        // findout process upper component and assign it as main root
        // dom has only one node which is a component, skip
        // if process already has a root, skip
        // method getRootNode will also check for any possible parents added with phpt callbacks, but no one will do that
        if (!$this->process->getRootNode() && $this->isRootNode($node)) {
            $this->process->setRootNode($wrapper);
        }
        
        return $wrapper;
    }    
    
    /**
     * return merged paths [current config, default]
     *
     * @return array
     */
    protected function getSrcPaths(string $configKey = ''): array
    {
        $paths = [];

        $config2 = $this->process->configs[$configKey];

        if ($config2->name != 'default') {
            $paths = (array)$config2->srcPath;
        }

        $paths = array_merge($paths, (array)$this->process->configs['default']->srcPath);

        return $paths;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
    
    public function rootContext()
    {
        if ($this->namespacePath) {
            $this->process->withConfig($this->namespacePath, function() {
                $this->parseNode($this->node);
                $this->register();
            });
        } 
        else {
            $this->parseNode($this->node);
            $this->register();
        }
    }
    
    public function simpleNodeContext() {
        $this->rootContext();
    }
    public function componentContext() {
        $this->rootContext();
    }
    public function blockContext() {
        $this->rootContext();
    }
    public function slotContext() {
        $this->rootContext();
    }
    public function templateContext() {
        $this->rootContext();
    }
    
    private function isRootNode($node) 
    {
        // check equal level nodes 
        // if any siblings tags, or only one nodw, return false
        if ($node->nodeName && $node->nodeName[0] != '#') {
            return !$this->isComponent($node);
        }
        $isRoot = true;
        foreach ($node->childNodes as $cn) {
            $isRoot = $isRoot && $this->isRootNode($cn);
        }

        return $isRoot;
    }
}