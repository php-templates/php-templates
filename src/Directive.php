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

    public static function run(string $key, string $value)
    {
        if (!self::exists($key)) {
            return null;
        }

        $callable = self::$all[$key];

        $callable($value);
    }
}

// Directive::add('bind', function($data) {
//     return 'foreach('.$data.' as $k=>$v) echo "$k=\"$v\" ";';
// });
Directive::add('raw', function($data) {
    return 'echo ('.$data.');';
});