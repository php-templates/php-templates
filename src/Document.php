<?php

namespace PhpTemplates;

use PhpTemplates\Config;
use PhpTemplates\DependenciesMap;

class Document
{
    private $rootNode;
    private $inputFile;
    private $outputFolder;
    private $dependenciesMap;
    private $requiredComponents = [];
    private $templates = [];
    
    public $trackChanges = true;
    
    public function __construct(string $inputFile, string $outputFolder, DependenciesMap $dependenciesMap) 
    {
        $this->inputFile = $inputFile;
        $this->outputFolder = $outputFolder;
        $this->dependenciesMap = $dependenciesMap;
    }
    
    public function getInputFile() {
        return $this->inputFile;
    }

    public function setContent(string $content) {
        $this->content = $content;
    }

    public function save(string $outFile = null)
    {
        if (!$outFile) {
            $outFile = $this->getDestFile();
        }

        file_put_contents($outFile, $this->getResult());
        $this->dependenciesMap->save();

        return $outFile;
    }
    
    public function getResult()
    {
        $tpl = '<?php ';
        $tpl .= PHP_EOL."namespace PhpTemplates;";
        $tpl .= PHP_EOL."use PhpTemplates\Template;";
        $tpl .= PHP_EOL."use PhpTemplates\TemplateRepository;";
        $tpl .= PHP_EOL;
        $tpl .= '$tr = new TemplateRepository();';
        //dd($this->templates);
        $callerTemplate = end($this->templates);
        $callerTemplateName = key($this->templates);
        unset($this->templates[$callerTemplateName]);
        foreach ($this->templates as $name => $fn) {
            $tpl .= PHP_EOL."\$tr->add('$name', $fn);";
        }
        $tpl .= PHP_EOL."return new Template(\$tr, '$callerTemplateName', $callerTemplate);";
        
        $tpl = preg_replace_callback('/\?>([ \t\n\r]*)<\?php/', function($m) {
            return $m[1];
        }, $tpl);
        
        $tpl = preg_replace('/[\n ]+ *\n+/', "\n", $tpl);

        return $tpl;
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
        $pf = rtrim($this->outputFolder, '/').'/';
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
    
    public function requireComponent(string $name)
    {
        $this->requiredComponents[] = $name;
    }
    
    public function getRequiredComponents()
    {
        return $this->requiredComponents;
    }
    
    public function addTemplate($name, $tpl) 
    {
        $this->templates[$name] = $tpl;
    }
    
    public function getRootNode() {
        return $this->rootNode;
    }
    
    public function setRootNode($node) {
        $this->rootNode = $node;
    }
}
