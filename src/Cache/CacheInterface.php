<?php

namespace PhpTemplates\Cache;

use PhpTemplates\Source;

interface CacheInterface
{
    /**
     * Load cache store from given file-key
     *
     * @param string $key - relative file path, aka template name
     * @return boolean - returns false in case of cache expired
     */
    public function load(string $key): bool;

    /**
     * check if cache has template
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key): bool;

    /**
     * Set template to cache
     *
     * @param string $key
     * @param callable|null $fn - null when cache is loaded from file
     * @param Source|null $source - when cache is built from parse
     * @return void
     */
    public function set(string $key, callable $fn, Source $source = null): void;

    /**
     * returns cached template function
     *
     * @param string $key
     * @return callable
     */
    public function get(string $key): callable;

    /**
     * Burn parse results to a given file
     *
     * @param string $key
     * @return void
     */
    public function write(string $key);
}
