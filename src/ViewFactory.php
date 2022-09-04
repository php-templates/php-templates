<?php

namespace PhpTemplates;

use Exception;
use PhpTemplates\Entities\StartupEntity;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Source;
use PhpTemplates\Dom\Parser;
use PhpTemplates\Entities\SimpleNode;
use PhpTemplates\Cache\FileSystemCache;
use PhpTemplates\Cache\NullCache;

class ViewFactory
{
    /**
     * configs keyed by namespace
     */
    /*
    protected $configs = [];
    protected $destPath;
    public $trackChanges = false;
    public $debugMode = true; */
    protected $composers = [];
    private $shared = [];
    private $outputFolder;
   // private $dependenciesMap;
    private $configHolder;
    private $eventHolder;
    
    public function __construct(?string $outputFolder, ConfigHolder $configHolder, EventHolder $eventHolder) {
    //public function __construct(string $srcPath, string $destPath) {
        $this->outputFolder = $outputFolder;
        // $this->viewParser = $viewParser;
        //$this->dependenciesMap = $dependenciesMap;
        $this->configHolder = $configHolder;
        $this->eventHolder = $eventHolder;
        //$this->configs['default'] = new Config('default', $srcPath);
        // TODO
    }
    
    public function render(string $rfilepath, array $data = [], $slots = [])
    {
        $start_time = microtime(true);
        $template = $this->make($rfilepath, [], $slots);
        $template->render($data);
       // print_r('<br>'.(microtime(true) - $start_time));
    }
    
    public function rawMake(string $phpt, $data = [], $slots = []) 
    {
        $cache = $this->getCache();
        $rfilepath = md5($phpt);
 
        
            //$requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            // init the document with custom settings as src_path, aliases
            // paths will fallback on default Config in case of file not found or setting not found
            //$doc = new Document($this->destPath, $requestName, '', $this->trackChanges && !$this->debugMode);
            if (!$cache->load($rfilepath)) 
            {
        //todo source line pointing to caller line
        $source = new Source($phpt, '');
        $parser = new Parser();
        $node = $parser->parse($source);                       
                
                // parse it
                //$name = $document->getInputFile();
                $factory = new EntityFactory($cache, $this->configHolder, $this->eventHolder);
                $entity = $factory->make($node, new StartupEntity($this->configHolder->get(), $rfilepath));
                $entity->parse();
                
                $cache->write($rfilepath);
                
            }
            
            $repository = new TemplateRepository($cache, $this->eventHolder);
            $result = $repository->get($rfilepath);
            
            return $result
            ->with($data)
            ->withShared($this->shared)
            ->withComposers($this->composers)
            ->setSlots($slots);
    }

    public function make(string $rfilepath, array $data = [], $slots = [])
    {
        $cache = $this->getCache();
            //$requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            // init the document with custom settings as src_path, aliases
            // paths will fallback on default Config in case of file not found or setting not found
            //$doc = new Document($this->destPath, $requestName, '', $this->trackChanges && !$this->debugMode);
            if (!$cache->load($rfilepath)) 
            {
                // parse it
                //$name = $document->getInputFile();
                $factory = new EntityFactory($cache, $this->configHolder, $this->eventHolder);
                $entity = $factory->make(new DomNode('template', ['is' => $rfilepath]), new StartupEntity($this->configHolder->get()));
                $entity->parse();
                
                $cache->write($rfilepath);
                
            }
            
            $repository = new TemplateRepository($cache, $this->eventHolder);
            $result = $repository->get($rfilepath);
            
            return $result
            ->with($data)
            ->withShared($this->shared)
            ->withComposers($this->composers)
            ->setSlots($slots);
        
    }
    
    public function share(array $data) 
    {
        $this->shared = array_merge($this->shared, $data);
    }
    
    public function composer(string $name, \Closure $cb) 
    {
        $this->composers[$name][] = $cb;
    }

//todo
    public function delleteeeeraw(\Closure $cb, $data = [])
    {
        return Template::raw(null, $cb, $data);
    }
    
    public function getParser(): ViewParser
    {
        return $this->parser;
    }
    
    public function getCache() 
    {
        if ($this->outputFolder) {
            $cache = new FileSystemCache($this->outputFolder);
        } else {
            $cache = new NullCache();
        }  
        
        return $cache;
    }
   
   // todo remove 
    /**
     * Add additional parse src path
     */
    public function ahhhgddPath($name, $srcPath)
    {
        if (isset($this->configs[$name])) {
            throw new \Exception("Config '$name' already exists");
        }
        $this->configs[$name] = new Config($name, $srcPath);
    }

    public function rehbbbplacePath($name, $srcPath)
    {
        if (!isset($this->configs[$name])) {
            $this->addPath($name, $srcPath);
        } else {
            $this->configs[$name]->setSrcPath($srcPath);
        }
    }
    
    public function setDggvcestPath($dest)
    {
        $this->destPath = $dest;
    }
    
    public function getConfigHolder(): ConfigHolder
    {
        return $this->configHolder;
    }
    
    public function getEventHolder(): ConfigHolder
    {
        return $this->eventHolder;
    }
    
}
