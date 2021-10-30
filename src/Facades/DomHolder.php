<?php

namespace DomDocument\PhpTemplates\Facades;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;

class DomHolder
{
    private function __construct() {}
    
    private static $cached = [];
    
    public static function get($rpath, $attrs = [])
    {
        $requestName = preg_replace('(\.template|\.php)', '', $rpath);
        $f = Config::get('src_path');
        $srcFile = $f.$requestName.'.template.php';
        $dom = new HTML5DOMDocument;//d($this->srcFile);
        $dom->formatOutput = true;
        $html = file_get_contents($srcFile);
        $html = self::removeHtmlComments($html);
        $dom->loadHtml($html);//d($srcFile, $html,  $dom->saveHtml());
        if (isset(self::$cached['switches'][$rpath]) && !count(self::$cached['switches'][$rpath])) {
            return $dom;
        }
        
        return self::domVariant($dom, $attrs);
        // caching and always returns a clone
    }
    
    public function trimHtml($dom)
    {
        $body = $dom->getElementsByTagName('body')->item(0);
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
    
    public function switchesOf($rpath): array
    {
        // caching
        return [];
    }
    
    protected function domVariant($dom, $data)
    {
        $switches = [];
        $switchNodes = $dom->getElementsByTagName('switch');
        foreach ($switchNodes as $node) {
            $of = $node->getAttribute('of');
            $switches[] = $of->nodeValue;
            if (isset($data[$of])) {
                $val = $data[$of];
                $variant = $node->querySelector('[case="'.$val.'"]');
                if ($variant) {
                    $variant->removeAttribute('case');
                    $node->parentNode->insertBefore($variant, $node);
                }
            }
            $node->parentNode->removeChild($node);
        }
        
        return $dom;
    }
    
    public static function getTemplateName($rpath, $attrs)
    {
        $switches = self::switchesOf($rpath);
        $hash = substr(md5($rpath), 0, 5);
        $oName = array_intersect($switches, array_keys($attrs));
        $oName = implode('_', $oName);
        $name = str_replace(['/', '\\'], '_', $rpath);
        $name = preg_replace('/(?![a-zAZ0-9_]+)./', '', $name);
        
        return join('_', array_filter([$name, $hash, $oName]));
    }
}