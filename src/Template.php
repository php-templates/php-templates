<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Parser;
use DOMDocument;
use Component;
use IvoPetkov\HTML5DOMDocument;
use DomDocument\PhpTemplates\Facades\DomHolder;
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

        if (!isset($_GET['edit'])) {
            $doc = new Document($this->requestName);
            $parser = new Parser($doc, $rfilepath);
            $parser->parse();
            $doc->save('./parsed/test.php');
        }

        extract($data);
        include './parsed/test.php';

        return;

        
        $this->mountSlotsData($this->slots);
    }

    protected function getSrcFile()
    {return;
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
}
