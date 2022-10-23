<?php

namespace PhpTemplates\Cache;

use PhpTemplates\View;
use PhpTemplates\EventHolder;
use PhpTemplates\Source;

class NullCache extends FileSystemCache implements CacheInterface
{
    public function __construct() {
        $this->storePath = sys_get_temp_dir();
    }

    public function load(string $key): bool
    {
        $this->store = $this->source = $this->dependencies = [];

        $file = $this->getFilePath($key);

        if (!file_exists($file)) {
            return false;
        }

        $cache = $this;
        if (($loaded = require($file)) === false) {
            return false;
        }

        return true;
    }

    public function write(string $key)
    {
        parent::write($key);

        $file = $this->getFilePath($key);
        if (file_exists($file)) {
            unlink($file);
        }
    }

    protected function getFilePath(string $key)
    {
        $pf = rtrim(sys_get_temp_dir(), '/ ').'/';
        $hash = substr(base_convert(md5($key), 16, 32), 0, 12);
        $name = trim(str_replace(['/', ':'], '_', $key), '/ ') . '_' . $hash;

        return $pf . $name . '.php';
    }
}
