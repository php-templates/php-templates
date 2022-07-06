<?php

namespace PhpTemplates;

use Exception;
use PhpTemplates\Entities\Root;

class PhpTemplate
{
    /**
     * configs keyed by namespace
     */
    protected $configs = [];
    protected $destPath;
    public $trackChanges = false;
    public $debugMode = true;
    
    public function __construct(string $srcPath, string $destPath) {
        $this->destPath = $destPath;
        $this->configs['default'] = new Config('default', $srcPath);
    }
    
    public function load(string $rfilepath, array $data = [], $slots = [])
    {
        $start_time = microtime(true);
        $template = $this->get($rfilepath, [], $slots);
        $template->render($data);
       // print_r('<br>'.(microtime(true) - $start_time));
    }

    public function get(string $rfilepath, array $data = [], $slots = [])
    {
        if (isset(Parsed::$templates[$rfilepath])) {
            return Parsed::template($rfilepath, $data);
        } else {
            $requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            // init the document with custom settings as src_path, aliases
            // paths will fallback on default Config in case of file not found or setting not found
            $doc = new Document($this->destPath, $requestName, '', $this->trackChanges && !$this->debugMode);
            if (($path = $doc->exists()) && !$this->debugMode) {} 
            else 
            {
                //try {
                    $process = new Process($rfilepath, $this->configs);
                    (new Root($process, null, $rfilepath))->rootContext();
                    $doc->setContent($process->getResult());
                    $path = $doc->save();
                //} catch(Exception $e) {
             //       throw new Exception($e->getMessage());
                //}
            }

            require_once($path);
            
            return Parsed::template($requestName, $data)->setSlots($slots);
        }
    }

    public function raw(\Closure $cb, $data = [])
    {
        return Parsed::raw(null, $cb, $data);
    }
    
    public function getConfig(string $key = 'default'): Config
    {
        if (!isset($this->configs[$key])) {
            throw new \Exception("Config key $key does not exists");
        }
        
        return $this->configs[$key];
    }
    
    /**
     * Add additional parse src path
     */
    public function addPath($name, $srcPath)
    {
        if (isset($this->configs[$name])) {
            throw new \Exception("Config '$name' already exists");
        }
        $this->configs[$name] = new Config($name, $srcPath);
    }

    public function replacePath($name, $srcPath)
    {
        if (!isset($this->configs[$name])) {
            $this->addPath($name, $srcPath);
        } else {
            $this->configs[$name]->setSrcPath($srcPath);
        }
    }
    
    public function setDestPath($dest)
    {
        $this->destPath = $dest;
    }
}
