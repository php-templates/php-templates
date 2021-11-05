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
        return self::domVariant($dom, $attrs);
        // caching and always returns a clone
    }
    
    public function switchesOf($rpath): array
    {
        if (!isset(self::$cached['switches'][$rpath])) {
            if (!isset(self::$cached['doms'][$rpath])) {
                self::get($rpath);
            }
            $dom = self::$cached['doms'][$rpath];
            $switches = [];
            $switchNodes = $dom->getElementsByTagName('switch');//dom($dom);//
            foreach ($switchNodes as $node) {
                $of = $node->getAttribute('of');
                $switches[] = $of;
            }
            self::$cached['switches'][$rpath] = $switches;
        }
        return self::$cached['switches'][$rpath];
    }
    
    protected function domVariant($dom, $data)
    {
        $switches = [];
        $switchNodes = $dom->getElementsByTagName('switch');
        foreach ($switchNodes as $node) {
            $of = $node->getAttribute('of');// or default
            $switches[] = $of;
            $val = isset($data[$of]) ? $data[$of] : 'default';
            //d(123,$val,$data);
            foreach ($node->childNodes as $cn) {
                if (Helper::isEmptyNode($cn)) {
                    continue;
                }
                if ($cn->getAttribute('case') === $val) {
                    $cn->removeAttribute('case');
                    $node->parentNode->insertBefore($cn, $node);
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
        // d(123, $switches);
        $oName = http_build_query($oName);
        if ($oName) {
            $oName = substr(md5($oName), 0, 5);
        }
        $name = str_replace(['/', '\\'], '_', $rpath);
        $name = preg_replace('/(?![a-zAZ0-9_]+)./', '', $name);
        $name = join('_', array_filter([$name, $hash, $oName]));
        //d(123, $rpath, $switches, $attrs, $oName, $name);
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