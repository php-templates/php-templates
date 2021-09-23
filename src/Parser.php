<?php

namespace DomDocument\PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
//use DomDocument\PhpTemplates\Template;
//use DomDocument\PhpTeplates\Parsable;

class Parser
{
    protected $parent;
    protected $options;
    public $functions = [];
    public $attrs = [];
    public $components = [];
    public $replaces = [];
    private $toberemoved = [];
    
    private $x = false;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    /*
        $this->insertHtml(file_get_contents('views/debugnestedcomp.template.php'));
        
        foreach ($this->getElementsByTagName('body')->item(0)->childNodes as $n){
            foreach ($n->childNodes as $s)
            $this->saveHtml($s);
        }
        dd();
        */
        
        
        //$this->options = $this->mergeOptions($options)
    }

    public function parse(Parsable $root)
    {
        // get name unic in functie de hash sloturi
        if ($root->data && in_array($root->getName(), $this->functions)) {
            return //node cu string $root->getName()
        } 
        elseif (!$root->data && isset($this->components[$root->getName()])) {
            return $this->components[$root->getName()]->cloneNode(true);
        }
        
        $dom = $root->getDom();
        if ($dom->nodeName === '#text' && !trim($dom->textContent)) {
            //d($dom, $dom->parentNode);
            //return $dom->cloneNode(true);
        }
        $scope = null;
        if ($dom->nodeName !== '#document') {
            // izolam dom de orice alt context
            $scope = new HTML5DOMDocument;
            //$scope->loadHtml('<div></div>');
            //$_scope = $scope->createElement('div');//d($dom);
            $dom = $scope->importNode($dom->cloneNode(true), true);
            $scope->appendChild($dom);
            //d(123,$scope->saveHtml());
            $dom = $scope;
            //dom($dom);
        }
        /*
        echo 'parsing';
        dom($dom);
        echo 'with slots ';
        foreach ($root->slots as $slot) {
            foreach ($slot as $s) {
                dom($s->getDom());
            }
        }
        echo 'ssssssssss';*/
        //$this->addDynamicAttr();
        //$this->insertQuerySlots();
        //dif($this->x, '----');
    
        //foreach ($dom->childNodes ?? [] as $cnode) {//dif($this->x, $cnode);
            $this->parseNode($dom, $root);
        //}

        while ($this->toberemoved) {
            $node = array_pop($this->toberemoved);
                //echo 'removing'; dom($node);
            try {
                @$node->parentNode && @$node->parentNode->removeChild($node);
            } catch (\Exception $e) {}
        }
        echo 'parse done';
        
        if ($scope) {
            //echo 'scoped found';dom($dom);
            $dom = $dom->childNodes->item(0);
        }
        //d($dom->parentNode, $dom);
        dom($dom);
        $this->components[$root->getName()] = $dom;
        if ($root->data) {
            $this->functions[] = $root->getName();
            return function call cu data
        }
        $this->components[$root->getName()] = $dom->cloneNode(true);
        
        return $dom;
    }
    
    private function parseNode($node, Parsable $root)
    {//d($root->slots);
        if ($node->nodeName === 'slot') {
            $slotName = $node->getAttribute('name');
            if (!$slotName) {
                $slotName = 'default';
            }
            
            $slot = null;
            if (isset($root->slots[$slotName])) {
                $slot = $root->slots[$slotName];
            }
            $this->insertSlot($node, $slot);
            if (1&&!$root->nestLevel) {
                $this->toberemoved[] = $node;
            }
        } 
        elseif ($node->nodeName === 'component') {
            $this->insertComponent($node);
            if (1&&!$root->nestLevel) {
                $this->toberemoved[] = $node;
            }
        }
        
        foreach ($node->childNodes ?? [] as $_node) {//d($_node);
            $this->parseNode($_node, $root);
        }
        return $node;
    }
  
    private function insertSlot($node, $slots)
    {/*
        echo '
        slot
        ';
        dom($node);*/
        $slots = $slots ?? [];
        if (!$slots && $node->childNodes) {
            foreach ($node->childNodes as $cn) {
                $slots[] = new Parsable($cn);
            }
        }
        elseif (!is_iterable($slots)) {
            $slots = [$slots];
        }
        //d ($slot, $node, $slot === $node);// dd(123);
        foreach ($slots as $slot) {//d($slot->getDom());
            $slot = $this->parse($slot);
        echo 's insert '; 
            
            /*
            echo '
            slot parsed
            ';*/
            //foreach ($parsed as $_slot) {
                //dom($_slot);
                dom($slot);
                if (!$slot) {
                    continue;
                }//d($slot);
                $slot = @$node->ownerDocument->importNode($slot, true) ?? $slot;
                $node->parentNode->insertBefore($slot, $node);
            //}
        }
        echo 'before '; dom($node);
        
    }
    
    private function insertComponent($node)
    {/*
        echo '
        component
        ';
        dom($node);*/
        //$this->d($node->ownerDocument, [$node]);
        $rfilepath = $node->getAttribute('src');
        $data = '';
        $attrs = [];
        // vor fi attr class, id, iar php-data= data scope, iar din attrs vor fi explodate alea pentru care se gaseste switch si se face cache unic in functie de hash de data switch 
        foreach ($node->attributes as $attr) {
            if ($attr->nodeName === 'src') {
                continue;
            }
            if ($attr->nodeName === 'data') {
                $data = $attr->nodeValue;
            } else {
                $attrs['attributes'][$attr->nodeName] = $attr->nodeValue;
            }
        }
        
        $slots = [];
        foreach ($node->childNodes as $slot) {
            $sname = 'default';
            $sdata = [];
            
            if (method_exists($slotNode, 'getAttribute')) {
                if ($s = trim($slotNode->getAttribute('slot'))) {
                    $sname = $s;
                }
                $sdata = $slotNode->getAttribute('data');
            }
            elseif ($slotNode->nodeName === '#text' && !trim($slotNode->wholeText)) {
                continue;
            }

            $slots[$sname][] = new Parsable($slot);
        }//d($attrs);
        
        $comp = $this->getComponent($rfilepath, $data, $slots, $attrs);
        //d($comp->item(0)->ownerDocument, $comp->item(0));
        $parsed = $this->parse($comp);
        if (!is_iterable($parsed)) {
            $parsed = [$parsed];
        }
//dom($parsed);
        //echo $node->ownerDocument->saveHtml();
        //$this->d($node->ownerDocument, $parsed);
        //$this->d($node->ownerDocument, [$node->parentNode]);
        //echo 'before';
        //$this->d($node->ownerDocument, [$node]);
        foreach ($parsed as $p) {
        echo 'c insert ';
            //echo 'inserting';
            //$this->d($node->ownerDocument, [$p]);
            $p = $node->ownerDocument->importNode($p, true);
            dom($p);
            $node->parentNode->insertBefore($p, $node);
        }
        echo 'before '; dom($node);
        echo 'resulting ';
        dom($node->parentNode);
        //d($node->parentNode);
        //echo 'result
        //';
        //$this->d($node->ownerDocument, [$node->parentNode]);
        //$this->toberemoved[] = $node;
    }
    
    private function getComponent(string $rfilepath, $data, array $slots = [], $options = []) // node list
    {
        $requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
        //dd($requestName, $rfilepath);
        $f = $this->options['src_path'];
        $srcFile = $f.$requestName.'.template.php';
        return new Parsable($srcFile, $data, $slots, $options);
    }
    
    
    public function insertAfter($newNode, $ref)
    {
        if ($ref->nextSibling) {
            $ref->parentNode->insertBefore($newNode, $ref->nextSibling);
        } else {
            $ref->parentNode->appendChild($newNode);
        }
    }
    
    public function __get($prop)
    {
        return $this->$prop;
    }
}