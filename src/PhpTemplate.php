<?php

namespace HarmonyTools;

class PhpTemplates
{
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
        $this->rfilepath = $rfilepath;
        $this->fullpath = $this->src_path.$this->requestName.'.template.php';
        $this->timestamp = fileatime($this->fullpath);
        
        
    }
}