<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Parser;
use DOMDocument;
use Component;
use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\DomHolder;

class Template
{
    public function load(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $start_time = microtime(true);
        $template = $this->get($rfilepath);
        $template->render($data);
        d(microtime(true) - $start_time);
    }

    public function get(string $rfilepath, array $data = [])
    {
        if (isset(Parsed::$templates[$rfilepath])) {
            return Parsed::template($rfilepath, $data);
        } else {
            $requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            $doc = new Document($requestName);
            if ($path = $doc->exists()) {
                
            } else {
                $parser = new Parser($doc, $rfilepath);
                $parser->parse();
                $path = $doc->save();
            }
            
            require_once($path);
            return Parsed::template($requestName, $data);
        }
    }
}
