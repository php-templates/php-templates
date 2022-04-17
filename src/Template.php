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
     * configs keyed by namespace
     */
    protected $configs = [];
    protected $destPath;
    
    public function __construct(string $srcPath, string $destPath) {
        $this->destPath = $destPath;
        $this->configs['default'] = [
            'src_path' => $srcPath
        ];
    }
    
    public function load(string $rfilepath, array $data = [], $slots = [])
    {
        $start_time = microtime(true);
        $template = $this->get($rfilepath, $data, $slots);
        $template->render($data);
        print_r('<br>'.(microtime(true) - $start_time));
    }

    public function get(string $rfilepath, array $data = [], $slots = [])
    {
        if (isset(Parsed::$templates[$rfilepath])) {
            return Parsed::template($rfilepath, $data);
        } else {
            $requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            // init the document with custom settings as src_path, aliases
            // paths will fallback on default Config in case of file not found or setting not found
            $doc = new Document($requestName);
            if ($path = $doc->exists() && 0) {} 
            else {
                $parser = new Parser($this->configs);
                $parser->parse($rfilepath);
                //(new TemplateFunction($process, $rfilepath))->parse();
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
    
    /**
     * Add additional parse src path
     */
    public function addPath($name, $src)
    {
        if (isset($this->configs[$name])) {
            throw new \Exception("Config '$name' already exists");
        }
        $this->configs[$name] = new Config($src);
    }
    
    public function addDirective(string $key, Closure $callable, $path = 'default'): void
    {
        if (!isset($this->configs[$key])) {
            throw new \Exception('Config path not found');
        } 
        elseif ($this->configs[$key]->hasDirective($key)) {
            throw new \Exception('Directive already exists');
        }
        $this->configs[$key]->addDirective($callable);
    }
    
    public function setDestPath($dest)
    {
        $this->$destPath = $dest;
    }
}

Template::setConfig('default', new Config('src', 'dest'));
