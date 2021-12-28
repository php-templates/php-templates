<?php

namespace DomDocument\PhpTemplates\Facades;

class Config
{
    private function __construct() {}
    
    private static $data = [
        'prefix' => 'p-',// for flow control structures @if, @else
        'src_path' => 'views/',
        'dest_path' => 'parsed/',
        'track_changes' => true,// track dependencies changes
        'trim_html' => false,
    ];
    
    const allowedControlStructures = [
        'if', 'elseif', 'else', 'for', 'foreach', 'raw'
    ];
    
    const attrCumulative = [
        'class', 'id'
    ];
    
    const attrIf = [
        ''
    ];
    
    const attrDataBindEager = 'data';
    const attrIsComponent = 'is';
    
    public static function all()
    {
        return self::$data;
    }
    
    public static function set($key, $value = null)
    {
        if (is_array($key)) {// nu merge // todo
            self::$data = array_merge_recursive(self::$data, $key);
        } else {
            self::$data[$key] = $value;
        }
    }
    
    public static function get($key, $fback = null)
    {
        if (isset(self::$data[$key])) {
            return self::$data[$key];
        }
        return $fback;
    }

    public static function getComponentByAlias($name)
    {
        if (!isset(self::$data['aliased']) || !isset(self::$data['aliased'][$name])) {
            return null;
        }

        return self::$data['aliased'][$name];
    }
}