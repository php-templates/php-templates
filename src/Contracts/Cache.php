<?php

namespace PhpTemplates\Contracts;

use PhpTemplates\Source;
use PhpTemplates\Parsed\View;
use PhpTemplates\ParsedTemplate;

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
     * Write ViewFactory class definition in a random namespace and returns the class name to be instantiated
     */
    public function write(ParsedTemplate $template): string;
    //public function registerTemplate(string $key, Source $src): void;

    /**
     * returns cached template function
     */
    public function get(string $key): ?string;

    /**
     * Burn parse results to a given file
     */
    //public function write(string $key);
}
