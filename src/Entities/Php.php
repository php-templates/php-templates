<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Document;

/**
 * is actually component, but used in different contexts, even on root
*/
class Php extends AbstractEntity
{
    private static $started = false;
    public static $debug = false;

    /**
     * Start php string cross entities instances
     *
     * @return string
     */
    public static function start(): string
    {
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
        $started = self::$started;
        self::$started = false;
        if ($started) {
            return '?>';
        }
        return '';
    }
}