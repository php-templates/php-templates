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
        //switches aici
        return self::domVariant($dom, $attrs);
        // caching and always returns a clone
    }
    
    public function switchesOf($rpath): array
    {
        if (!isset(self::$cached['switches'][$path])) {
            $dom = self::get($rpath);
            $switches = [];
            $switchNodes = $dom->getElementsByTagName('switch');dom($dom);d($switchNodes);
            foreach ($switchNodes as $node) {
                $of = $node->getAttribute('of');
                $switches[] = $of->nodeValue;
            }
            self::$cached['switches'][$path] = $switches;
        }
        return self::$cached['switches'][$path];
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
        $oName = array_intersect_key($attrs, array_flip($switches));
        d(123, $switches);
        $oName = implode('_', $oName);
        $name = str_replace(['/', '\\'], '_', $rpath);
        $name = preg_replace('/(?![a-zAZ0-9_]+)./', '', $name);
        $name = join('_', array_filter([$name, $hash, $oName]));
        d($rpath, $switches, $attrs, $oname, $name);
        return $name;
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
}