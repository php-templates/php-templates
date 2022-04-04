<?php

namespace PhpTemplates;

use Closure;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;

class Process
{
    private $parent;
    private $config;

    private $templateFunctions = [];
    private $tobereplaced = [
        '="__empty__"' => '',
    ];
    private $eventListeners = [];

    public function __construct(string $name, Config $config, $parent = null)
    {
        $this->name = $name;
        $this->config = $config;
        $this->parent = $parent;
    }
    
    public function root()
    {
        $p = $this;
        while ($p->parent) {
            $p = $p->parent;
        }
        return $p;
    }

    public function hasTemplateFunction(string $key): bool
    {
        return isset($this->root()->templateFunctions[$key]);
    }

    public function addTemplateFunction(string $key, string $fnBody)
    {
        $this->root()->templateFunctions[$key] = $fnBody;
    }

    public function addEventListener(string $eventType, string $targetTplFn, $callbackFnBody)
    {
        $this->root()->eventListeners[$eventType][$targetTplFn][] = $callbackFnBody;
    }

    public function addDependencyFile($path)
    {
        DependenciesMap::add($this->root()->name, $path);
    }

    public function toBeReplaced($key, $val)
    {
        $this->root()->tobereplaced[$key] = $val;
    }

    public function config(string $key) 
    {
        if (isset($this->config->{$key})) {
            return $this->config->{$key};
        }
        return null;
    }

    public function getResult()
    {
        $tpl = '<?php ';
        $tpl .= PHP_EOL."use PhpTemplates\Parsed;";
        $tpl .= PHP_EOL."use PhpTemplates\DomEvent;";
        $tpl .= PHP_EOL."use PhpTemplates\Helper;";
        $tpl .= PHP_EOL;
        foreach ($this->templateFunctions as $name => $fn) {
            $tpl .= PHP_EOL."Parsed::\$templates['$name'] = $fn;";
        }
        foreach ($this->eventListeners as $ev => $listeners) {
            foreach ($listeners as $target => $cbcks) {
                foreach ($cbcks as $cb) {
                    $tpl .= PHP_EOL."new DomEvent('$ev', '$target', $cb);";
                }
            }
        }
        
        $tpl = str_replace(array_keys($this->tobereplaced), array_values($this->tobereplaced), $tpl);
        $tpl = preg_replace('/\?>[ \t\n\r]*<\?php/', '', $tpl);

        return $tpl;
    }
    
    public function __get($prop)
    {
        return $this->{$prop};
    }
}
