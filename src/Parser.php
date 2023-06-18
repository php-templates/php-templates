<?php

namespace PhpTemplates;

use PhpTemplates\Contracts\EventDispatcher;
use PhpTemplates\Dom\WrapperNode;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Entities\SimpleNodeEntity;
use PhpTemplates\Entities\SlotEntity;
use PhpTemplates\Entities\TextNodeEntity;
use PhpTemplates\Entities\TemplateEntity;
use PhpTemplates\Entities\AnonymousEntity;
use PhpTemplates\Entities\Entity;
use PhpTemplates\Entities\ExtendEntity;
use PhpTemplates\Entities\VerbatimEntity;
use PhpDom\DomNode;

class Parser
{
    private EventDispatcher $event;
    private ?ParsedTemplate $parsed = null;

    public function __construct(EventDispatcher $event) 
    {
        $this->event = $event;
    }
    
    /**
     * Pass parser in each entity, at the end gather an array of every parsed template and its meta
     */
    public function parse(ParsingTemplate $template): ParsedTemplate
    {
        $node = $template->getDomNode();
        $config = $template->getConfig();
        $obj = $template->getObject();
        $classDefinition = (new PhpParser())->parse($template);
        
        // wrap node in case anyone wants to wrap node with another node using events
        $wrapper = new WrapperNode();
        $wrapper->appendChild($node);
        
        $this->event->trigger('parsing', $template->getName(), $wrapper, $classDefinition);
        method_exists($obj, 'parsing') && $obj->parsing($wrapper);
        foreach ($wrapper->getChildNodes() as $cnode) {
            $entity = new Entity($this, null, null, $config);
            $entity->child($cnode)->parse();
        }
        $this->event->trigger('parsed', $template->getName(), $wrapper, $classDefinition);
        method_exists($obj, 'parsed') && $obj->parsed($wrapper);
    
        # add render function
        $classDefinition->addMethod('template', (string)$node);

        # build a nested object to be passed to cache writer
        $this->parsed = new ParsedTemplate($template->getName(), $template->getConfig(), $classDefinition, $this->parsed);
        
        return $this->parsed;
    }
    
    # hasParsed(name): ?string
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