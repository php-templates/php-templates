<?php

namespace PhpTemplates;

use Exception;
use PhpTemplates\Entities\StartupEntity;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Source;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Config;
use PhpTemplates\Dom\Parser;
use PhpTemplates\Cache\FileSystemCache;
use PhpTemplates\Cache\NullCache;

require_once(__DIR__.'/helpers.php');
// todo doc this
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
     * @var array
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

    public function __construct(?string $outputFolder, Config $config, EventHolder $eventHolder, array $options = [])
    {
        $this->outputFolder = $outputFolder;
        $this->config = $config;
        $this->eventHolder = $eventHolder;
        $this->options = $options;
        
        $this->shared = new Context();
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
        //$start_time = microtime(true);
        $template = $this->make($rfilepath, $data, $slots);
        $template->render();
        //print_r('<br>'.(microtime(true) - $start_time));
    }

    /**
     * Make a template object from raw string, or Source object
     *
     * @param string|Source $phpt
     * @param array $data
     * @param array $slots
     * @return void
     */
    public function makeRaw($phpt, array $data = [], array $slots = [])
    {
        $config = $this->config;
        if (is_string($phpt)) {
            $rfilepath = md5($phpt);
            $source = new Source($phpt, $rfilepath);
        }
        elseif ($phpt instanceof Source) {
            $source = (string)$phpt;
            $rfilepath = trim(str_replace([root_path(), '.t.php'], '', $phpt->getFile()), '/ ');dd($rfilepath);// todo
            $config = $this->getConfigFromPath($phpt->getFile());
        }
        else {
            throw new \Exception("Invalid argument supplied");
        }

        $this->cache = $this->getCache();

        // paths will fallback on default Config in case of file not found or setting not found
        if (!empty($this->options['debug']) || !$this->cache->load($rfilepath)) {
            // parse it
            $process = new Process($source, $this->cache, $this->config, $this->eventHolder); 
            $process->run();

            $this->cache->write($rfilepath);
        }

        $result = $this->get($rfilepath, $this->shared->subcontext($data));

        return $result
            ->setSlots($slots);
    }

    /**
     * Obtain an instance of template to be manipulated
     *
     * @param string $rfilepath - template name
     * @param array $data - array of key => value data to be bassed to view
     * @param array $slots - array of closures keyed by slot position
     * @return void
     */
    public function make(string $name, array $data = [], $slots = [])
    {
        $this->cache = $this->getCache();
        // init the document with custom settings as src_path, aliases
        // paths will fallback on default Config in case of file not found or setting not found
        if (!empty($this->options['debug']) || !$this->cache->load($name)) {
            // parse it
            list($rfilepath, $config) = parse_path($name, $this->config);
            $process = new Process($rfilepath, $this->cache, $config, $this->eventHolder);
            $process->run();

            $this->cache->write($name);
        }

        $result = $this->get($name, new Context($data));

        return $result
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
     * @return void
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
    
    protected function getPathRelative(string $absolutePath): string
    {
        
    }

    protected function getCache()
    {
        if ($this->outputFolder) {
            $cache = new FileSystemCache($this->outputFolder);
        } else {
            $cache = new NullCache();
        }

        return $cache;
    }

    protected function compose(string $name, $attrs = [])
    {
        if (empty($this->composers[$name])) {
            return [];
        }

        foreach ($this->composers[$name] as $cb) {
            $cb($attrs);
        }
    }
}
