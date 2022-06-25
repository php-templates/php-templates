<?php

namespace PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;

class Document
{
    protected $destPath;
    protected $name;
    protected $content = '';
    protected $trackChanges = true;

    public function __construct(string $destPath, string $name, $content = '', $trackChanges = true) {
        $this->destPath = $destPath;
        $this->name = $name;
        $this->content = $content;
        $this->trackChanges = $trackChanges;
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
        $pf = rtrim($this->destPath, '/').'/';
        $name = str_replace(['/', ':'], '_', $this->name);// todo
        
        if ($this->trackChanges) {
            $dependencies = DependenciesMap::get($this->name);
            asort($dependencies);
            $hash = [$this->name];
            foreach ($dependencies as $f) {
                $file = $f;
                $hash[] = $f.':'.@filemtime($file);
            }
            $outFile = $pf.$name.'_'.substr(base_convert(md5(implode(';', $hash)), 16, 32), 0, 8);
        } else {
            $outFile = $pf.$name;
        }

        return $outFile.'.php';
    }
}
