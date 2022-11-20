<?php

namespace PhpTemplates;

use Exception;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNodes\PhpNode;

class Config
{
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
        try {
            $config = $this->getRoot()->find($name);
            throw new Exception("A config with '$name' key already exists");
        } catch(Exception $e) {}

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
        if ($this->name == $cfgkey) {
            return $this;
        }
        foreach ($this->childs as $child) {
            if ($cfg = $child->find($cfgkey)) {
                return $cfg;
            }
        }

        throw new Exception("Config not found: '$cfgkey'");
    }

    private function addDefaultDirectives()
    {
        $cfg = $this;
        $controlStructures = ['if', 'elseif', 'else', 'for', 'foreach'];

        foreach ($controlStructures as $statement) {
            $this->directives[$statement] = function (DomNode $node, string $args) use ($statement) {
                if (in_array($statement, ['elseif', 'else'])) {
                    if (!$node->prevSibling || !in_array(str_replace('#php-', '', $node->prevSibling->nodeName), ['if', 'elseif'])) {
                        throw new InvalidNodeException("Unespected control structure '$statement'", $node);
                    }
                }
                $phpnode = new PhpNode($statement, $args);
                $phpnode->indentStart = $node->indentStart;
                $phpnode->indentEnd = $node->indentEnd;

                $node->parentNode->insertBefore($phpnode, $node);
                $phpnode->appendChild($node->detach());
            };
        }

        $cfg->setDirective('checked', function (DomNode $node, string $val) {
            $node->addAttribute('p-raw', $val . ' ? "checked" : ""');
        });

        $cfg->setDirective('selected', function (DomNode $node, string $val) {
            $node->addAttribute('p-raw', $val . ' ? "selected=\"selected\"" : ""');
        });

        $cfg->setDirective('disabled', function (DomNode $node, string $val) {
            $node->addAttribute('p-raw', $val . ' ? "disabled" : ""');
        });
    }

    // =================================================== //
    // ===================== GETTERS ===================== //
    // =================================================== //

    public function getParent()
    {
        return $this->parent;
    }
    
    public function getChilds()
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
        
        $result = null;
        $matchPath = null;
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
            
            if (strlen(reset($match)) > strlen($matchPath)) {
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
     *
     * @param string $key
     * @param \Closure $callable
     * @return void
     */
    public function setDirective(string $key, \Closure $callable): void
    {
        $reserved = ['raw', 'bind', 'if', 'elseif', 'else', 'for', 'foreach'];

        if (in_array($key, $reserved)) {
            throw new \Exception("System directive '$key' cannot be overriden");
        }

        $this->directives[$key] = $callable;
    }

    /**
     * Register an alaias to a template to easily refer it in other templates. An key => value array is supported
     *
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
        $this->aliased = array_merge($this->aliased, $aliased);
    }

    public function setSrcPath($val)
    {
        $this->srcPath = $val;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
