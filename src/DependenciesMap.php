<?php

namespace DomDocument\PhpTemplates;

class DependenciesMap
{
    private function __construct() {}
    
    private static $map = null;
    
    public static function init()
    {
        if (self::$map === null && file_exists(__DIR__.'/dependencies_map.php')) {
            self::$map = require_once(__DIR__.'/dependencies_map.php');
        }
    }
    
    public static function add(string $doc, string $requestName)
    {
        if (!isset(self::$map['files'][$doc]) || !in_array($requestName, self::$map['files'][$doc]))
        {
            self::$map['files'][$doc][] = $requestName;
        }
    }
    
    public function save()
    {
        file_put_contents(__DIR__.'/dependencies_map.php', '<?php return '.var_export(self::$map, true).';');
    }
    
    public static function get(string $doc)
    {
        if (isset(self::$map['files'][$doc])) {
            return self::$map['files'][$doc];
        }
        return [];
    }
} 
DependenciesMap::init();