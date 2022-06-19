<?php

namespace PhpTemplates;

use Closure;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;
use PhpTemplates\Dom\DomNode;

class Process
{
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
    }

    public function withConfig(string $key): self
    {
        $this->config = $this->configs[$key];

        return $this;
    }
    
    /**
     * return merged paths [current config, default]
     *
     * @return array
     */
    public function getSrcPaths(): array
    {
        $paths = [];

        if ($this->config->name != 'default') {
            $paths = (array)$this->config->srcPath;
        }

        $paths = array_merge($paths, (array)$this->configs['default']->srcPath);

        return $paths;
    }

    /**
     * Get component path from current config with fallback on default , or null
     *
     * @param string $alias
     * @return void
     */
    public function getAliased(string $alias)
    {
        if (isset($this->config->aliased[$alias])) {
            return $this->config->aliased[$alias];
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
    
    /**
     * Load the given route document using this.document settings with fallback on default settings
     * The process config will now be the new one of the given file prefix, so take care to preserve it before any load
     */
    public function load(string $name)
    {
        // obtaining config prefix pointing to settings collection then assign it to current process
        $path = array_filter(explode(':', $name));
        $cfgKey = count($path) > 1 ? $path[0] : 'default';
        $this->withConfig($cfgKey);

        // obtaining relative template file path and load it using config's src path
        $rfilepath = end($path);
        
        // obtaining the template file path using multi-config mode
        $srcFile = null;
        $tried = [];

        foreach ($this->getSrcPaths() as $srcPath) {
            $filepath = rtrim($srcPath, '/').'/'.$rfilepath.'.template.php';
            if (file_exists($filepath)) {
                $srcFile = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        if (!$srcFile) {
            $message = implode(' or ', $tried);
            throw new \Exception("Template file $message not found");
        }
        
        // add file as dependency to template for creating hash of states
        $this->addDependencyFile($srcFile);

        // geting file content (php function can be returned and executed in actual context)
        ob_start();
        $cb = require($srcFile);
        $html = ob_get_contents();
        ob_end_clean();

        $html = $this->removeHtmlComments($html);

        // obtaining the DomNode
        $node = DomNode::fromString($html, ['preservePatterns' => [
            '/(?<!<)<\?php(.*?)\?>/s',
            '/(?<!@)@php(.*?)@endphp/s',
            '/{{(((?!{{).)*)}}/',
            '/{\!\!(((?!{\!\!).)*)\!\!}/',
        ]]);

$x = preg_replace('/[\n\r\t\s]*|(="")*/', '', $node);
$y = preg_replace('/[\n\r\t\s]*|(="")*/', '', str_replace('=\'""\'', '=""""', $html));
$x = str_replace("'", '"', $x);
$y = str_replace("'", '"', $y);
 
if (0 && $x != $y) {
    d('nu se pupa '.$srcFile);
    //$node->querySelector('body')[0]->empty();
    //dd(''.$node);
    //d($node->debug());
    while ($x && $y && substr($x, 0, 300) == substr($y, 0, 300)) {
        $x = substr($x, 300);
        $y = substr($y, 300);
    }
    echo "\n$y\n$x"; die();
}
        
        return [$node, $cb];
    }
    
    protected function removeHtmlComments($content = '') {
    	return preg_replace('~<!--.+?-->~ms', '', $content);
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
        
        //$tpl = preg_replace('/[\n ]+ *\n+/', "\n", $tpl);

        return $tpl;
    }
    
    public function __get($prop)
    {
        return $this->{$prop};
    }
}
