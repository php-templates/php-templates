<?php

namespace HarmonyTools;

class PhpTemplates
{
    // requestName => [requestName => filetime, ...other components]
    private static $dependencies = null;
    
    private $options = [
        'prefix' => '@',
        'src_path' => 'views/',
        'dest_path' => 'parsed/'
    ];
    
    private $rfilepath = '';
    
    public function __construct(array $options = [])
    {
        if (self::$dependencies === null) {
            self::$dependencies = require_once('dependencies_map.php');
        }
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
        $this->slotsHash = $this->getSlotsHash();
        $this->destFile = $this->getDestFilePath(); // based on req file, timestamp, slotsHash
        
        $hasChanged = $this->syncDependencies($this->requestName);
        if (!$hasChanged && $this->destFile && file_exists($this->destFile)) {
            return require($this->destFile);
        }
        
        
    }
    
    private function syncDependencies(string $reqName): bool
    {
        // ignoee self from list for avoíding infinite loop
        if (in_array($reqName, $this->checkedDependencies)) {
            return false;
        }
        $this->checkedDependencies[] = $reqName;
        
        $dependencies = self::$dependencies[$reqName] ?? [];
        $updated = false;
        foreach ($dependencies as $_reqName => $timestamp) {
            $nowstamp = fileatime($this->getSrcFile($_reqName));
            self::$dependencies[$reqName][$_reqName] = $nowstamp;
            $updated = $updated || $timestamp === $nowstamp;
            $updated = $updated || $this->syncDependencies($reqName);
        }
        return $updated;
    }
    
    private function getSlotsHash()
    {
        $hash = '';
        foreach ($slots as $slot) {
            if (is_string($slot)) {
                $hash .= md5($slot);
            } 
            elseif ($slot instanceof self) {
                $hash .= fileatime($slot->getSrcFile());
                $hash .= $slot->getSlotsHash();
            } 
            else {
                
            }
        }
        return substr(md5($string, true), 0, 12);
    }
}