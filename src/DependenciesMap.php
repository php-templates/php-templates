<?php

namespace PhpTemplates;

class DependenciesMap
{
    private $file;
    private $map;
    
    public function __construct(string $file) 
    {
        $this->file = $file;
        $this->map = require_once($file);
    }
    
    public function add(string $doc, string $requestName)
    {
        if (!isset($this->map['files'][$doc]) || !in_array($requestName, $this->map['files'][$doc]))
        {
            $this->map['files'][$doc][] = $requestName;
        }
    }
    
    public function save()
    {
        file_put_contents($this->file, '<?php return '.var_export($this->map, true).';');
    }
    
    public function get(string $forFile)
    {
        if (isset($this->map['files'][$forFile])) {
            return $this->map['files'][$forFile];
        }
        return [];
    }
}