<?php

namespace PhpTemplates;

use PhpTemplates\Contracts\EventDispatcher;
use PhpTemplates\Contracts\Cache;
use PhpTemplates\Scopes\SharedScope;
use PhpTemplates\Source;
use PhpTemplates\Config;
use PhpTemplates\Cache\FileSystemCache;
use PhpTemplates\Cache\NullCache;
use PhpTemplates\View;
use PhpTemplates\Entities\StartupEntity;
use PhpTemplates\Document;
use PhpTemplates\Entities\TemplateEntity;
use PhpDom\DomNode;

require_once(__DIR__.'/helpers.php');

/**
 * new TemplateFactory(...)->fromFile()->render()
 */
class PhpTemplates
{
    /**
     * User declared data composers for given template
     */
    private array $composers = [];

    /**
     * SharedScope data across all templates
     */
    private SharedScope $shared;

    /**
     * Output cache destination path
     */
    private string $cachePath;

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

    public function __construct(string $sourcePath, string $cachePath, EventDispatcher $event, array $options = [])
    {
        $this->config = new Config('default', $sourcePath);
        if (isset($options['aliases']) && is_array($options['aliases'])) {
            $this->config->setAlias($options['aliases']);
            unset($options['aliases']);
        }
        
        $this->cachePath = $cachePath;
        $this->options = $options;
        $this->shared = new SharedScope();
        $this->event = $event;
        
        Event::boot($event);
    }

    /**
     * Make template object from relative given path/template name
     */
    public function fromPath(string $name, array $data = [], array $slots = [], Config $config = null): View
    {
        $file = new Document($this->cachePath, $name);
        try {
            $viewFactory = $file->load();
        } catch (\Throwable $e) {
            $viewFactory = null;
        }

        if (!empty($this->options['debug']) || !$viewFactory) {
            # parse start
            $parsingTemplate = new ParsingTemplate($name, null, null, $config ?? $this->config);
            (new StartupEntity($parsingTemplate, $file))->parse();
           
            $viewFactory = $file->write();
        }
        
        return $viewFactory::new([], $this->shared, $this->config, $this->event)
        ->make($name, $data)
        ->setSlots($slots);
    }

    /**
     * Make a template object from raw string
     */
    public function fromRaw(string $code, array $data = [], array $slots = [], Config $config = null): View
    {
        $config = $config ?? $this->config;
        $name = md5($code);

        $file = new Document($this->cachePath, $name);
        try {
            $viewFactory = $file->load();
        } catch (\Throwable $e) {
            $viewFactory = null;
        }

        if (!empty($this->options['debug']) || !$viewFactory) {
            # parse start
            $parsingTemplate = new ParsingTemplate($name, '', $code, $config ?? $this->config);
            (new StartupEntity($parsingTemplate, $file))->parse();
           
            $viewFactory = $file->write();
        }
        
        return $viewFactory::new([], $this->shared, $this->config, $this->event)
        ->make($name, $data)
        ->setSlots($slots);
    }
    

    /**
     * Make template object from file fullpath
     */
    public function fromFile(string $path, array $data = [], array $slots = [], Config $config = null, string $name = null): View
    {
        $name = $name ?? md5($path);
        $file = new Document($this->cachePath, $name);
        try {
            $viewFactory = $file->load();
        } catch (\Throwable $e) {
            $viewFactory = null;
        }

        if (!empty($this->options['debug']) || !$viewFactory) {
            # parse start
            $parsingTemplate = new ParsingTemplate($name, $path, null, $config ?? $this->config);
            (new StartupEntity($parsingTemplate, $file))->parse();
           
            $viewFactory = $file->write();
        }
        
        return $viewFactory::new([], $this->shared, $this->config, $this->event)
        ->make($name, $data)
        ->setSlots($slots);
    }
    
    public function make(string $name, array $data = [], array $slots = [], Config $config = null): View
    {
        return $this->fromPath($name, $data, $slots, $config);
    }

    /**
     * Share global data to all views
     * Associative array sipported as first argument for multiple assigns
     * Callbacks supported as values for lazy load data on demand
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
     * Return Config by key, or null. If no key given, default config is returned
     */
    public function getConfig(string $key = null): ?Config
    {
        return $this->config($key);
    }
    
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
