<?php

namespace PhpTemplates;

use Exception;
use PhpTemplates\Entities\StartupEntity;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Source;
use PhpTemplates\Config;
use PhpTemplates\Dom\Parser;
use PhpTemplates\Cache\FileSystemCache;
use PhpTemplates\Cache\NullCache;

// todo: rename into template
class ViewFactory
{
    //todo forward usefull m calls to eventholder and config
    protected $composers = [];
    private $shared = [];
    private $outputFolder;
    private $config;
    private $eventHolder;

    public function __construct(?string $outputFolder, Config $config, EventHolder $eventHolder)
    {
        $this->outputFolder = $outputFolder;
        $this->config = $config;
        $this->eventHolder = $eventHolder;
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
    { // todo add support for src obj
        $start_time = microtime(true);
        $template = $this->make($rfilepath, $data, $slots);
        $template->render();
        // print_r('<br>'.(microtime(true) - $start_time));
    }

    public function makeRaw(string $phpt, $data = [], $slots = [])
    {
        $this->cache = $this->getCache();
        $rfilepath = md5($phpt);
        //todo format

        // paths will fallback on default Config in case of file not found or setting not found
        if (!$this->cache->load($rfilepath)) {
            //todo source line pointing to caller line
            $source = new Source($phpt, '');
            $parser = new Parser();
            $node = $parser->parse($source);

            // parse it
            $factory = new EntityFactory($this->cache, $this->config, $this->eventHolder);
            $entity = $factory->make($node, new StartupEntity($this->config, $rfilepath));
            $entity->parse();

            $this->cache->write($rfilepath);
        }

        $result = $this->get($rfilepath, new Context($data));

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
    public function make(string $rfilepath, array $data = [], $slots = [])
    {
        $this->cache = $this->getCache();
        // init the document with custom settings as src_path, aliases
        // paths will fallback on default Config in case of file not found or setting not found
        if (!$this->cache->load($rfilepath)) {
            // parse it
            $factory = new EntityFactory($this->cache, $this->config, $this->eventHolder);
            $entity = $factory->make(new DomNode('tpl', ['is' => $rfilepath]), new StartupEntity($this->config));
            $entity->parse();

            $this->cache->write($rfilepath);
        }

        $result = $this->get($rfilepath, new Context($data));

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

        $this->shared = array_merge($this->shared, $data);
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
    public function on(string $ev, string $name, \Closure $cb, $weight = 0)
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

    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * Called from Template, should not be called by user, use make() instead
     *
     * @param string $name
     * @param Context $context
     * @return void
     */
    public function get(string $name, Context $context): Template
    {
        $context->merge($context->all(), $this->shared);
        $this->compose($name, $context);

        return (new Template($this, $name, $this->cache->get($name), $context));
    }

    public function getEventHolder()
    {
        return $this->eventHolder;
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
