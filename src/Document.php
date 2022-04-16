<?php

namespace PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;

class Document
{
    protected $name;
    protected $content = '';

    public function __construct(string $name, $content = '') {
        $this->name = $name;
        $this->content = $content;
    }

    public function setContent(string $content) {
        $this->content = $content;
    }

    public function save(string $outFile = null)
    {
        if (!$outFile) {
            $outFile = $this->getDestFile();
        }

        file_put_contents($outFile, $this->content);
        DependenciesMap::save();

        return $outFile;
    }

    public function exists()
    {
        $f = $this->getDestFile();
        if (file_exists($f)) {
            return $f;
        }
        return false;
    }

    protected function getDestFile()
    {
        $dependencies = DependenciesMap::get($this->name);

        asort($dependencies);
        $hash = [$this->name];
        foreach ($dependencies as $f) {
            $file = $f;
            $hash[] = $f.':'.@filemtime($file);
        }

        $pf = rtrim(Template::getConfig()->destPath, '/').'/';
        $name = str_replace(['/', ':'], '_', $this->name);// todo

        $outFile = $pf.$name.'_'.substr(base_convert(md5(implode(';', $hash)), 16, 32), 0, 8);

        return $outFile.'.php';
    }
}
