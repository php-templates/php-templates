<?php

namespace PhpTemplates\Contracts;

use PhpTemplates\Source;
use PhpTemplates\View;
use PhpTemplates\ParsingTemplate;

interface Cache
{
    /**
     * Load cache store from given file-key
     *
     * @param string $key - relative file path, aka template name
     * @return boolean - returns false in case of cache expired
     */
    // legacy public function load(string $key): bool;

    /**
     * check if cache has template
     */
    //public function has(string $key): ?array;

    /**
     * Set parsing template to cache
     */
    public function remember(ParsingTemplate $template): void;
    //public function registerTemplate(string $key, Source $src): void;

    /**
     * returns cached template function
     */
    public function get(string $key): ?View;

    /**
     * Burn parse results to a given file
     */
    //public function write(string $key);
}
