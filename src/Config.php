<?php

namespace PhpTemplates;

use Exception;
use PhpDom\Contracts\DomNodeInterface as DomNode;
use PhpTemplates\Dom\PhpNode;
use PhpDom\Parser as HtmlParser;
//use PhpTemplates\Dom\DomNode;

class Config
{
    private static $reservedDirectiveNames = [
        'if', 
        'elseif', 
        'else', 
        'foreach', 
        'for', 
        'while',
        'checked',
        'selected',
        'disabled',
        'p-raw',
        'p-bind',
        'p-scope',
    ];
    
    /**
     * Parent config, if any
     *
     * @var self
     */
    private $parent;

    /**
     * Child configs
     *
     * @var array
     */
    private $childs = [];

    /**
     * Config unique identifier key
     *
     * @var string
     */
    private $name;

    /**
     * Where to search for the given template relative path (this path + relative path => absolute file path)
     *
     * @var array
     */
    private $srcPath;

    /**
     * key => value array containing alias => relative_path of templates
     *
     * @var array
     */
    public $aliased = [];

    /**
     * Config defined directives
     *
     * @var array
     */
    public $directives = [];
    public $customTags = [];
    
    private $helpers = [];

    public function __construct($name, $srcPath, self $parent = null)
    {
        $this->parent = $parent;
        $this->name = $name;
        $this->srcPath = (array) $srcPath;
        
        if (!$this->parent) {
            $this->addDefaultDirectives();
        }
    }

    /**
     * Create a subconfig derived from actual config, meaning it will fallback on this parent if template, directive, alias not found
     *
     * @param string $name
     * @param string $srcPath
     * @return self
     */
    public function subconfig(string $name, string $srcPath): self
    {
        $config = null;
        try {
            $config = $this->getRoot()->find($name);
        } catch(Exception $e) {}
        
        if ($config) {
            throw new Exception("A config with '$name' key already exists");
        }

        $cfg = new Config($name, $srcPath, $this);
        $this->childs[] = $cfg;

        return $cfg;
    }

    /**
     * Check if config is default
     *
     * @return boolean
     */
    public function isDefault(): bool
    {
        return !$this->parent;
    }

    /**
     * Find config by key in subconfigs, or itself if matched by key
     *
     * @param string $cfgkey
     * @return self
     */
    public function find(string $cfgkey): ?self
    {
        if ($this->name == $cfgkey || !$cfgkey) {
            return $this;
        }
        foreach ($this->childs as $child) {
            if ($cfg = $child->find($cfgkey)) {
                return $cfg;
            }
        }
        
        if (!$this->parent) {
            throw new Exception("Config not found: '$cfgkey'");
        }
        
        return null;
    }

    private function addDefaultDirectives()
    {
        $controlStructures = ['if', 'elseif', 'else', 'foreach', 'for', 'while'];

        foreach ($controlStructures as $statement) {
            $this->directives[$statement] = function (DomNode $node, string $args) use ($statement) {// todo proxynode
                if (in_array($statement, ['elseif', 'else'])) {
                    if (!$node->getPrevSibling() || !in_array($node->getPrevSibling()->getNodeName(), ['<?php if', '<?php elseif'])) {
                        throw new InvalidNodeException("Unespected control structure '$statement'", $node);
                    }
                }
                $phpnode = new PhpNode($args, $statement);
                $phpnode->insertBefore($node);
                $phpnode->appendChild($node->detach());
            };
        }

        $this->directives['checked'] = function (DomNode $node, string $val) {
            $node->setAttribute('p-raw', $val . ' ? "checked" : ""');
        };

        $this->directives['selected'] = function (DomNode $node, string $val) {
            $node->setAttribute('p-raw', $val . ' ? "selected=\"selected\"" : ""');
        };

        $this->directives['disabled'] = function (DomNode $node, string $val) {
            $node->setAttribute('p-raw', $val . ' ? "disabled" : ""');
        };
    }

    // =================================================== //
    // ===================== GETTERS ===================== //
    // =================================================== //

    public function getParent()
    {
        return $this->parent;
    }
    

    public function getChilds(): array
    {
        return $this->childs;
    }
    
    private function flatten(array &$payload, $config = null)
    {
        if (!$config) {
            $config = $this;
        }
        
        $payload[] = $config;
        foreach ($config->getChilds() as $child) {
            $this->flatten($payload, $child);
        }
    }
    
    public function getConfigFromPath(string $absolutePath): self
    {
        $configs = [];
        $this->flatten($configs, $this);
        $absolutePath = str_replace('\\', '/', $absolutePath);
        
        $result = '';
        foreach ($configs as $c) {
            $match = array_filter($c->getPath(), function($path) use ($absolutePath) {
                return strpos($absolutePath, str_replace('\\', '/', $path)) !== false;
            });
            if (!$match) {
                continue;
            }
            
            usort($match, function($a, $b) {
                return strlen($b) - strlen($a);
            });
            
            if (strlen(reset($match)) > strlen($result)) {
                $result = $c;
            }
        }
        $result = $result ? $result : $configs[0];
       
        return $result;
    }

    public function getRoot()
    {
        $cfg = $this;
        while ($cfg->getParent()) {
            $cfg = $this->getParent();
        }

        return $cfg;
    }

    public function getPath()
    {
        return $this->srcPath;
    }
    public function addPath(string $path)
    {
        $this->srcPath[] = $path;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAliased(string $name)
    {
        $cfg = $this;
        $domain = '';
        do {
            if (isset($cfg->aliased[$name])) {
                $domain = strpos($cfg->aliased[$name], ':') ? '' : $domain;
                return $domain.$cfg->aliased[$name];
            }
        } while (($cfg = $cfg->getParent()) && $domain = $cfg->getName() . ':');
    }

    public function getDirective(string $name)
    {
        $cfg = $this;
        do {
            if (isset($cfg->directives[$name])) {
                return $cfg->directives[$name];
            }
        } while ($cfg = $cfg->getParent());
    }


    // =================================================== //
    // ===================== GETTERS ===================== //
    // =================================================== //

    /**
     * Register a directive - a way how a given syntax should be parsed
     * //todo merge set get
     * @param string $key
     * @param \Closure $callable
     * @return void
     */
    public function setDirective(string $key, \Closure $callable): void
    {
        if (in_array($key, self::$reservedDirectiveNames)) {
            throw new \Exception("System directive '$key' cannot be overriden");
        }

        $this->directives[$key] = $callable;
    }

    /**
     * Register an alaias to a template to easily refer it in other templates. An key => value array is supported
     * //todo merge set get
     * @param array|string $key
     * @param string $component
     * @return void
     */
    public function setAlias($key, string $component = ''): void
    {
        if (!is_array($key)) {
            $aliased = [$key => $component];
        } else {
            $aliased = $key;
        }
        
        foreach ($aliased as $k => $val) {
            if (HtmlParser::isHtmlTag($k)) {
                throw new \Exception("Cannot declare alias because '$k' is a HTML tag name");
            }
            if (in_array($k, ['slot', 'tpl'])) {
                throw new \Exception("Cannot declare alias because '$k' is a reserved tag name");
            }
            
            $this->aliased[$k] = $val;
        }
    }

    public function setSrcPath($val)
    {
        $this->srcPath = (array) $val;
    }
//todo dangerous to keep
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function helper(string $name, \Closure $fn = null) 
    {
        if ($fn) {
            $this->helpers[$name] = $fn;
            return;
        }

        if (isset($this->helpers[$name])) {
            return $this->helpers[$name];
        }
        
        if ($this->parent) {
            return $this->parent->helper($name);
        }
        
        return null;
    }
    
    public function customTag(string $name, \Closure $fn) 
    {
        $this->helpers[$name] = $fn;
    }
}