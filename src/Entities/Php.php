<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Document;

/**
 * is actually component, but used in different contexts, even on root
*/
class Php extends AbstractEntity
{
    private static $started = false;
    public static $debug = 1;

    /**
     * Start php string cross entities instances
     *
     * @return string
     */
    public static function start(): string
    {
        if (self::$debug) debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $started = self::$started;
        self::$started = true;
        if ($started) {
            return '';
        }
        return '<?php';
    }

    /**
     * Ends php string cross entities instances
     *
     * @return string
     */
    public static function end(): string
    {
        if (self::$debug) debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $started = self::$started;
        self::$started = false;
        if ($started) {
            return '?>';
        }
        return '';
    }
}