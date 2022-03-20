<?php

namespace PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;

class Document
{
    protected $name;
    protected $config;

    public $templates = [];
    public $eventListeners = [];
    public $tobereplaced = [];
    public $toberemoved = [];
    public $templateBlocks = [];

    public function __construct(string $name, array $options = [])
    {
        $this->name = $name;
        $this->config = array_merge_recursive(Config::all(), $options);
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
        $tpl .= "\nuse PhpTemplates\Helper;";
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
        
        foreach ($this->tobereplaced as $t => $r) {
            $tpl = str_replace(array_keys($r), array_values($r), $tpl);
        }

        $tpl = preg_replace('/\?>[ \t\n\r]*<\?php/', '', $tpl);

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
        //$pf = trim(Config::get('src_path'), '/').'/';
        asort($dependencies);
        $hash = [$this->name];//dd($dependencies);
        foreach ($dependencies as $f) {
            $file = $f;//dd($file);
            $hash[] = $f.':'.@filemtime($file);
        }

        $pf = rtrim(Config::get('dest_path'), '/').'/';
        $name = str_replace('/', '_', $this->name);// todo
        //dd($pf, file_exists('/'.$pf) ? 1 : 0);
        $outFile = $pf.$name.'_'.substr(base_convert(md5(implode(';', $hash)), 16, 32), 0, 8);
//dd($outFile);
        return $outFile.'.php';
    }

    public function registerDependency($name)
    {
        DependenciesMap::add($this->name, $name);
    }
}
