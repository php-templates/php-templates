<?php

namespace DomDocument\PhpTemplates\Facades;

use DomDocument\PhpTemplates\Template as PhpTemplate;
use DomDocument\PhpTemplates\Parser;
use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Parsable;

class Template
{
    private function __construct() {}
    
    protected $options = [
        
    ];
    
    public static function getInstance(): PhpTemplate
    {
        return new PhpTemplate();
    }
    
    public static function __callStatic($name, $args)
    {
        return call_user_func_array([self::getInstance(), $name], $args);
    }
    
    public static function component(string $rfilepath, array $data = [], array $slots = [])
    {
        $options = (new PhpTemplate)->getOptions();
        $requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        $f = $options['src_path'];
        $srcFile = $f.$requestName.'.template.php';

        return new Parsable($srcFile, $data, $slots);
    }
}