<?php

namespace PhpTemplates;

class InvalidNodeException extends \Exception 
{
    public function __construct($msg, $node)
    {dd($node->ownerDocument);
        parent::__construct($msg."\n".$this->dom($node));
    }
    
    protected function dom($d)
    {
        if (is_string($d)) {
            $content = $d;
        } else {
            if (!is_iterable($d)) {
                $d = [$d];
            } 
            $content = '';
            foreach ($d as $node)
            {
                if (@$node->ownerDocument) {
                //$node = $dom->importNode($node, true);
                    $content.= $node->ownerDocument->saveHtml($node);
                }
                else {
                    $content.= $node->saveHtml();
                }
            }
        }
        return $content;
    }
}