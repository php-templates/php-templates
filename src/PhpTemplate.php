<?php

namespace HarmonyTools;

class PhpTemplates
{
    // requestName => [requestName => filetime, ...other components]
    private static $dependencies;
    
    private $options = [
        'prefix' => '@',
        'src_path' => 'views/',
        'dest_path' => 'parsed/'
    ];
    
    private $rfilepath = '';
    
    public function __construct(array $options = [])
    {
        $this->mergeOptions($options);
    }
    
    private function mergeOptions($options)
    {
        if (isset($options['prefix'])) {
            if (!trim($options['prefix'])) {
                unset($options['prefix']);
            }
        }
        $this->options = (object) array_merge((array) $this->options, $options);
    }
    
    public function load(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        $this->rfilepath = $this->requestName.'.template.php';
        $this->file = $this->options->src_path.$this->rfilepath;
        $this->timestamp = fileatime($this->file);
        $this->slotsHash = $this->getSlotsHash($slots);
        $this->destFile = $this->getDestFilePath(); // based on req file, timestamp, slotsHash
        
        $hasChanged = $this->syncDependencies($this->requestName);
        if (!$hasChanged && $this->destFile && file_exists($this->destFile)) {
            return require($this->destFile);
        }
        
        
    }
    
    private function syncDependencies(string $reqName)
    {
        
    }
    
    private function getSlotsHash(array $slots)
    {
        
    }
}