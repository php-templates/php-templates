<?php

namespace HarmonyTools;

class PhpTemplates
{
    // requestName => [requestName => filetime, ...other components]
    private static $dependencies = null;
    private static $timestamps = []; // cache file $timestamps
    
    public static function getUpdatedAt(string $file)
    {
        if (!isset(self::$timestamps[$file])) {
            self::$timestamps[$file] = filetime($file);
        }
        return self::$timestamps[$file];
    }
    
    private $options = [
        'prefix' => '@',
        'src_path' => 'views/',
        'dest_path' => 'parsed/'
    ];
    
    private $rfilepath = '';
    
    public function __construct(array $options = [])
    {
        if (self::$dependencies === null) {
            self::$dependencies = require_once('dependencies_map.php');
        }
        $this->mergeOptions($options);
    }
    
    private function mergeOptions($options)
    {
        if (isset($options['prefix'])) {
            if (!trim($options['prefix'])) {
                unset($options['prefix']);
            }
        }
        $this->options = (object) array_merge((array) $this->options, $options);
    }
    
    public function load(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        
        $this->srcFile = $this->getSrcFile();
        // $this->timestamp = fileatime($this->file);
        // $this->slotsHash = $this->getSlotsHash();
        $this->destFile = $this->getDestFile(); // based on req file, timestamp, slotsHash
        
        $hasChanged = $this->options->track_changes && $this->syncDependencies($this->requestName);
        if (!$hasChanged && file_exists($this->destFile) {
            return require($this->destFile;
        }
        
        new parser($cfg)->parse(file) intoarce str html
        replaces urile salvate pe o statica
        cand ajung la un comp, inlocuiesc nodul cu chemare funcie cf reqname.i
        ii trec ca sloturi nodurile si intorc cu load() optiune sa imi intoarca string si am ajuns aici
        save pe statica nume f => declarare function
        la fel si cand dau de sloturi daca sunt, daca nu, delete nodurile
        la final, trb doar sa fac replaceuri si output si sa curat staticele
    }
    
    private function getSrcFile()
    {
        if (!$this->srcFile) {
            $f = $this->options->src_path.$this->rfilepath;
            $this->srcFile = $f.$this->requestName.'.template.php';
        }
        return $this->srcFile;
    }
    
    // based on this output, we decide if to recompile template
    private function getDestFile()
    {
        if (!$this->destFile) {
            $f = str_replace('/', '_', $this->requestName);
            if ($this->options->track_changes) {
                $f .= '-'.self::getUpdatedAt($this->getSrcFile());
            }
            if ($slotsHash = $this->getSlotsHash()) {
                $f .= '-'.$slotsHash;
            }
            $this->destFile = $f;
        }
        return $this->destFile;
    }
    
    private function syncDependencies(string $reqName): bool
    {
        // ignoee self from list for avoíding infinite loop
        if (in_array($reqName, $this->checkedDependencies)) {
            return false;
        }
        $this->checkedDependencies[] = $reqName;
        
        $dependencies = self::$dependencies[$reqName] ?? [];
        $updated = false;
        foreach ($dependencies as $_reqName => $timestamp) {
            $nowstamp = fileatime($this->getSrcFile($_reqName));
            self::$dependencies[$reqName][$_reqName] = $nowstamp;
            $updated = $updated || $timestamp === $nowstamp;
            $updated = $updated || $this->syncDependencies($reqName);
        }
        return $updated;
    }
    
    private function getSlotsHash(): string
    {
        $hash = '';
        foreach ($slots as $slot) {
            if (is_string($slot)) {
                $hash .= md5($slot);
            } 
            elseif ($slot instanceof self) {
                $hash .= fileatime($slot->getSrcFile());
                $hash .= $slot->getSlotsHash();
            } 
            else {
                
            }
        }
        return substr(md5($string, true), 0, 12);
    }
    
    
}
