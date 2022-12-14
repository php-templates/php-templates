<?php

namespace PhpTemplates\Cache;

use PhpTemplates\Source;

class FileSystemCache implements CacheInterface
{
    protected $storePath;
    protected $store = [];
    protected $source = [];

    public function __construct(string $storePath)
    {
        $this->storePath = $storePath;
    }

    public function load(string $key): bool
    {
        $this->store = $this->source = $this->dependencies = [];

        $file = $this->getFilePath($key);

        if (!file_exists($file)) {
            return false;
        }

        $cache = $this; // <- include it into require
        if (($loaded = require($file)) === false) {
            return false;
        }

        return true;
    }

    public function has(string $key): bool
    {
        return isset($this->store[$key]);
    }

    public function set(string $key, callable $fn = null, Source $source = null): void
    {
        $this->store[$key] = $fn;
        if ($source) {
            $this->source[$key] = (string) $source;
            $this->dependencies[] = $source->getFile();
        }
    }

    public function get(string $key): callable
    {
        return $this->store[$key];
    }

    public function write(string $key)
    {
        $path = $this->getFilePath($key);

        if (!is_dir($this->storePath)) {
            mkdir($this->storePath, 0777, true);
        } else {
            chmod($this->storePath, 0777);
        }

        $tpl = '<?php ';
        $tpl .= PHP_EOL . "namespace PhpTemplates;";
        $tpl .= PHP_EOL . "use PhpTemplates\View;";
        $tpl .= PHP_EOL . "use PhpTemplates\Cache\FileSystemCache;";
        $tpl .= PHP_EOL . "use PhpTemplates\Context;";
        $tpl .= PHP_EOL;

        $dependencies = [];
        foreach ($this->store as $source) {
            if ($source->getFile())
                $dependencies[$source->getFile()] = filemtime($source->getFile());
        }
        $tpl .= PHP_EOL . 'if (!check_dependencies(' . var_export($dependencies, true) . ')) { return false; }' . PHP_EOL;

        foreach ($this->source as $name => $fn) {
            $tpl .= PHP_EOL . "\$cache->set('$name', new Closure($fn));";
        }

        file_put_contents($path, $tpl);
        $this->load($key);
    }

    protected function getFilePath(string $key)
    {
        $pf = rtrim($this->storePath, '/ ') . '/';
        $hash = substr(base_convert(md5($key), 16, 32), 0, 12);
        $name = trim(str_replace(['/', ':'], '_', $key), '/ ') . '_' . $hash;

        return $pf . $name . '.php';
    }
}
