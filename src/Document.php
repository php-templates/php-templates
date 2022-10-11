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
    
    public function __construct(string $inputFile, string $outputFolder, DependenciesMap $dependenciesMap, EventHolder $eventHolder) 
    {
        $this->inputFile = $inputFile;
        $this->outputFolder = $outputFolder;
        $this->dependenciesMap = $dependenciesMap;
        $this->eventHolder = $eventHolder;
    }
    
    public function getInputFile() {
        return $this->inputFile;
    }

    public function setContdufjjrrent(string $content) {
        $this->content = $content;
    }

    public function save(string $outFile = null)
    {
        if (!$outFile) {
            $outFile = $this->getDestFile();
        }

        file_put_contents($outFile, $this->getResult());
        $this->dependenciesMap->save();
        $eventHolder = $this->eventHolder;
d(finfo_file($outFile));
        $return = require($outFile);
        dd($tr);
    }
    
    public function getResult()
    {//$this->_bindVariablesToContext('$this->template("default:props/a", new Context([\'bar\' => $bar, \'true\' => $true, \'foo\' => \'$foo\']));');die();
        $tpl = '<?php ';
        $tpl .= PHP_EOL."namespace PhpTemplates;";
        $tpl .= PHP_EOL."use PhpTemplates\Template;";
        $tpl .= PHP_EOL."use PhpTemplates\TemplateRepository;";
        $tpl .= PHP_EOL."use PhpTemplates\Context;";
        $tpl .= PHP_EOL;
        $tpl .= '$tr = new TemplateRepository($eventHolder);';
        
        foreach ($this->templates as $t => $fn) {
            $this->templates[$t] = $this->bindVariablesToContext($fn);
        }
        
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
        
        if ($this->trackChanges) {// todo remove legacy line
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
    
    public function hasTemplate(string $name) 
    {
        return isset($this->templates[$name]);
    }
    
    public function addTemplate($name, $tpl) 
    {
        $this->templates[$name] = $tpl;
    }
    
    public function geuufjrjtRootNode() {
        return $this->rootNode;
    }
    
    public function setRoovfhhctNode($node) {
        $this->rootNode = $node;
    }
    
    
    
    private function bindVariablesToContext(string $string) 
    {
        //d($string);
        $preserve = [
            //'$this->' => '__r-' . uniqid(),
            //'Context $context' => '__r-' . uniqid(),
            'use ($context)' => '__r-' . uniqid(),
            'array $data' => '__r-' . uniqid(),
            '$context = $context->subcontext' => '__r-' . uniqid(),
        ];
        
        $string = str_replace(array_keys($preserve), $preserve, $string);
        $preserve = array_flip($preserve);
        
        $string = preg_replace_callback('/(?<!<)<\?php(.*?)\?>/s', function($m) {
            return '<?php ' . $this->_bindVariablesToContext($m[1]) . ' ?>';
        }, $string);        
     
        $string = str_replace(array_keys($preserve), $preserve, $string);
        
        return $string;
    }
    
    private function _bindVariablesToContext(string $string) 
    {
        // replace any \\ with neutral chars only to find unescaped quotes positions
        $tmp = str_replace('\\', '__', $string);
        preg_match_all('/(?<!\\\\)[`\'"]/', $tmp, $m, PREG_OFFSET_CAPTURE);
        $stringRanges = [];
        $stringRange = null;
        $last = array_key_last($m[0]);
        foreach ($m[0] ?? [] as $k => $m) {
            if ($stringRange && $stringRange['char'] == $m[0]) {
                $stringRange['end'] = $m[1];
                $stringRanges[] = $stringRange;
                $stringRange = null;
            }
            elseif (!$stringRange) {
                $stringRange['char'] = $m[0];
                $stringRange['start'] = $m[1];
            }
            elseif ($stringRange && $k == $last) {
                // todo throw error unclosed string
            }
        }
        
        $stringRange = null;
        // match all $ not inside of a string declaration, considering escapes
        $count = null;//d($stringRanges);
        $string = preg_replace_callback('/(?<!\\\\)\$([a-zA-Z0-9_]*)/', function($m) use (&$stringRange, &$stringRanges) {//d($m);
            if (empty($m[1][0]) || $m[1][0] == 'this' || $m[1][0] == 'context') {
                return '$' . $m[1][0];
            }
            $var = $m[1][0];
            $pos = $m[0][1];
            
            if ($stringRange && ($stringRange['start'] > $pos || $pos > $stringRange['end'])) {
                $stringRange = null;
            }
            if (!$stringRange) {
            while ($stringRanges) {
                if ($pos > $stringRanges[0]['end']) {
                    array_shift($stringRanges);
                }
                elseif ($stringRanges[0]['start'] < $pos && $pos < $stringRanges[0]['end']) {
                    $stringRange = array_shift($stringRanges);
                    break;
                }
                else {
                    // not yet your time
                    break;
                }
            }
            }
            //d('range is',$stringRange??'null');
            // check if is interpolation
            if (!$stringRange || $stringRange['char'] != "'") {
                return '$context->'.$var;
            } 
            return '$' . $var;
        }, $string, -1, $count, PREG_OFFSET_CAPTURE);
        //d($string);
        return $string;
    }
}
