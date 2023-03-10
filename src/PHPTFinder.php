<?php

namespace PhpTemplates;

class PHPTFinder
{
    private $registry;
    
    public function __construct(Registry $registry) {
        $this->registry = $registry;
    }
    
    public function find(string $name, Config $config = null): array
    {
        if (!$config) {
            $config = $this->registry->config;
        }
        
        return $this->parsePath($name, $config);
    }
    
    private function parsePath($rfilepath, $config): array
    {
        $cfgkey = null;
        if (strpos($rfilepath, ':') !== false) {
            list($cfgkey, $rfilepath) = explode(':', $rfilepath);
        }
        
        if ($cfgkey) {
            $config = $this->registry->config->find($cfgkey);
        } 
        elseif (is_null($cfgkey)) {
            $config = $this->registry->config;
        }
        // else config inheritance
      
        $name = $rfilepath;
        if (!$config->isDefault()) {
            $name = $config->getName() . ':' . $rfilepath;
        }
        
        $file = $this->resolvePath($rfilepath, $config);
        
        return compact('file', 'name', 'config');
    }
    
    /**
     * Gain a relative path and test it against config paths with fallback on default config (in case)
     *
     * @param string $rfilepath
     * @param Config $config
     * @return string
     */
    private function resolvePath(string $rfilepath, Config $config): string
    {
        $srcFile = null;
        // try to find file on current config, else try to load it from default config
        foreach ($config->getPath() as $srcPath) {
            $filepath = rtrim($srcPath, '/') . '/' . $rfilepath . '.t.php';
            if (file_exists($filepath)) {
                $srcFile = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        // file not found in any2 config
        if (!$srcFile) {
            $pf = $config->isDefault() ? $config->getName() . ':' : '';
            throw new TemplateNotFoundException("View file '". $pf . $rfilepath ."' not found");
        }

        return $srcFile;
    }
}