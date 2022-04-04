<?php

namespace PhpTemplates;

use PhpTemplates\Parser;
use DOMDocument;
use Component;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Context;
use PhpTemplates\Facades\DomHolder;

class Template
{
    /**
     * Default config
     */
    protected static $config = [];
    
    public function setConfig(string $key, Config $config)
    {
        self::$config[$key] = $config;
    }
    
    public function getConfig(string $key = 'default')
    {
        return isset(self::$config[$key]) ? self::$config[$key] : null;
    }
    
    public function load(string $rfilepath, array $data = [], $slots = [], $options = [])
    {
        $start_time = microtime(true);
        $template = $this->get($rfilepath, $data, $slots, $options);
        $template->render($data);
        print_r('<br>'.(microtime(true) - $start_time));
    }

    public function get(string $rfilepath, array $data = [], $slots = [], $options = [])
    {
        if (isset(Parsed::$templates[$rfilepath])) {
            return Parsed::template($rfilepath, $data);
        } else {
            $requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            // init the document with custom settings as src_path, aliases
            // paths will fallback on default Config in case of file not found or setting not found
            $doc = new Document($requestName, '');
            if ($path = $doc->exists() && 0) {} 
            else {
                $process = new Process($requestName, $options);
                (new TemplateFunction($process, $rfilepath))->parse();
                $doc->setContent($process->getResult());
                $path = $doc->save();
            }

            require_once($path);
            return Parsed::template($requestName, $data)->setSlots($slots);
        }
    }

    public function raw(\Closure $cb, $data = [])
    {
        return Parsed::raw(null, $cb, $data);
    }
}

Template::setConfig('default', new Config('src', 'dest'));
