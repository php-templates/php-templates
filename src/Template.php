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
                $process = new Process($requestName, $this->config);
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
    
    public function addNamespace($name, $src)
    {
        $this->config[$name] = new Config($src, '');
    }
    
    public function setDestPath($dest)
    {
        $this->config['default']->setDestPath($dest);
    }
}

Template::setConfig('default', new Config('src', 'dest'));
