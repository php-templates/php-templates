<?php

namespace PhpTemplates;

use Exception;
use PhpTemplates\Entities\Root;

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
    private $sharedData = [];
    private $outputFolder;
    private $viewParser;
    private $dependenciesMap;
    
    public function __construct(string $outputFolder, ViewParser $viewParser, DependenciesMap $dependenciesMap) {
    //public function __construct(string $srcPath, string $destPath) {
        $this->outputFolder = $outputFolder;
        $this->viewParser = $viewParser;
        $this->dependenciesMap = $dependenciesMap;
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

    public function make(string $rfilepath, array $data = [], $slots = [])
    {
        $document = new Document($rfilepath, $this->outputFolder, $this->dependenciesMap);
            //$requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            // init the document with custom settings as src_path, aliases
            // paths will fallback on default Config in case of file not found or setting not found
            //$doc = new Document($this->destPath, $requestName, '', $this->trackChanges && !$this->debugMode);
            if (($path = $document->exists()) && !$this->debugMode) {} 
            else 
            {
                //$parser = new ViewParser;
                $path = $this->viewParser->parse($document);
                
                
                //$path = $this->parser->parse($this->document);
               
                //$this->parser->parseFile($name, $config = null);
                //try {
                    //$process = new Process($rfilepath, $this->configs);
                    //(new Root($process, null, $rfilepath))->rootContext();
                    //$this->document->setContent($process->getResult());
                    //$path = $this->document->save();
                //} catch(Exception $e) {
             //       throw new Exception($e->getMessage());
                //}
                //$this->parser->parseNode($node, $config, $context);
            }
            
            $result = require_once($path);
            
            return $result
            ->with($data)
            ->withShared($this->sharedData)
            ->withComposers($this->composers)
            ->setSlots($slots);
        
    }
    
    public function share(array $data) 
    {
        $this->sharedData = array_merge($this->sharedData, $data);
    }
    
    public function composer(string $name, \Closure $cb) 
    {
        $this->dataComposers[$name][] = $cb;
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
}
