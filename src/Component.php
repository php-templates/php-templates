<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Template;

class Component extends Template
{
    public static function getUpdatedAt(string $file)
    {
        return Template::getUpdatedAt($file);
    }
    
    private static $index = 0;
    public static function resetId()
    {
        self::$index = 0;
    }
    
    private $uid = 0;
    private $name;
    private $requestName;
    private $data;
    private $slots;
    
    public function __construct(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->uid = (self::$index++);
        
        $this->data = $data;
        $this->slots = $slots;
        $this->requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        $this->srcFile = $this->getSrcFile();

    }
    
    public function getId()
    {
        return $this->uid;
    }
    
    // mount the slot on specific dom
    public function mount(Template $root)
    {
        // montam datele pe Template::data
        $root->addData($this->getVariableName(), $this->data);
        // daca exista si un parser, cream si entries pe replaces, html string
        if (!$root->parser) {
            // my job is done;
            return;
        }
        // set data on dom root
        return $this->loadParsed($root);
    }
    
    private function loadParsed(Template $root)
    {
        $this->destFile = $this->getDestFile(); // based on req file, timestamp, slotsHash

        $hasChanged = $this->options->track_changes && $this->syncDependencies($this->requestName);
        if (!$hasChanged && file_exists($this->destFile)) {
            return require($this->destFile);
        }
        
        $this->parser = new Parser($this->srcFile, $this->data, $this->slots, (array) $this->options);
        $this->parser->parse($root);
    }
    
    private function getVariableName()
    {
        return $this->name . $this->uid;
    }
    
    public function getHash()
    {
        $hash = self::getUpdatedAt($this->getSrcFile()).$this->uid;
        foreach ($this->slots as $n => $slot) {
            $slots = is_array($slot) ? $slot : [$slot];
            foreach ($slots as $slot) {
                if ($slot instanceof self) {
                    $hash .= $n.$slot->getHash();
                } 
                else {
                    throw new Exception('Non component detected');
                }
            }
        }
    
        return substr(md5($hash, true), 0, 12);
    }
}