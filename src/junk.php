   // requestName => [requestName => filemtime, ...other components]
    protected static $dependencies = null;
    protected static $timestamps = []; // cache file $timestamps
    protected static function getUpdatedAt(string $file)
    {
        if (!isset(self::$timestamps[$file])) {
            self::$timestamps[$file] = filemtime($file);
        }
        return self::$timestamps[$file];
    }
    
    
            
        if (self::$dependencies === null) {
            self::$dependencies = require_once('dependencies_map.php');
        }

    
    protected function parseCached(Parser $root): string
    {
        // daca numele e deja pe root, si daca nu am comp, intorc nume
        $this->destFile = $this->getDestFile();
        
        //$hasChanged = $this->options->track_changes && $this->syncDependencies($this->requestName);
        //if (!$hasChanged && file_exists($this->destFile)) {
            //$this->mountSlots($this);
            //return require($this->destFile);
        //}
        //
        $this->parse($root);
        // le tratez pe toate la fel si vad apoi
        // set file content
        return $root;
    }
    
    public function addGlobalData(Template $root)
    {
        // montam datele pe Template::data daca exista
        $root->data[$this->getVariableName()] = $this->data;
    }
        // in this stage, we have a normalized template file to parse, data seted on globale
        // load src file
        // parse it
        // return it trimmed
        // if is root, mount don t, just return it
        
        
        // parse this file, and foreach found slot call load m
        // foreach if tag name slot check in slots
        // slot will be a string as result of load with o to return string
        // if slot has data, replace slot with closure function if slot has slots, f will be unique, k => val
        // if slot has no data, replace slot with uname and k val global
        //   foreach slots slots, call load



    public function setName($name) {
        $this->name = $name;
    }
    
    public function setDom($dom) {
        $this->dom = $dom;
    }

    
    // based on this output, we decide if to recompile template
    protected function getDestFile()
    {
        if (!$this->destFile) {
            $f = str_replace('/', '_', $this->requestName);
            if ($this->options->track_changes) {
                $f .= '-'.self::getUpdatedAt($this->getSrcFile());
            }
            if ($slotsHash = $this->getHash()) {
                $f .= '-'.$slotsHash;
            }
            $this->destFile = $f;
        }
        return $this->destFile;
    }
    
    
    public function getHash()
    {
        $hash = filemtime($this->getSrcFile()).$this->uid;
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

    protected function mergeOptions($options)
    {
        // in this phase, we already have seted all dom global datas
        if (isset($options['prefix'])) {
            if (!trim($options['prefix'])) {
                unset($options['prefix']);
            }
        }
        $this->options = array_merge($this->options, $options);
    }
    
    
    public function getUniqueName()
    {
        return str_replace('-', '', $this->name) . $this->uid . '_';
    }