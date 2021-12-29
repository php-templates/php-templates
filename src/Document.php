<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\Config;
//use DomDocument\PhpTemplates\Template;
//use DomDocument\PhpTeplates\Parsable;

class Document
{
    protected $name;

    public $templates = [];
    public $eventListeners = [];
    public $tobereplaced = ['="__empty__"' => ''];
    public $toberemoved = [];
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public function addEventListener($ev, $target, $cb)
    {
        $this->eventListeners[$ev][$target][] = $cb;
    }
    
    public function render(): string
    {
        $tpl = '<?php ';
        $tpl .= "\nuse DomDocument\PhpTemplates\Parsed;";
        $tpl .= "\nuse DomDocument\PhpTemplates\DomEvent;";
        foreach ($this->templates as $name => $fn) {
            $tpl .= "\nParsed::\$templates['$name'] = $fn;";
        }
        foreach ($this->eventListeners as $ev => $listeners) {
            foreach ($listeners as $target => $cbcks) {
                foreach ($cbcks as $cb) {
                    $tpl .= "\nnew DomEvent('$ev', '$target', $cb);";
                }
            }
        }
        $tpl .= "\nParsed::template('$this->name', [])->render(\$data);";
        $tpl .= ' ?>';
        
        return $tpl;
    }
    
    public function save(string $outFile)
    {
        file_put_contents($outFile, $this->render());
    }

    public function __get($prop) {
        return $this->$prop;
    }
}