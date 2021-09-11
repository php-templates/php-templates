<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Parser;
/**
 * Template is main class, the entry point.
 * It will first gather recursively all slots scoped data.
 * Instantiate parser with options and call ->loadCached
 * parser will:
 * chen check dependencies times
 * Then will recursively compose slots hash
 * If sum of inputfile, filetime, hash is an existing file, it returns it.
 * else
 * load root file on parser and recursively do the following
 * create a root instance parser like new Parser(the four arguments as init)
 * call parse loadCached with self as arg first time
 * pass first instance root down to each parser, parser->loadCached(rootpparser)
 * in parse process steps are
 * check if file exists using step ln 10
 * add dynamic slots as dom tags
 * parse nodes
 * add result to rootParser
 * when a component/slot is encountered, repeat
 * call replaces and register functions (functions will be on root, last one will be called only on root)
 * return updated parser at the end
 */
class Template
{
    public $data = [];
    public $slots = [];
    
    public function load(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->data = $data;
        $this->slots = $slots;
        //$this->destFile = $this->getDestFile(); // based on req file, timestamp, slotsHash

        //$hasChanged = $this->options->track_changes && $this->syncDependencies($this->requestName);
        //if (!$hasChanged && file_exists($this->destFile)) {
            //$this->mountSlots($this);
            //return require($this->destFile);
        //}
        
        $this->parser = new Parser($rfilepath, $data, $slots, $options);
        $this->mountSlotsData($this);
        $this->parser->parse($this->parser);
        dd([
            'data' => $this->data,
            'components' => $this->parser->components,
            'functions' => $this->parser->functions,
            'result' => $this->parser->saveHtml()
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
    
    protected function mountSlotsData(Template $root)
    {
        foreach ($this->slots as $n => $slot) {
            $slots = is_array($slot) ? $slot : [$slot];
            foreach ($slots as $slot) {
                $slot->setName($n);
                $this->data[$slot->getUniqueName()] = $slot->data;
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
