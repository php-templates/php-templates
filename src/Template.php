<?php

namespace PhpTemplates;

use PhpTemplates\Parser;
use DOMDocument;
use Component;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Entities\Template as EntitiesTemplate;
use PhpTemplates\Facades\DomHolder;

class Template
{
    public function load(string $rfilepath, array $data = [])
    {
        $start_time = microtime(true);
        $template = $this->get($rfilepath);
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
            $doc = new Document($requestName, $options);
            if ($path = $doc->exists()) {

            } else {
                (new EntitiesTemplate($doc, $rfilepath))->newContext();
                $path = $doc->save();
            }

            require_once($path);
            return Parsed::template($requestName, $data);
        }
    }

    public function raw(\Closure $cb, $data = [])
    {
        return Parsed::raw(null, $cb, $data);
    }
}
