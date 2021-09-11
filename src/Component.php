<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Template;

class Component extends Template
{
    public static function getUpdatedAt(string $file)
    {
        return Template::getUpdatedAt($file);
    }
    
    public function __construct(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->uid = (self::$index++);
        $this->data = $data;
        $this->slots = $slots;
        $this->options = (object) $options;
        $this->requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        $this->srcFile = $this->getSrcFile();
    }
    
    public function getId()
    {
        return $this->uid;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    // mount the slot on specific dom
    
    public function loadParsed(Template $root): string
    {
        $this->destFile = $this->getDestFile(); // based on req file, timestamp, slotsHash

        $hasChanged = $this->options->track_changes && $this->syncDependencies($this->requestName);
        if (!$hasChanged && file_exists($this->destFile)) {
            //return require($this->destFile);
        }
        
        $this->parser = new Parser($this->srcFile, $this->data, $this->slots, (array) $this->options);
        $result = $this->parser->parse($root);
        $body = $result->getElementsByTagName('body')->item(0);
        $content = '';
        foreach ($body->childNodes as $node)
        $content.= $result->saveHtml($node);
        // save to file them
        if ($this->hasData) {
            $this->root->components[$name] = $content;
            // comp name vor fi mai asa foo_bar si nu au cum avea conflict
            return $this->name."($this->getVariableName())";
        } else {
            $root->replaces[$name] = $content;
            return $this->name;
        }
    }
    
    private function getVariableName()
    {
        return $this->name . $this->uid . '_';
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
    
    public function getSlots()
    {
        return $this->slots;
    }
    
    public function getData()
    {
        return $this->data;
    }
}