<?php

namespace PhpTemplates;

use Closure;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;

class Process
{
    private $config = [];

    private $templateFunctions = [];
    private $tobereplaced = [
        '="__empty__"' => '',
    ];
    private $eventListeners = [];

    public function __construct(string $name, array $options = [])
    {
        $this->name = $name;
        $this->config = array_merge_recursive(Config::all(), $options);
    }

    public function hasTemplateFunction(string $key): bool
    {
        return isset($this->templateFunctions[$key]);
    }

    public function addTemplateFunction(string $key, string $fnBody)
    {
        $this->templateFunctions[$key] = $fnBody;
    }

    public function addEventListener(string $eventType, string $targetTplFn, $callbackFnBody)
    {
        $this->eventListeners[$eventType][$targetTplFn][] = $callbackFnBody;
    }

    public function addDependencyFile($path)
    {
        DependenciesMap::add($this->name, $path);
    }

    public function toBeReplaced($key, $val)
    {
        $this->tobereplaced[$key] = $val;
    }

    public function config(string $key) 
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
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
}
