<?php

namespace PhpTemplates\Cache;

use PhpTemplates\Template;
use PhpTemplates\EventHolder;
use PhpTemplates\Source;

class NullCache extends FileSystemCache implements CacheInterface
{
    public function __construct() {}
    
    public function load(string $key): bool
    {
        $this->store = $this->source = $this->dependencies = [];
        
        $file = $this->getFilePath($key);
        
        if (!file_exists($file)) {
            return false;
        }
        
        $cache = $this;
        if (($loaded = require($file)) === false) {
            return false;
        }
       
        return true;
    }
    
    public function write(string $key) 
    {
        parent::write($key);
        
        $file = $this->getFilePath($key);
        if (file_exists($file)) {
            unlink($file);
        }
    }
    
    protected function getFilePath(string $key)
    {
        $pf = rtrim(sys_get_temp_dir(), '/ ').'/';
        $name = trim(str_replace(['/', ':'], '_', $key), '/ ');//todo hash with name
        
        return $pf . $name . '.php';
    }
}
