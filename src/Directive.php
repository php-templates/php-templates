<?php

namespace PhpTemplates;

use Closure;

class Directive
{
    private static $all = [];

    public static function add(string $key, Closure $callable): void
    {
        self::$all[$key] = $callable;
    }

    public static function exists(string $key): bool
    {
        return isset(self::$all[$key]);
    }

    public static function run(string $key, string $value): array
    {
        if (!self::exists($key)) {
            return null;
        }

        $callable = self::$all[$key];

        return $callable($value);
    }
}