<?php

namespace PhpTemplates;

use Closure;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;
use PhpTemplates\Dom\DomNode;

class Process
{
    private $rootNode;
    /**
     * Name of the initiator file
     */
    private $name;
    /**
     * All configs keyed by namespace
     */
    private $configs;

    /**
     * current selected config
     */
    private $config;

    private $templateFunctions = [];

    public function __construct(string $rfilepath, array $configs)
    {
        $this->name = $rfilepath;
        $this->configs = $configs;
        $this->config = reset($configs);
    }

    public function withConfig(string $key, \Closure $cb)
    {
        if (!isset($this->configs[$key])) {
            throw new \Exception("Config key '$key' does not exists");
        }
        $oldKey = $this->config->name;
        $this->config = $this->configs[$key];
        $result = $cb($this);
        $this->config = $this->configs[$oldKey];

        return $result;
    }
    
    /**
     * Get component path from current config with fallback on default , or null
     *
     * @param string $alias
     * @return void
     */
    public function getAliased(string $alias)
    {
        //$alias == 'x-form-group' && $this->config->name == 'cases2' && dd($this->configs['cases2']->aliased);
        if ($this->config->name != 'default' && isset($this->config->aliased[$alias])) {
            return $this->config->name.':'.$this->config->aliased[$alias];
        }
        elseif (isset($this->configs['default']->aliased[$alias])) {
            return $this->configs['default']->aliased[$alias];
        }
        return null;
    }

    public function getDirective(string $name)
    {
        if (isset($this->config->directives[$name])) {
            return $this->config->directives[$name];
        }
        elseif (isset($this->configs['default']->directives[$name])) {
            return $this->configs['default']->directives[$name];
        }
        return null;
    }

    public function hasTemplateFunction(string $key): bool
    {
        return isset($this->templateFunctions[$key]);
    }

    public function addTemplateFunction(string $key, string $fnBody)
    {
        $this->templateFunctions[$key] = $fnBody;
    }

    public function addDependencyFile($path)
    {
        DependenciesMap::add($this->name, $path);
    }

    public function getResult()
    {
        $tpl = '<?php ';
        $tpl .= PHP_EOL."namespace PhpTemplates;";
        $tpl .= PHP_EOL."use PhpTemplates\Parsed;";
        $tpl .= PHP_EOL;
        foreach ($this->templateFunctions as $name => $fn) {
            $tpl .= PHP_EOL."Parsed::\$templates['$name'] = $fn;";
        }
        
        $tpl = preg_replace_callback('/\?>([ \t\n\r]*)<\?php/', function($m) {
            return $m[1];
        }, $tpl);
        
        $tpl = preg_replace('/[\n ]+ *\n+/', "\n", $tpl);

        return $tpl;
    }
    
    public function getRootNode() {
        return $this->rootNode;
    }
    
    public function setRootNode($node) {
        $this->rootNode = $node;
    }
    
    public function __get($prop)
    {
        return $this->{$prop};
    }
}
