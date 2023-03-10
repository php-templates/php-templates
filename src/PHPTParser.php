<?php

namespace PhpTemplates;

use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Entities\SimpleNodeEntity;
use PhpTemplates\Entities\SlotEntity;
use PhpTemplates\Entities\TextNodeEntity;
use PhpTemplates\Entities\TemplateEntity;
use PhpTemplates\Entities\AnonymousEntity;
use PhpTemplates\Entities\ExtendEntity;
use PhpTemplates\Entities\VerbatimEntity;
use PhpTemplates\Dom\DomNode;

class PHPTParser
{
    private $registry;
    
    public function __construct($registry) {
        $this->registry = $registry;
    }
    
    public function parse($template, Config $config)
    {
        $this->registry->event->trigger('parsing', $template['name'], $template['node']);
        method_exists($template['object'], 'parsing') && $template['object']->parsing($template['node'], $this->registry);
        $this->make($template['node'], new Entities\StartupEntity($config))
        ->simpleNodeContext();
        $this->registry->event->trigger('parsed', $template['name'], $template['node']);
        method_exists($template['object'], 'parsed') && $template['object']->parsed($template['node'], $this->registry);
        
        $tpl = $this->bindVariablesToContext($template['node']);
        
        return $tpl;
    }
    
    public function make(DomNode $node, AbstractEntity $context)
    {
        $config = $context->getConfig();

        if ($node->nodeName == '#text') {
            return new TextNodeEntity($this->registry, $node, $context);
        }
        
        if ($node->nodeName == 'slot') {
            return new SlotEntity($this->registry, $node, $context);
        }
        
        if ($node->hasAttribute('verbatim')) {
            return new VerbatimEntity($this->registry, $node, $context);
        }
        
        if ($node->nodeName != 'tpl' && ($rfilepath = $config->getAliased($node->nodeName))) {
            $node->changeNode('tpl');
            if ($rfilepath[0] == '@') {
                $rfilepath = $config->getName() . ':' . ltrim($rfilepath, '@');
            }
            $node->setAttribute('is', $rfilepath);
        }
        
        if ($node->nodeName == 'tpl' && $node->hasAttribute('is')) {
            $rfilepath = $node->getAttribute('is');
            if ($rfilepath[0] == '@') {
                $rfilepath = $config->getName() . ':' . ltrim($rfilepath, '@');
                $node->setAttribute('is', $rfilepath);
            }            
            return new TemplateEntity($this->registry, $node, $context);
        }
        
        if ($node->nodeName == 'tpl' && $node->hasAttribute('extends')) {
            $rfilepath = $node->getAttribute('extends');
            if ($rfilepath[0] == '@') {
                $rfilepath = $config->getName() . ':' . ltrim($rfilepath, '@');
                $node->setAttribute('extends', $rfilepath);
            }       
            return new ExtendEntity($this->registry, $node, $context);
        }

        if ($node->nodeName == 'tpl') {
            return new AnonymousEntity($this->registry, $node, $context);
        }

        return new SimpleNodeEntity($this->registry, $node, $context);        
    }
    
    /**
     * Gain parse result function as input and transform each variable access into context->variable access
     *
     * @param string $string
     * @return void
     */
    protected function bindVariablesToContext(string $string): string
    {
        $preserve = [
            //'$this->' => '__r-' . uniqid(),
            //'Context $context' => '__r-' . uniqid(),
            //'use ($context)' => '__r-' . uniqid(),
            'array $data' => '__r-' . uniqid(),
            '$_comp' => '__r-' . uniqid(),
            //'$context = $context->subcontext' => '__r-' . uniqid(),
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
            if (empty($m[1][0]) || $m[1][0] == 'this') {
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
                return '$this->context->' . $var;
            }
            return '$' . $var;
        }, $string, -1, $count, PREG_OFFSET_CAPTURE);

        return $string;
    }
}