<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Document;

/**
 * is actually component, but used in different contexts, even on root
*/
class Php extends AbstractEntity
{
    private static $started = false;

    /**
     * Start php string cross entities instances
     *
     * @return string
     */
    public static function start(): string
    {
        if (self::$started) {
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
        if (self::$started) {
            return '?>';
        }
        return '';
    }
}