<?php

namespace PhpTemplates;

/**
 * is actually component, but used in different contexts, even on root
*/
class PhpTag
{
    protected static $thread = '';
    protected static $threads = [];
    
    public static function setThread(string $name): void
    {
        self::$thread = $name;
    }
    
    public static function getThread(): string
    {
        return self::$thread;
    }
    
    public static function open(string $threadName): string
    {
        $php = '';
        if (empty(self::$threads[$threadName])) {
            self::$threads[$threadName] = true;
            $php = '<?php ;';
        }
        return $php;
    }
   
    public static function close(string $threadName): string
    {
        $php = '';
        if (!empty(self::$threads[$threadName])) {
            self::$threads[$threadName] = false;
            $php = ' ?>';
        }
        return $php;
    }
    
    public static function isOpen(string $threadName): string
    {
        return !empty(self::$threads[$threadName]);
    }
}