<?php

namespace PhpTemplates;

use PhpTemplates\Source;
use PhpTemplates\Contracts\Cache;
use PhpTemplates\View;
use PhpTemplates\ParsingTemplate;

class Document
{
    protected string $rootPath;
    protected string $name;
    protected string $file;
    protected array $templates = [];

    public function __construct(string $rootPath, string $name)
    {
        $this->rootPath = $rootPath;
        $this->name = $name;
        $this->file = $this->getfile($name);
    }

    public function load(): ?string
    {
        if (!file_exists($this->file)) {
            return null;
        }

        return static::require_once($this->file);
    }

    public function has(string $key): bool
    {
        return isset($this->templates[$key]);
    }

    public function add(string $key, \Closure $template): void
    {
        $this->templates[$key] = $template;
    }

    /**
     * Write ViewFactory class definition in a random namespace and returns the class name to be instantiated
     */
    public function write(): string
    {
        if (!is_dir($this->rootPath)) {
            mkdir($this->rootPath, 0777, true);
        } else {
            chmod($this->rootPath, 0777);
        }
        
        // this gonna call parsed events
        array_walk($this->templates, function(&$t) {
            if (is_callable($t)) {
                $t = $t();
            }
        });

        $nameToClassName = [];
        $dependencyMap = [];
        foreach ($this->templates as $template) {
            if ($file = $template->getFile()) {
                $dependencyMap[$file] = filemtime($template->getFile());
            }
            $nameToClassName[$template->getName()] = $template->getClassDefinition()->getFullName();
        }

        $viewClass = 'View_' . uniqid();

        $tpl = "<?php namespace {\n";
        
        // dependencies check
        $tpl .= "if (!\PhpTemplates\check_dependencies(". var_export($dependencyMap, true) .")) {\n\treturn false;\n}\n\n";

        // main view builder class (bootstrapper)
        $tpl .= "class {$viewClass} extends \\PhpTemplates\\View {\n";
        $tpl .= "\tprivate array \$templates = [\n";
        foreach ($nameToClassName as $name => $className) {
            $tpl .= "\t\t'$name' => {$className}::class,\n";
        }
        $tpl .= "\t];\n\n";
        $tpl .= "\tfinal public function make(string \$name, \$data) {\n";
        $tpl .= "\t\treturn parent::make(\$this->templates[\$name], \$data);\n";
        $tpl .= "\t}\n";
        $tpl .= "}\n";
        $tpl .= "}\n\n";     
 
        // each template class will extend above class to pass globally map between t.name and t.class name
        foreach ($this->templates as $t) {
            $tpl .= $t->getClassDefinition()->extends("\\{$viewClass}") . "\n\n";
        } 
        
        $tpl .= "namespace {\n\treturn {$viewClass}::class;\n}";
        
        file_put_contents($this->file, $tpl);
        
        return static::require_once($this->file);
    }

    protected function getFile(string $key)
    {
        $pf = rtrim($this->rootPath, '/ ') . '/';
        $hash = substr(base_convert(md5($key), 16, 32), 0, 12);
        $name = trim(str_replace(['/', ':'], '_', $key), '/ ') . '_' . $hash;

        return $pf . $name . '.php';
    }
    
    /**
     * Files are returning init class name only once
     */
    private static function require_once($file) 
    {
        static $required;
        
        $hash = md5(realpath($file));
        if (empty($required[$hash])) {
            $required[$hash] = require($file);
        }
        
        return $required[$hash];
    }
}
