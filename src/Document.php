<?php

namespace PhpTemplates;

use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;

class Document
{
    private $inputFile;
    private $outputFolder;
    private $dependenciesMap;
    
    public $trackChanges = true;
    
    public function __construct(string $inputFile, string $outputFolder, DependenciesMap $dependenciesMap) 
    {
        $this->inputFile = $inputFile;
        $this->outputFolder = $outputFolder;
        $this->dependenciesMap = $dependenciesMap;
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
        $this->dependenciesMap->save();

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
        $name = str_replace(['/', ':'], '_', $this->inputFile);// todo more tests, more generalist
        
        if ($this->trackChanges) {
            $dependencies = $this->dependenciesMap->get($this->inputFile);
            asort($dependencies);
            $hash = [$this->inputFile];
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
