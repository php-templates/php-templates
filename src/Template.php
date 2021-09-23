<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Parser;
use DOMDocument;
use IvoPetkov\HTML5DOMDocument;
//use DomDocument\PhpTeplates\Parsable;

/**
 * Template is main class, the entry point.
 * It will decide when parse process is required. Each programatic slot is a Template instance with an inc ID
 * 
 * It will first gather recursively all slots scoped data.
 * Then check dependencies times
 * Then will recursively compose slots hash
 * If sum of inputfile, filetime, hash is an existing file, it returns it.
 * else
 * Template instances are parsers keepers ready to release them if any compile requires
 * create a root instance parser like new Parser(dom, slots, options)
 * where slots are -> foreach slot (template instance), instantiate a new parser calling root parser buildChildParser(dom, slots) and replaces the slot with it
 * template will cache all loaded doms
 * in parse process steps are
 * add dynamic slots as dom tags
 * parse nodes
 * add result to rootParser
 * when a component/slot is encountered, repeat
 * call replaces and register functions (functions will be on root, last one will be called only on root)
 * return updated parser at the end
 */
class Template
{
    protected static $index = 0;
    public static function resetId()
    {
        self::$index = 0;
    }
    
    public function __construct() {
        $this->uid = (self::$index++);
    }
    
    protected $options = [
        'prefix' => '@',
        'src_path' => 'views/',
        'dest_path' => 'parsed/',
        'track_changes' => true,
        'trim_html' => false
    ];
    
    // instance variables
    private $uid = 0;
    private $name;
    //protected $checkedDependencies = [];
    protected $requestName;
    protected $srcFile;
    protected $destFile;
    protected $slots = [];

    public function load(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->data = $data;
        $this->slots = $slots;
        $this->requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        $this->srcFile = $this->getSrcFile();
        //$this->destFile = $this->getDestFile(); // based on req file, timestamp, slotsHash

        //$hasChanged = $this->options->track_changes && $this->syncDependencies($this->requestName);
        //if (!$hasChanged && file_exists($this->destFile)) {
            //$this->mountSlots($this);
            //return require($this->destFile);
        //}
        

        //$dom = new HTML5DOMDocument;
        //$dom->registerNodeClass('DOMDocument', 'DomDocument\PhpTemplates\ExtendedDOMDocument');
        //$dom->registerNodeClass('HTML5DOMDocument', 'DomDocument\PhpTemplates\ExtendedDOMDocument');
        //$dom->loadHtml(file_get_contents($this->srcFile));
        //d($slots);
        $dom = new Parsable($this->srcFile, null, $slots, [], false);
        $this->parser = new Parser($this->options);
        //dd($this->parser->parse($dom, $this->slots));
        //dd($this->parser->parse($dom, $dom));
        //dd();
        //dd($this->parser->parse($dom));
        $dom = $this->parser->parse($dom);
        //$dom = $dom[0];
         // remove slots and components
        foreach ($dom->getElementsByTagName('slot') as $slot) {
            //$slot->parentNode->removeChild($slot);
        }
        $dom->formatOutput = true;
        echo $dom->saveHtml(); dd();
        $this->mountSlotsData($this->slots);
        //$this->parser->parse($this->parser);
        dd([
            'data' => $this->data,
            'components' => $this->parser->components,
            'functions' => $this->parser->functions,
            'replaces' => $this->parser->replaces,
            'result' => str_replace(['&lt;', '&gt;', '&amp;amp;lt;', '&amp;amp;gt;', '&amp;lt;', '&amp;gt;'],['<', '>', '<', '>', '<', '>'], $this->parser->saveHtml())
        ]);
        echo $this->parser->saveHtml();
        dd();
        $result = $this->makeReplaces();
        
        echo $result;
        
        dd(
            ///$this->components,
            //$this->replaces,
            //$this->parser->saveHtml()
        );
        //$this->getParsedHtml();

        // new parser($cfg)->parse(file) intoarce str html
        // replaces urile salvate pe o statica
        // cand ajung la un comp, inlocuiesc nodul cu chemare funcie cf reqname.i
        // ii trec ca sloturi nodurile si intorc cu load() optiune sa imi intoarca string si am ajuns aici
        // save pe statica nume f => declarare function
        // la fel si cand dau de sloturi daca sunt, daca nu, delete nodurile
        // la final, trb doar sa fac replaceuri si output si sa curat staticele
    }

    private function getParsedHtml() 
    {
        $parser->parse();
    }
    
    protected function getSrcFile()
    {
        if (!$this->srcFile) {
            $f = $this->options['src_path'];
            $this->srcFile = $f.$this->requestName.'.template.php';
        }
        return $this->srcFile;
    }
    
    
    protected function syncDependencies(string $reqName): bool
    {
        // ignoee self from list for avoíding infinite loop
        if (in_array($reqName, $this->checkedDependencies)) {
            return false;
        }
        $this->checkedDependencies[] = $reqName;
        
        $dependencies = self::$dependencies[$reqName] ?? [];
        $updated = false;
        foreach ($dependencies as $_reqName => $timestamp) {
            $nowstamp = filemtime($this->getSrcFile($_reqName));
            self::$dependencies[$reqName][$_reqName] = $nowstamp;
            $updated = $updated || $timestamp === $nowstamp;
            $updated = $updated || $this->syncDependencies($reqName);
        }
        return $updated;
    }
    
    private function getHash(): string
    {// if is qslot, add q, mode and (str hash/comp time)
        $hash = '';//self::getUpdatedAt($this->getSrcFile());
        foreach ($this->slots as $n => $slot) {
            $slots = is_array($slot) ? $slot : [$slot];
            foreach ($slots as $slot) {
                $hash .= $n.$slot->getHash();
            }
        }
        if (!$hash) {
            return '';
        }
        return substr(md5($hash, true), 0, 12);
    }
    
    protected function mountSlotsData($slots)
    {
        foreach ($slots as $n => $slot) {
            $slots = is_array($slot) ? $slot : [$slot];
            foreach ($slots as $slot) {
                $slot->setName($n);
                if ($slot->data) {
                    $this->data[$slot->getUniqueName()] = $slot->data;
                }
                $this->mountSlotsData($slot->slots);
            }
        }
    }
    
    public function getOptions()
    {
        return $this->options;
    }
    
    public function registerFunction($name, $body)
    {
        $this->components[$name] = "function {$name}(\$data) {
            extract(\$data);
            $content;
        }";
    }
    
    protected function makeReplaces()
    {
        $content = $this->parser->saveHtml();
        foreach ($this->replaces as $r) {
            if ($replace = $this->replaces[$r] ?? false) {
                $content = str_replace($r, $replace, $content);
            }
        }
        return $content;
    }
}
