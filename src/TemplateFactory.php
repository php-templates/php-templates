<?php

namespace PhpTemplates;

use PhpTemplates\Contracts\EventDispatcher;
use PhpTemplates\Contracts\Cache;
use PhpTemplates\Context\SharedContext;
use PhpTemplates\Source;
use PhpTemplates\Config;
use PhpTemplates\Cache\FileSystemCache;
use PhpTemplates\Cache\NullCache;

require_once(__DIR__.'/helpers.php');

/**
 * new TemplateFactory(...)->fromFile()->render()
 */
class TemplateFactory
{
    /**
     * User declared data composers for given template
     */
    private array $composers = [];

    /**
     * SharedContext data across all templates
     */
    private SharedContext $sharedContext;

    /**
     * Output cache destination path
     */
    private Cache $cache;

    /**
     * Parsing Config - default config
     */
    private Config $config;

    /**
     * Events manager
     */
    private EventDispatcher $event;
    
    /**
     * Parsing options
     */
    private array $options = [];

    public function __construct(string $sourceFolder, Cache $cache, EventDispatcher $event, array $options = [])
    {
        $this->config = new Config('default', $sourceFolder);
        $this->cache = $cache;
        $this->event = $event;
        $this->options = $options;
        $this->sharedContext = new SharedContext();
    }

    /**
     * Make a template object from raw string
     */
    public function fromRaw(string $code, array $data = [], array $slots = [], Config $config = null): Template
    {
        $config = $config ?? $this->config;
        $file = '';
        $name = md5($code);

        try {
            $viewFactory = $this->cache->get($name);
        } catch (\Throwable $e) {
            $viewFactory = null;
        }
        
        if (!empty($this->options['debug']) || !$viewFactory) {
            # parse start
            $parsingTemplate = new ParsingTemplate($name, $file, $code, $config);
            $parser = $this->getParser();
            $parser->parse($parsingTemplate);
            
            $viewFactory = $this->cache->get($name);
        }

        return $viewFactory
        ->make($name, $data)
        ->setSlots($slots);
    }

    /**
     * Make a template object from full file path
     */
    public function fromFile(string $file, array $data = [], array $slots = [], Config $config = null): Template
    {
        // todo: obtain code
        
        try {
            $viewFactory = $this->cache->get($name);
        } catch (\Throwable $e) {
            $viewFactory = null;
        }
        
        if (!empty($this->options['debug']) || !$viewFactory) {
            # parse start
            $parsingTemplate = new ParsingTemplate($name, $file, $code, $config);
            $parser = $this->getParser();
            $parser->parse($parsingTemplate);
            
            $viewFactory = $this->cache->get($name);
        }

        return $viewFactory
        ->make($name, $data)
        ->setSlots($slots);
    }

    /**
     * Make template object from relative given path/template name
     */
    public function fromPath(string $name, array $data = [], array $slots = [], Config $config = null): View
    {
        try {
            $viewFactory = $this->cache->get($name);
        } catch (\Throwable $e) {
            $viewFactory = null;
        }
        
        if (!empty($this->options['debug']) || !$viewFactory) {
            # parse start
            $parsingTemplate = new ParsingTemplate($name, null, null, $config ?? $this->config);
            $parser = $this->getParser();
            $parsed = $parser->parse($parsingTemplate);
            $this->cache->remember($parsed);
            $viewFactory = $this->cache->get($name);
        }

        return $viewFactory
        ->make($name, $data)
        ->setSlots($slots);
    }
    
    /**
     * Setup new Parser instance
     */
     public function getParser(): Parser
     {
         $parser = new Parser($this->event);
         
         return $parser;
     }

    /**
     * Share global data to all views
     * Associative array sipported as first argument for multiple assigns
     * Callbacks supported as values for lazy load data on demand
     */
    public function share($key, $value = null)
    {// todo: shared handle closure
        if (is_array($key)) {
            $data = $key;
        } else {
            $data[$key] = $value;
        }

        $this->sharedContext->merge($data);
    }

    /**
     * Return Config by key, or null. If no key given, default config is returned
     */
    public function config(string $key = null): ?Config
    {
        if ($key) {
            return $this->config->find($key);
        }

        return $this->config;
    }

    public function event()
    {// todo: dequeue evemt
        return $this->event;
    }
}
