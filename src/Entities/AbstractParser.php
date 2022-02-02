<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;

abstract class AbstractParser
{
    protected $context;
    protected $node;
    protected $caret;
    protected $reservedAttrs = [];
    
    public function __construct(Document $doc, $node, AbstractParser $context)
    {
        $this->document = $doc;
        $this->node = $node;
        $this->context = $context;
        $this->makeCaret();
    }
    
    abstract public function rootContext();
    abstract public function componentContext();
    abstract public function slotContext();
   
    /**
     * Get root Entity in a nested context (first element in a nested structure)
     *
     * @return AbstractParser
     */
    public function getRoot(): AbstractParser
    {
        if ($this->context) {
            return $this->context->getRoot();
        }
        return $this;
    }
    
    /**
     * Create a caret above the parsed node for future refering in print process to avoid deleting parsed structures
     *
     * @return void
     */
    protected function makeCaret()
    {
        $node = $this->getRoot()->node;
        $caret = $node->ownerDocument->createTextNode('caret');
        //$this->document->toberemoved[] = $caret;
        $node->parentNode->insertBefore($caret, $node);
    }

    protected function println(string $line)
    {
        $this->caret->parentNode->insertBefore(
            $this->caret->ownerDocument->createTextNode($line),
            $this->caret
        );
    }
    
    protected function depleteNode($node, $html = true)
    {
        $data = [];
        foreach ($node->attributes as $a) {
            $node->removeAttribute($a->nodeName);
            $k = $a->nodeName;
            if (strpos($k, $this->pf) === 0) {
                $k = substr($k, strlen($this->pf));
                if (in_array($k, Config::allowedControlStructures)) {
                    $this->controlStructure($k, $a->nodeValue, $this->caret, $html);
                    continue;
                }
            }
            $k = $a->nodeName;
            $val = $a->nodeValue;
            if ($k[0] === ':') {
                $k = substr($k, 1);
            } else {
                $val = "'$val'";
            }
            if (!in_array($k, $this->reservedAttrs)) {
                $data[$k][] = $val;
            }
        }
        
        foreach ($data as $k => $val) {
            if (count($val) > 1) {
                $data[$k] = 'Helper::mergeAttrs('.implode(',',$val).')';
            } else {
                $data[$k] = $val;
            }
        }
        
        return $data;
    }

    protected function controlStructure($statement, $args, $node, $html = true)
    {
        if ($args || $args === '0') {
            $statement .= " ($args)";
        }

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode("<?php $statement { ".($html ? '?>' : '')),
            $node
        );

        if ($node->nextSibling) {
            $node->parentNode->insertBefore(
                $node->ownerDocument->createTextNode("<?php } ?>"),
                $node->nextSibling
            );
        } else {
            $node->parentNode->appendChild($node->ownerDocument->createTextNode(($html ? '<?php' : ''). " } ?>"));
        }
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

    public function __get($prop)
    {
        return $this->$prop;
    }
}