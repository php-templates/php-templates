<?php

namespace PhpTemplates\Dom;

/*
.class	.intro	Selects all elements with class="intro"
.class1.class2	.name1.name2	Selects all elements with both name1 and name2 set within its class attribute
.class1 .class2	.name1 .name2	Selects all elements with name2 that is a descendant of an element with name1
#id	#firstname	Selects the element with id="firstname"
*	*	Selects all elements
element	p	Selects all <p> elements
element.class	p.intro	Selects all <p> elements with class="intro"
element element	div p	Selects all <p> elements inside <div> elements
element>element	div > p	Selects all <p> elements where the parent is a <div> element
element+element	div + p	Selects the first <p> element that is placed immediately after <div> elements
element1~element2	p ~ ul	Selects every <ul> element that is preceded by a <p> element
[attribute]	[target]	Selects all elements with a target attribute
*/

class QuerySelector
{
    private $node;
    
    public function __construct($node) {
        $this->node = $node;
    }
    
    public function find(string $selector, $many = true)
    {
        $modes = [
            '>',
            '+',
            '~',
        ];
        $selectors = array_filter(explode(' ', $selector));
        
        $nodes = [$this->node];
        while ($selectors && $nodes) {
            $s = array_shift($selectors);
            if (in_array($s, $modes)) {
                $mode = $s;
                $s = array_shift($selectors);
            } else {
                $mode = '';
            }
            $_nodes = [];
            foreach ($nodes as $node) {
                $_nodes = array_merge(
                    $_nodes,
                    $this->searchForNodes($node, $this->whatIsThis($s), $mode)
                );
                if (!$selectors && $_nodes && !$many) {
                    // if not querySelectorAll, return first occurrence
                    return $_nodes[0];
                }
            }
            $nodes = $_nodes;
        }
        
        if (!$nodes && !$many) {
            return null;
        }
        
        return $nodes;
    }
    
    private function whatIsThis($selector)
    {
        // preg match dupa node selectors
        // preg match dupa id selectors
        // preg match dupa class selectors
        // preg match dupa  selectors
        $is = [];
        $selector = preg_replace_callback('/\[([\w\d\-\$:@]+)=(((?!\]).)*)\]/', function($m) use (&$is) {
            $is[$m[1]][] = trim($m[2], '"\'');
            return '';
        }, $selector);
        preg_replace_callback('/([\.\#]*)(((?![\.#]).)*)/', function($m) use (&$is) {
            if ($m[1] == '.') {
                $is['class'][] = $m[2];
            }
            elseif ($m[1] == '#') {
                $is['id'][] = $m[2];
            }
            elseif ($m[2]) {
                $is['nodeName'] = $m[2];
            }
        }, $selector);
      
        return $is;
    }
    
    private function searchForNodes($node, $selector, $mode)
    {
        //no mode, search recursive in node, childNodes and collect matches
        //mode > it means that node was retrieved in a prev selector, test against node childnodes only
        //mode + test only against node next nextSibling
        // ~ test only against node siblings
        
        $found = [];
        if ($node->nodeName && $node->nodeName[0] == '#') {
            foreach ($node->childNodes as $cn) {
                $_found = $this->searchForNodes($cn, $selector, $mode);
                $found = array_merge($found, $_found);
            }
            return $found;
        }
    
        if (!$mode) {
            if ($this->nodeIsMatched($node, $selector)) {
                $found[] = $node;
            }
            foreach ($node->childNodes as $cn) {
                $_found = $this->searchForNodes($cn, $selector, $mode);
                $found = array_merge($found, $_found);
            }
            
            return $found;
        }
        elseif ($mode == '>') {
            foreach ($node->childNodes as $cn) {
                if ($this->nodeIsMatched($cn, $selector)) {
                    $found[] = $cn;
                }
            }
        }
        elseif ($mode == '+') {
            $next = $node->nextSibling;
            if ($next && $this->nodeIsMatched($next, $selector)) {
                $found[] = $next;
            }
        }
        elseif ($mode == '~') {
            foreach ($node->nextSiblings as $sn) {
                if ($this->nodeIsMatched($sn, $selector)) {
                    $found[] = $sn;
                }
            }
        }
        
        return $found;
    }
    
    private function nodeIsMatched($node, $selector)
    {
        if (isset($selector['nodeName']) && $selector['nodeName'] != '*' && $node->nodeName != $selector['nodeName']) {
            return false;
        }
        unset($selector['nodeName']);

        foreach ($selector as $attr => $values) {
            $node_attr = $node->getAttribute($attr);
            if (!$node_attr) {
                return false;
            }
            if ($node_attr == reset($values)) {
                return true;
            }
            $node_attr = array_filter(explode(' ', $node_attr));
            if (count(array_intersect($node_attr, $values)) != count($values)) {
                return false;
            }
        }
        
        return true;
    }
    
    public function __get($prop)
    {
        return $this->{$prop};
    }
}