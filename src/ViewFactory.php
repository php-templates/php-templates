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

        //$requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        // init the document with custom settings as src_path, aliases
        // paths will fallback on default Config in case of file not found or setting not found
        //$doc = new Document($this->destPath, $requestName, '', $this->trackChanges && !$this->debugMode);
        if (!$this->cache->load($rfilepath)) {
            //todo source line pointing to caller line
            $source = new Source($phpt, '');
            $parser = new Parser();
            $node = $parser->parse($source);

            // parse it
            //$name = $document->getInputFile();
            $factory = new EntityFactory($this->cache, $this->config, $this->eventHolder);
            $entity = $factory->make($node, new StartupEntity($this->config, $rfilepath));
            $entity->parse();

            $this->cache->write($rfilepath);
        }

        //$repository = new TemplateRepository($cache, $this->eventHolder);
        $result = $this->get($rfilepath, new Context($data));

        return $result
            //->withData($data)
            //->withShared($this->shared)
            //->withComposers($this->composers)
            ->setSlots($slots);
    }


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

        //$repository = new TemplateRepository($cache, $this->eventHolder);
        $result = $this->get($rfilepath, new Context($data));

        return $result
            //->withShared($this->shared)
            //->withComposers($this->composers)
            ->setSlots($slots);
    }

    public function share($key, $value = null)
    {
        if (is_array($key)) {
            $data = $key;
        } else {
            $data[$key] = $value;
        }

        $this->shared = array_merge($this->shared, $data);
    }

    public function composer(string $name, \Closure $cb)
    {
        $this->composers[$name][] = $cb;
    }

    private function getCache()
    {
        if ($this->outputFolder) {
            $cache = new FileSystemCache($this->outputFolder);
        } else {
            $cache = new NullCache();
        }

        return $cache;
    }



    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getEventHttfolder(): Config
    {
        return $this->eventHolder;
    }

    // added
    public function sharbvge(array $data)
    {
        $this->shared = array_merge($this->shared, $data);
    }

    public function compoggfffsers(array $data)
    {
        $this->composers = array_merge($this->composers, $data);
    }

    public function getShggfchhared()
    {
        return $this->shared;
    }

    public function compose(string $name, $attrs = [])
    {
        if (empty($this->composers[$name])) {
            return [];
        }

        //$data = [];
        foreach ($this->composers[$name] as $cb) {
            $cb($attrs);
        }

        //  $this->composed = $data;

        //return $data;
    }

    public function add(string $name, Closure $fn)
    {
        $this->templates[$name] = $fn;
    }

    public function get(string $name, Context $context)
    {
        $context->merge($context->all(), $this->shared);
        $this->compose($name, $context);
        //$data = array_merge((array)$this->shared, $data);
        return (new Template($this, $name, $this->cache->get($name), $context));
        //->with($this->shared)
        //->with($this->compose($name, $context));
    }

    public function getEventHolder()
    {
        return $this->eventHolder;
    }

    public function on($ev, $name, $cb, $weight = 0)
    {
        $this->eventHolder->on($ev, $name, $cb, $weight);
    }
}
