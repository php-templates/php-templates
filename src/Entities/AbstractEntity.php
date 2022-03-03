<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use IvoPetkov\HTML5DOMDocument;

abstract class AbstractEntity
{
    protected $trimHtml = false;
    protected $document;
    protected $context;
    protected $node;
    protected $caret;
    protected $attrs = [];
    // protected $controlStructures = [];
    protected $depth = 0;
    protected $thread;
    protected $pf = 'p-';
    
    public function __construct(Document $doc, $node, AbstractEntity $context = null)
    {
        $this->thread = Php::getThread();
        
        if ($context) {
            $ct_type = explode('\\', get_class($context));
            $ct_type = end($ct_type);
//d($ct_type);
            if (!in_array($ct_type, ['SimpleNode'])) {
                $this->depth = $context->depth +1;
            }
        }

        if (isset($this->document->config['prefix'])) {
            $this->pf = $this->document->config['prefix'];
        }

        $this->document = $doc;
        if (is_string($node)) {
            $node = $this->load($node);
        }
        $this->node = $node;
        if (method_exists($this->node, 'setAttribute')) {
        // $this->node->setAttribute('i', $this->depth);
        }
        $this->context = $context;
        $this->makeCaret();
        
        $this->shouldClosePhp = $this->shouldClosePhp();
    }
    
    //abstract public function rootContext();
    //abstract public function componentContext();
    //abstract public function slotContext();
   
    /**
     * Get root Entity in a nested context (first element in a nested structure)
     *
     * @return AbstractParser
     */
    public function getRoot(): AbstractEntity
    {
        if ($this->depth === 0) {
            return $this;
        }
        
        return $this->context->getRoot();
    }
    
    /**
     * Create a caret above the parsed node for future refering in print process to avoid deleting parsed structures
     *
     * @return void
     */
    protected function makeCaret($refNode = null)
    {
        $debugText = '';
        if (0
        ) {
            $debugText = explode('\\', get_class($this));
            $debugText = end($debugText).'.'.$this->depth;
        }
    
        if (!$this->node->parentNode) {
            //d($this->node->nodeName);
            // is hierarchical top
            return;
        }
        elseif ($this->depth < 1) {
//d($this->node->nodeName);
            $node = $this->node;
        }
        else {
            //d($this->context->depth, $this->depth);dom($this->node);
            $context = $this->context;
            while ($context->depth > 0) {
                $context = $context->context;
            }
            //dd($this->context->node, $this->context->depth);
            $node = $context->caret;
        }
        if ($refNode) {
            $node = $refNode;
        }
        
        $this->caret = $node->ownerDocument->createTextNode($debugText);
        $node->parentNode->insertBefore($this->caret, $node);
        //d($node, $debugText);
        //$this->document->toberemoved[$this->thread][] = $caret;
    }

    public function println(string $line, $end = false)
    {
        if ($end) {
            if ($this->caret->nextSibling) {
                $this->caret->parentNode->insertBefore(
                    $this->caret->ownerDocument->createTextNode(PHP_EOL.$line),
                    $this->caret->nextSibling
                );
            } else {
                $this->caret->parentNode->appendChild($this->caret->ownerDocument->createTextNode(PHP_EOL.$line));
            }
        } else {//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);dd($this->context);
        //d($line, $this->caret->nextSibling);
            $this->caret->parentNode->insertBefore(
                $this->caret->ownerDocument->createTextNode(PHP_EOL.$line),
                $this->caret
            );
        }
    }
    
    protected function depleteNode($node, callable $cb)
    {
        $c_structs = [];
        $data = [];
        $binds = [];
        $attrs = $node->attributes ? $node->attributes : [];
        foreach ($attrs as $a) {
            $k = $a->nodeName;
            if (strpos($k, $this->pf) === 0) {
                $k = substr($k, strlen($this->pf));
                if (in_array($k, Config::allowedControlStructures)) {
                    //$this->controlStructure($k, $a->nodeValue, $this->caret, $htmlContext && !$phpTagsInserted);
                    $c_structs[] = [$k, $a->nodeValue];
                    //$phpTagsInserted = true;
                    continue;
                }
                //todo validate simple node only, component not alowed
                elseif ($custom = $this->directive($k, $a->nodeValue)) {
                    $rid = '__r'.uniqid();
                    $this->document->tobereplaced[$rid] = $custom;//d($custom);
                    $data[$rid][] = '__empty__';
                    continue;
                    //$node->setAttribute($rid, '__empty__');
                }
            }
            $k = $a->nodeName;
       
            if (array_key_exists($k, $this->attrs)) {
                $this->attrs[$k] = $a->nodeValue;
            } 
            elseif ($k[0] === ':') {
                $binds[$k][] = $a->nodeValue;
            }
            else {
                $data[$k][] = $a->nodeValue;
            }
        }

        $attributes = $node->attributes;
        while ($attributes && $attributes->length) {
            $node->removeAttribute($attributes->item(0)->name);
        }
        
        foreach ($data as $k => $val) {
            $bk = ':'.$k;
            $bind = isset($binds[$bk]) ? $binds[$bk] : null;
            
            if ($bind) {
                $val = array_map(function($attr) {
                    return "'$attr'";
                }, $val);
                $val = array_merge($val, $bind);
                $val = 'Helper::mergeAttrs('.implode(',',$val).')';
                unset($binds[$bk]);
                unset($data[$k]);
                $data[$bk] = $val;
            } else {
                $data[$k] = implode(' ', $val);
            }
        }
        
        foreach ($binds as $bk => $bval) {
            $k = substr($bk, 1);
            if (count($bval) > 1) {
                $bval = 'Helper::mergeAttrs('.implode(',',$bval).')';
            } else {
                $bval = $bval[0];
            }
            $data[$bk] = $bval;
        }

        // imsert $c_structs
        if ($c_structs) {
            $this->phpOpen();
        }
        foreach ($c_structs as $struct) {
            list($statement, $args) = $struct;
            if ($args || $args === '0') {
                $statement .= " ($args)";
            }

            $this->println("$statement { ");
        }
        
        $cb($data, $c_structs, $node);

        // close all control structures
        $close = implode(PHP_EOL, array_fill(0, count($c_structs), '} '));
        /*
        if (count($c_structs) && $this->caret === $this->node) {
            if ($this->caret->nextSibling) {
                $this->caret->parentNode->insertBefore(
                    $this->caret->ownerDocument->createTextNode($close),
                    $this->caret->nextSibling
                );
            } else {
                $this->caret->parentNode->appendChild($this->caret->ownerDocument->createTextNode($close));
            }
        } */
        if (count($c_structs)) {
            $this->println($close);
        }
    }

    protected function fillNode($node, array $data) 
    {
        if (is_null($node)) {
            $_data = [];
            foreach ($data as $k => &$val) {
                if ($k[0] === ':') {
                    $k = substr($k, 1);
                } else {
                    $val = "'$val'";
                }
                $_data[$k] = $val;
            }
            return $_data;
        }
        
        if (!method_exists($node, 'setAttribute')) {
            return;
        }
        foreach ($data as $k => $val) {
            if ($k[0] === ':') {
                $k = substr($k, 1);
                $val = "<?php echo $val; ?>";
            }
            $node->setAttribute($k, $val);
        }
    }

    // protected function controlStructure($statement, $args, $node, $phpTags = false)
    // {
    //     $phpStart = $phpTags ? $this->phpOpen() : '';
    //     $phpEnd = $phpTags ? '' : '';

    //     if ($args || $args === '0') {
    //         $statement .= " ($args)";
    //     }

    //     $node->parentNode->insertBefore(
    //         $node->ownerDocument->createTextNode($phpStart." $statement { "),
    //         $node
    //     );

    //     if ($node->nextSibling) {
    //         $node->parentNode->insertBefore(
    //             $node->ownerDocument->createTextNode(" } ".$phpEnd),
    //             $node->nextSibling
    //         );
    //     } else {
    //         $node->parentNode->appendChild($node->ownerDocument->createTextNode(" } ".$phpEnd));
    //     }
    // }
    
    protected function directive($name, $val)
    {
        if (empty($this->document->config['directives'][$name])) {
            return false;
        }
        $directive = $this->document->config['directives'][$name];
        if (is_callable($directive)) {
            return $directive($val);
        }
        return $directive;
    }
    
    protected function childNodes($node = null)
    {
        Php::setThread($this->thread);
        if (!$node) {
            $node = $this->node;
        }
        $cnodes = [];
        if (!$node->childNodes) {
            return $cnodes;
        }
        foreach ($node->childNodes as $cn) {
            if (Helper::isEmptyNode($cn)) 
            continue;
            
            $cnodes[] = $cn;
        }
        
        return $cnodes;
    }

    protected function getNodeSlots($node, $forceDefault = false): array
    {
        $slots = [];
        if (!$node->childNodes) {
            return $slots;
        }

        // slots bound together using if else stmt should be keeped together
        $lastPos = null;
        foreach ($node->childNodes as $slotNode) {
            if (Helper::isEmptyNode($slotNode)) {
                continue;
            }

           $slotPosition = null;
           if ($slotNode->nodeName !== '#text') {
               $slotPosition = $slotNode->getAttribute('slot');
               $slotNode->removeAttribute('slot');
           }
            if ($forceDefault || !$slotPosition) {
                $slotPosition = 'default';
            }

            if ($slotNode->nodeName === '#text') {
                $slots[$slotPosition][] = $slotNode;
            }
            elseif (!$slotNode->hasAttribute('p-elseif') && !$slotNode->hasAttribute('p-else')) {
                // stands its own
                $container = new HTML5DOMDocument;
//        $container->preserveWhitespace = false;
     //   $container->formatOutput = true;
                $slotNode = $container->importNode($slotNode, true);
                $container->appendChild($slotNode);
                $slots[$slotPosition][] = $container;
                $lastPos = $slotPosition;
            } else {
                // has dependencies above
                if (isset($slots[$lastPos])) {
                    $i = count($slots[$lastPos]) -1;
                    $slotNode = $slots[$lastPos][$i]->importNode($slotNode, true);
                    $slots[$lastPos][$i]->appendChild($slotNode);
                }
            }
        }

        return $slots;
    }
    
    protected function parseNode($node)
    {
        $fn = explode('\\', get_class($this));
        $fn = end($fn);
        $fn = lcfirst($fn).'Context';
        if ($node->nodeName === 'slot') {
            (new Slot($this->document, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'block') {
            (new Block($this->document, $node, $this))->{$fn}();
        }
        elseif ($this->isComponent($node)) {
            (new Component($this->document, $node, $this))->{$fn}();
        }
        elseif ($node->nodeName === 'template') {
            dd('anonim comp');
            // (new AnonymousComponent($this->document))->mount($refNode);
        }
        else {
            (new SimpleNode($this->document, $node, $this))->{$fn}();
        }
    }
    
    /**
     * Load the given route document using this.document settings with fallback on default settings
     */
    public function load($rfilepath)
    {
        $srcpath1 = rtrim($this->document->config['src_path'], '/').'/'.$rfilepath.'.template.php';
        $srcpath2 = rtrim(Config::get('src_path'), '/').'/'.$rfilepath.'.template.php';
        if (file_exists($srcpath1)) {
            $srcFile = $srcpath1;
        }
        elseif ($srcpath2 !== $srcpath1 && file_exists($srcpath2)) {
            $srcFile = $srcpath2;
        } else {
            $message = implode(' or ', array_unique([$srcpath1, $srcpath2]));
            throw new \Exception("Template file $message not found");
        }
        
        $this->document->registerDependency($srcFile);
        $node = new HTML5DOMDocument;
        //$node->substituteEntities = false;
        //dd($node->preserveWhiteSpace ? 1 : 0);
        //$node->formatOutput = true;
        $html = file_get_contents($srcFile);
        $html = $this->escapeSpecialCharacters($html);
        $html = $this->removeHtmlComments($html);
        $this->trimHtml = strpos($html, '</body>') === false;
        $node->loadHtml($html);
        //d($html)
        return $node;
    }
    
    public function isComponent($node)
    {
        if (!@$node->nodeName) {
            return null;
        }
        if ($node->nodeName === 'template') {
            return $node->getAttribute('is');
        }
        
        // merged with default aliased
        $aliased = $this->document->config['aliased'];
        if (isset($aliased[$node->nodeName])) {
            return $aliased[$node->nodeName];
        }

        return null;
    }
    
    public function escapeSpecialCharacters($html) {
        return str_replace(['&lt;', '&gt;', '&amp;'], ['&\lt;', '&\gt;', '&\amp;'], $html);
    }

    public function trimHtml($dom)
    {
        $body = $dom->getElementsByTagName('body')->item(0);

        if (!$body) {
            return '';
        }

        $content = '';
        foreach ($body->childNodes as $node)
        {
            $content.= $dom->saveHtml($node).PHP_EOL;
        }
        return $content;
    }
    
    
    protected function getTemplateFunction(string $templateString, $html = true) {
        preg_match_all('/\$([a-zA-Z0-9_]+)/', $templateString, $m);
        $used = Helper::arrayToEval(array_values(array_unique($m[1])));//var_dump($used);die();
        $used = preg_replace('/\s*[\r\n]*\s*/', '', $used);
        if ($html) {
            $templateString = " ?> $templateString <?php ";
        }
        $fnDeclaration = 
        "function (\$data, \$slots) {
    extract(\$this->data); \$_attrs = array_diff_key(\$this->attrs, array_flip($used));
    $templateString
}";
        return $fnDeclaration;
    }
 
    public function removeHtmlComments($content = '') {//d($content);
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }
    
    protected function removeNode($node) {//d($node->nodeName);
        //$this->fillNode($node, ['removed' => 1]);
        $node->parentNode->removeChild($node);
    }
    
    protected function phpOpen($println = true) {
        $tag = Php::open($this->thread);
        if ($println && $tag) {
            $this->println($tag);
        }
        return $tag;
    }
    
    protected function phpClose($println = true) {
        $tag = Php::close($this->thread);
        if ($println && $tag) {
            $this->println($tag);
        }
        return $tag;
    }
    
    protected function phpIsOpen()
    {
        return Php::isOpen($this->thread);
    }
    
    protected function shouldClosePhp()
    {
        if ($this->depth) {
            return false;
        }
        elseif (($next = $this->nextSibling($this->node)) && $next->attributes) {
            foreach ($next->attributes as $a) {
                if (strpos($a->nodeName, $this->pf) === 0 && in_array(substr($a->nodeName, strlen($this->pf)), Config::allowedControlStructures)) {
                    return false;
                }
            }
        }
        
        return true;
    }

    protected function nextSibling($node)
    {
        $node = $node->nextSibling;
        while ($node && Helper::isEmptyNode($node)) {
            $node = $node->nextSibling;
        }
        return $node;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
}