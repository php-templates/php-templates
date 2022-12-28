<?php

namespace PhpTemplates;

use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\Dom\Parser;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Entities\StartupEntity;

class Process
{
    protected $parent;
    
    protected $rfilepath;
    
    protected $srcFile;
    
    protected $cache;
    
    protected $config;
    
    protected $events;
    
    protected $data;
    
    protected $callback;
    
    protected $onDone = [];
    
    public function __construct($rfilepath, CacheInterface $cache, Config $config, EventHolder $events, self $parent = null) 
    {
        $this->data = $parent ? $parent->data : (object)[];
        $this->cache = $cache;
        $this->events = $events;
        $this->parent = $parent;
        $this->config = $config;
        
        if ($rfilepath instanceof Source) {
            $source = $rfilepath;
            $parser = new Parser();
            $this->node = $parser->parse($source);
            $this->rfilepath = $source->getFile();
            $this->srcFile = '';
            return;
        }
        
        if (strpos($rfilepath, ':')) {
            throw new \InvalidArgumentException("Process::__construct must receive a path with no hint and a config for that hint; received: $rfilepath");
        }
        
        $this->rfilepath = $rfilepath;
        $this->srcFile = $this->resolvePath($this->rfilepath);
        
        // add file as dependency to template for creating hash of states
        ob_start();
        $cb = require($this->srcFile);
        $source = ob_get_contents();
        ob_end_clean();

        $source = new Source($source, $this->srcFile);
        $parser = new Parser();
        
        $this->node = $parser->parse($source);
        $this->callback = is_callable($cb) ? \Closure::bind($cb, $this->node) : null;
    }
    
    public function getName(): string
    {
        if (!$this->config->isDefault()) {
            return $this->config->getName() . ':' . $this->rfilepath;
        } else {
            return $this->rfilepath;
        }        
    }
   
    public function __get($prop) {
        return $this->$prop;
    }
    
    public function subprocess($rfilepath, Config $config): self
    {
        return new self($rfilepath, $this->cache, $config, $this->events, $this);
    }
    
    public function run(): void
    {
        // we create a virtual dom to make impossible loosing actual node inside events (which would break the system)
        $wrapper = new DomNode('#root');
        $wrapper->appendChild($this->node->detach());
        
        // event before
        $this->events->trigger('parsing', $this->getName(), $this->node);
        // event before
        if ($this->callback) {
            ($this->callback)($this);
        }
        
        AbstractEntity::make($wrapper, new StartupEntity($this->config), $this)
        ->simpleNodeContext();
        
        $this->events->trigger('parsed', $this->getName(), $wrapper);

        $fnSrc = (string)$this->buildTemplateFunction($this->node);

        $fn = Closure::fromSource(new Source($fnSrc, $this->srcFile), 'namespace PhpTemplates;');

        $this->cache->set($this->getName(), $fn, new Source($fnSrc, $this->srcFile));
    }

    /**
     * Gain a relative path and test it against config paths with fallback on default config (in case)
     *
     * @param string $rfilepath
     * @param Config $config
     * @return string
     */
    private function resolvePath(string $rfilepath): string
    {
        $srcFile = null;
        // try to find file on current config, else try to load it from default config
        foreach ($this->config->getPath() as $srcPath) {
            $filepath = rtrim($srcPath, '/') . '/' . $rfilepath . '.t.php';
            if (file_exists($filepath)) {
                $srcFile = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        // file not found in any2 config
        if (!$srcFile) {
            throw new \Exception("View file '$rfilepath' not found");
        }

        return $srcFile;
    }
    
    /**
     * Returns template function string for a given DomNode
     *
     * @param DomNode $node
     * @return void
     */
    protected function buildTemplateFunction(DomNode $node): string
    {
        $fnDeclaration = 'function (Context $context) {' . PHP_EOL
            . '?> ' . $node . ' <?php' . PHP_EOL
            . '}';

        $fnDeclaration = (string)$this->sanitizeTemplate($fnDeclaration);

        return $fnDeclaration;
    }
    
    /**
     * Gain parse result function as input and transform each variable access into context->variable access
     *
     * @param string $string
     * @return void
     */
    protected function sanitizeTemplate(string $string): string
    {
        $preserve = [
            //'$this->' => '__r-' . uniqid(),
            //'Context $context' => '__r-' . uniqid(),
            'use ($context)' => '__r-' . uniqid(),
            'array $data' => '__r-' . uniqid(),
            '$context = $context->subcontext' => '__r-' . uniqid(),
        ];

        $string = str_replace(array_keys($preserve), $preserve, $string);
        $preserve = array_flip($preserve);

        $string = preg_replace_callback('/(?<!<)<\?php(.*?)\?>/s', function ($m) {
            return '<?php ' . $this->_bindVariablesToContext($m[1]) . ' ?>';
        }, $string);

        $string = str_replace(array_keys($preserve), $preserve, $string);

        $string = preg_replace_callback('/\?>([ \t\n\r]*)<\?php/', function ($m) {
            return $m[1];
        }, $string);

        $string = preg_replace('/[\n ]+ *\n+/', "\n", $string);

        return $string;
    }

    private function _bindVariablesToContext(string $string): string
    {
        // replace any \\ withneutral chars only to find unescaped quotes positions
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
            } elseif (!$stringRange) {
                $stringRange['char'] = $m[0];
                $stringRange['start'] = $m[1];
            } elseif ($stringRange && $k == $last) {
                // throw new Exception("Unclosed string found");
            }
        }

        $stringRange = null;
        // match all $ not inside of a string declaration, considering escapes
        $count = null; //d($stringRanges);
        $string = preg_replace_callback('/(?<!\\\\)\$([a-zA-Z0-9_]*)/', function ($m) use (&$stringRange, &$stringRanges) { //d($m);
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
                    } elseif ($stringRanges[0]['start'] < $pos && $pos < $stringRanges[0]['end']) {
                        $stringRange = array_shift($stringRanges);
                        break;
                    } else {
                        // not yet your time
                        break;
                    }
                }
            }

            if (!$stringRange || $stringRange['char'] != "'") {
                return '$context->' . $var;
            }
            return '$' . $var;
        }, $string, -1, $count, PREG_OFFSET_CAPTURE);

        return $string;
    }

    public function on($phase, $templ, callable $cb) {
        $this->events->on($phase, $templ, $cb);
    }
    
    public function getCache(): CacheInterface {
        return $this->cache;
    }
}