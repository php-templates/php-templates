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
        $r = self::$started ? '' : '<?php';
        if (self::$debug) {
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            var_dump($r);
        }
        self::$started = true;
        return $r;
    }
    /**
     * Ends php string cross entities instances
     *
     * @return string
     */
    public static function end(): string
    {
        $r = self::$started ? '?>' : '';
        if (self::$debug) {
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            var_dump($r);
        }
        self::$started = false;
        return $r;
    }
}