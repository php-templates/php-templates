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
        'if', 'elseif', 'else', 'for', 'foreach'
    ];
    
    const attrCumulative = [
        'class', 'id'
    ];
    
    const attrIf = [
        ''
    ];
    
    const attrDataBindEager = 'data';
    const attrIsComponent = 'is';
    
    public static function set($key, $value = null)
    {
        if (is_array($key)) {
            self::$data = array_merge_recursive(self::$data, $key);
        } else {
            self::$data[$key] = $value;
        }
    }
    
    public function get($key, $fback = null)
    {
        if (isset(self::$data[$key])) {
            return self::$data[$key];
        }
        return $fback;
    }
}