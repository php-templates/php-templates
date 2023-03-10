<?php

namespace PhpTemplates;

use PhpTemplates\Source;
use PhpTemplates\Config;
use PhpTemplates\Cache\FileSystemCache;
use PhpTemplates\Cache\NullCache;

require_once(__DIR__.'/helpers.php');

/**
 * Main class
 */
class Template
{
    /**
     * User declared data composers for given template
     *
     * @var array
     */
    protected $composers = [];

    /**
     * Shared data across all templates
     *
     * @var Context
     */
    private $shared;

    /**
     * Output cache destination path. If null, NullCache will be used
     *
     * @var string
     */
    private $outputFolder;

    /**
     * Parsing Config - default config
     *
     * @var Config
     */
    private $config;

    /**
     * Events manager
     *
     * @var EventHolder
     */
    private $eventHolder;
    
    private $options;

    public function __construct(string $sourceFolder, string $outputFolder, array $options = [])
    {
        $this->outputFolder = $outputFolder;
        $config = new Config('default', $sourceFolder);
        $eventHolder = new EventHolder;
        $this->config = $config;
        $this->eventHolder = $eventHolder;
        $this->options = $options;
        
        $this->shared = new Shared();
    }

    /**
     * Render/echo the given template
     *
     * @param string $rfilepath - template name
     * @param array $data - array of key => value data to be bassed to view
     * @param array $slots - array of closures keyed by slot position
     * @return void
     */
    public function render(string $rfilepath, array $data = [], $slots = [])
    {
        $template = $this->make($rfilepath, $data, $slots);
        $template->render();
    }

    /**
     * Make a template object from raw string, or Source object
     *
     * @param string|Source $phpt
     * @param array $data
     * @param array $slots
     * @return void
     */
    public function makeRaw($phpt, array $data = [], array $slots = []): View
    {
        $config = $this->config;
        $file = '';
        if (is_string($phpt)) {
            $name = md5($phpt);
            $source = new Source($phpt, $name);
        }
        elseif ($phpt instanceof Source) {
            $source = (string)$phpt;
            $file = $phpt->getFile();
            $name = md5($phpt->getFile());
            $config = $config->getConfigFromPath($phpt->getFile());
        }
        else {
            throw new \Exception("Invalid argument supplied");
        }

        // init per process singlethon registry
        $registry = $this->newProcessRegistry();
        // paths will fallback on default Config in case of file not found or setting not found
        try {
            $class = $registry->cache->get($name); // try to load file, returns init class name
        } catch (\Throwable $e) {
            $class = null;
        }
        if (!empty($this->options['debug']) || !$class) {
            // parse start
            // aka $template = $registry->finder->find($name); // name, file, config
            $template = [
                'name' => $name,
                'file' => $file,
                'config' => $config
            ];
            $template += $registry->loader->loadSource($source); // returns new class and new TemplateClassBuilder
       
            //$node = $registry->dom->parse(new Source($template['code'], $template['file']));
            $tpl = $registry->parser->parse($template, $template['config']); // returns a string which will compose the render fn
            $template['class']->addMethod('render', $tpl);
           
            $registry->cache->add($template);
            $class = $registry->cache->write($name);
        }

        $view = new $class($registry, $data);

        return $view
            ->setSlots($slots);
    }

    /**
     * Obtain an instance of template to be manipulated
     *
     * @param string $rfilepath - template name
     * @param array $data - array of key => value data to be bassed to view
     * @param array $slots - array of closures keyed by slot position
     * @return View
     */
    public function make(string $name, array $data = [], $slots = []): View
    {
        // init per process singlethon registry
        $registry = $this->newProcessRegistry();
        // paths will fallback on default Config in case of file not found or setting not found
        try {
            $class = $registry->cache->get($name); // try to load file, returns init class name
        } catch (\Throwable $e) {
            $class = null;
        }
        if (!empty($this->options['debug']) || !$class) {
            // parse start
            $template = $registry->finder->find($name); // name, file, config
            $template += $registry->loader->load($template['file'], $template['name']); // returns new class and new TemplateClassBuilder
       
            //$node = $registry->dom->parse(new Source($template['code'], $template['file']));
            $tpl = $registry->parser->parse($template, $template['config']); // returns a string which will compose the render fn
            $template['class']->addMethod('render', $tpl);
           
            $registry->cache->add($template);
            $class = $registry->cache->write($name);
        }
        
        // $this->compose($name, $context);
        $view = new $class($registry, $data);

        return $view
            ->setSlots($slots);
    }

    /**
     * Share global data to all views
     *
     * @param string|array $key - can be an associative array
     * @param mixed $value
     * @return void
     */
    public function share($key, $value = null)
    {
        if (is_array($key)) {
            $data = $key;
        } else {
            $data[$key] = $value;
        }

        $this->shared->merge($data);
    }

    /**
     * Add event listener for given action
     *
     * @param string $ev - parsing, parsed or rendering
     * @param string $name - template name
     * @param Closure $cb - action, gaining node as param
     * @param integer $weight - order - higher weight = exected first
     * @return void
     */
    public function on(string $ev, $name, \Closure $cb, $weight = 0)
    {
        $this->eventHolder->on($ev, $name, $cb, $weight);
    }
    
    public function helper(string $name, \Closure $fn)
    {
        $this->config->helper($name, $fn);
    }

    /**
     * Define data builders for given template. When template gonna be rendered, thid callback will be called
     * The callback gains as argument a list of template node attributes
     *
     * @param string $name
     * @param \Closure $cb
     * @return void
     */
    public function composer(string $name, \Closure $cb)
    {
        $this->composers[$name][] = $cb;
    }

    /**
     * Return Config by key, or null. If no key given, default config is returned
     *
     * @param string|null $key
     * @return Config|null
     */
    public function getConfig(string $key = null): ?Config
    {
        if ($key) {
            return $this->config->find($key);
        }

        return $this->config;
    }

    /**
     * Create a subconfig derived from actual config, meaning it will fallback on this parent if template, directive, alias not found
     *
     * @param string $name
     * @param string $srcPath
     * @return Config
     */
    public function subconfig(string $name, string $srcPath): Config
    {
        return $this->config->subconfig($name, $srcPath);
    }

    /**
     * Register a directive - a way how a given syntax should be parsed
     *
     * @param string $key
     * @param \Closure $callable
     * @return void
     */
    public function setDirective(string $key, \Closure $callable): void
    {
        $this->config->setDirective($key, $callable);
    }

    /**
     * Register an alaias to a template to easily refer it in other templates. An key => value array is supported
     *
     * @param array|string $key
     * @param string $component
     * @return void
     */
    public function setAlias($key, string $component = ''): void
    {
        $this->config->setAlias($key, $component);
    }

    /**
     * Called from View, should not be called by user, use make() instead
     *
     * @param string $name
     * @param Context $context
     * @return View
     */
    public function get(string $name, Context $context): View
    {
        $this->compose($name, $context);

        return (new View($this, $name, $this->cache->get($name), $context));
    }

    public function getEventHolder()
    {
        return $this->eventHolder;
    }
// sus legacy
    protected function getCache()
    {
        if ($this->outputFolder) {
            $cache = new FileSystemCache($this->outputFolder);
        } else {
            $cache = new NullCache(); // future
        }

        return $cache;
    }

// legacy, move on view class
    protected function compose(string $name, $attrs = [])
    {
        if (empty($this->composers[$name])) {
            return [];
        }

        foreach ($this->composers[$name] as $cb) {
            $cb($attrs);
        }
    }
    
    private function newProcessRegistry() 
    {
        $registry = new Registry;
        
        // todo interface, setters
        $registry->config = $this->config;
        $registry->finder = new PHPTFinder($registry);
        $registry->loader = new PHPTLoader($registry);
        $registry->dom = new Dom\Parser();
        $registry->parser = new PHPTParser($registry);
        $registry->cache = new FileSystemCache($registry, $this->outputFolder);
        $registry->event = $this->eventHolder;
        $registry->shared = $this->shared;
        $registry->composers = $this->composers;
        
        return $registry;
    }
}
