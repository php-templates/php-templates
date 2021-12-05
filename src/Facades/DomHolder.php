<?php

namespace DomDocument\PhpTemplates\Facades;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;
use DomDocument\PhpTemplates\Helper;

class DomHolder
{
    private function __construct() {}
    
    private static $cached = [];
    
    public static function get($rpath, $attrs = [])
    {
        if (!isset(self::$cached['doms'][$rpath])) {
            $requestName = preg_replace('(\.template|\.php)', '', $rpath);
            $f = Config::get('src_path');
            $srcFile = $f.$requestName.'.template.php';
            $dom = new HTML5DOMDocument;//d($this->srcFile);
            $dom->formatOutput = true;
            $html = file_get_contents($srcFile);
            $html = self::removeHtmlComments($html);
            $dom->loadHtml($html);//d($srcFile, $html,  $dom->saveHtml());
            self::$cached['doms'][$rpath] = $dom;
        }
        //switches aici
        $dom = self::$cached['doms'][$rpath]->cloneNode(true);
        return $dom;
        // caching and always returns a clone
    }
    
    public static function getTemplateName($rpath, $attrs)
    {
        $hash = substr(md5($rpath), 0, 5);
        $name = str_replace(['/', '\\'], '_', $rpath);
        $name = preg_replace('/(?![a-zAZ0-9_]+)./', '', $name);
        $name = join('_', [$name, $hash]);
        //d(123, $rpath, $switches, $attrs, $oName, $name);
        return $name;
    }

    public function trimHtml($dom)
    {
        $body = $dom->getElementsByTagName('body')->item(0);
        // $body = $body ? $body : $dom;

        $content = '';
        foreach ($body->childNodes as $node)
        {
            $content.= $dom->saveHtml($node);
        }
        return $content;
    }
            
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }
}