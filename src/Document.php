<?php

namespace PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;

class Document
{
    protected $name;

    public $templates = [];
    public $eventListeners = [];
    public $tobereplaced = [
        '="__empty__"' => '', 
        '&gt;' => '>',
        '&amp;\gt;' => '&gt;',
        '&lt;' => '<',
        '&amp;\lt;' => '&lt;',
        '&amp;' => '&',
        '&amp;\amp;' => '&amp;',
        /*'?&gt;' => '?>',
        '-&gt;' => '->',*/
    ];
    public $toberemoved = [];
    public $templateBlocks = [];
    
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
        $tpl .= "\nuse PhpTemplates\Parsed;";
        $tpl .= "\nuse PhpTemplates\DomEvent;";
        foreach ($this->templates as $name => $fn) {
            $tpl .= "\nParsed::\$templates['$name'] = $fn;";
        }
        foreach ($this->templateBlocks as $t => $block) {
            foreach ($block as $name => $fn) {
                $tpl .= "\nParsed::\$templateBlocks['$t']['$name'] = $fn;";
            }
        }
        foreach ($this->eventListeners as $ev => $listeners) {
            foreach ($listeners as $target => $cbcks) {
                foreach ($cbcks as $cb) {
                    $tpl .= "\nnew DomEvent('$ev', '$target', $cb);";
                }
            }
        }
        
        $tpl = str_replace(array_keys($this->tobereplaced), array_values($this->tobereplaced), $tpl);
        $tpl = preg_replace('/\?>[ \n\r]*<\?php/', '', $tpl);
        
        return $tpl;
    }
    
    public function save(string $outFile = null)
    {
        if (!$outFile) {
            $outFile = $this->getDestFile();
        }
        ///dd($outFile);
        file_put_contents($outFile, $this->render());
        DependenciesMap::save();
        
        return $outFile;
    }

    public function __get($prop) {
        return $this->$prop;
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
        $pf = Config::get('src_path');
        asort($dependencies);
        $hash = [$this->name];
        foreach ($dependencies as $f) {
            $file = $pf.$f.'.template.php';
            $hash[] = $f.':'.filemtime($file);
        }
        
        $pf = Config::get('dest_path');
        $name = str_replace('/', '_', $this->name);// todo
        $outFile = $pf.$name.'_'.substr(base_convert(md5(implode(';', $hash)), 16, 32), 0, 8);
    
        return $outFile.'.php';
    }
    
    public function registerDependency($name) 
    {
        DependenciesMap::add($this->name, $name);
    }
}