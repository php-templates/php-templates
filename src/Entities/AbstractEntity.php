<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Process;
use PhpTemplates\Attributes\AttributePack;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNodeValAttr;
use PhpTemplates\Dom\PhpNode;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\EntityFactory;

abstract class AbstractEntity implements EntityInterface
{
    const WEIGHT = 0;
    
    protected $factory;
    protected $config;
    protected $eventHolder;
    protected $cache;
   
    protected $id;

    /**
     * recursive parent context
     *
     * @var AbstractEntity $context
     */
    protected $context;

    /**
     * current DomNode
     *
     * @var DomNode $node
     */
    protected $node;

    /**
     * Found attributes on current node
     *
     * @var array $attrs
     */

    protected $attrs = [];
    
    /**
     * Used to not override above variables in case of multi-level nest, eg:
     * var1 = comp1
     * var2 = var1->addSlot(x);
     *
     * @var integer
     */
    protected $depth = 0;
    
    /**
     * prefix for special php blocks (p-if, p-for)
     *
     * @var string
     */
    protected $pf = 'p-';
    
    /**
     * Creating a new instance by giving the main process as param, the node and the context
     *
     * @param Process $process
     * @param string|DomNode $node string when is component, DomNode when is simple node
     * @param AbstractEntity $context
     */
    public function __construct(DomNode $node, Config $config, EntityInterface $context, CacheInterface $cache, EntityFactory $factory, EventHolder $eventHolder)
    {
        $this->node = $node;
        $this->config = $config;
        $this->context = $context;
        $this->cache = $cache;
        $this->factory = $factory;
        $this->eventHolder = $eventHolder;
        $this->id = uniqid();
    }
    
    abstract public function templateContext(); 
    abstract public function slotContext(); 
    abstract public function simpleNodeContext(); 
    abstract public function anonymousContext(); 
    
    /**
     * Wrap node inside control structures and returns the aggregated node datas as array (like :class and class under 1 single key named :class)
     *
     * @param [type] $node
     * @param callable $cb
     * @return array
     */
    protected function depleteNode($node): AttributePack
    {
        $attributePack = new AttributePack();
        // dispatch any existing directive
        while ($node->attributes->count()) {
            $attrs = $node->attributes;
            $node->removeAttributes();

            foreach ($attrs as $a) {
                $k = $a->nodeName;
                if (array_key_exists($k, $this->attrs)) {
                    $this->attrs[$k] = $a->nodeValue;
                    continue;
                }

                if (strpos($k, $this->pf) === 0) {
                    // check if is a directive and unpack its result as attributes
                    // todo don t allow directive with cstruct name
                    if ($directive = $this->config->getDirective(substr($k, strlen($this->pf)))) {
                        $directive($node, $a->nodeValue);
 
                        // directive unpacked his data, next attr!!!
                        continue;
                    }
                }

                $attributePack->add($a);
            }
        }
        return $attributePack;
    }

    /**
     * After the node has been depleted and has 0 attributes, proceed to populate it with parsed attributes
     *
     * @param DomNode|null $node when null, return the data attrs as array => case component($data=[])
     * @param array $data
     * @return mixed
     */
    protected function fillNodjdhfhde($node, array $data)
    {
        if (is_null($node)) {
            if (isset($data['_attrs'])) {
                $attrs = array_map(function($a) {
                    return $a->toArrayString();
                }, $data['_attrs']);
                unset($data['_attrs']);
                $attrs = "'_attrs' => [" . implode(', ', $attrs) . ']';
            } else {
                $attrs = '';
            }
            
            $data = array_map(function($a) {
                return $a->toArrayString();
            }, $data);
            if ($attrs) {
                $data[] = $attrs;
            }
            $data = '[' . implode(', ', $data) . ']';
            
            return $data;
        }
        foreach ($data as $attr) {
            $node->addAttribute($attr);
        }
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getAttrs() 
    {
        return $this->attrs;
    }
    
    public function getAttr(string $key) 
    {
        return $this->attrs[$key] ?? null;
    }
    
    public function parse() 
    {
        if ($this->context) {
            $fn = explode('\\', get_class($this->context));
            $fn = end($fn);
            $fn = str_replace('Entity', 'Context', lcfirst($fn));
        } 
        else {
            $fn = 'simpleNodeContext';
        }
        
        $this->resolve($this->cache, $this->eventHolder);
        
        return $this->{$fn}();
    }
    
    public function getConfig() 
    {
        return $this->config;
    }
    
    public function resolve(CacheInterface $document, EventHolder $eventHolder) {}

    protected function sanitizeTemplate(string $string) 
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
        
        $string = preg_replace_callback('/(?<!<)<\?php(.*?)\?>/s', function($m) {
            return '<?php ' . $this->_bindVariablesToContext($m[1]) . ' ?>';
        }, $string);        
     
        $string = str_replace(array_keys($preserve), $preserve, $string);

        $string = preg_replace_callback('/\?>([ \t\n\r]*)<\?php/', function($m) {
            return $m[1];
        }, $string);
        
        $string = preg_replace('/[\n ]+ *\n+/', "\n", $string);
        
        return $string;
    }
    
    private function _bindVariablesToContext(string $string) 
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

            if (!$stringRange || $stringRange['char'] != "'") {
                return '$context->'.$var;
            } 
            return '$' . $var;
        }, $string, -1, $count, PREG_OFFSET_CAPTURE);

        return $string;
    }    
    
    protected function buildTemplateFunction(DomNode $node) 
    {
        $fnDeclaration = 'function (Context $context) {' . PHP_EOL
        . '?> '. $node .' <?php' . PHP_EOL
        . '}';
        
        $fnDeclaration = $this->sanitizeTemplate($fnDeclaration);
        
        return $fnDeclaration;
    }    
    
}