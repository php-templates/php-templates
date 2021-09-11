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
