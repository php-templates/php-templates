<?php

class InvalidNodeException extends Exception 
{
    public function __construct($msg, $node)
    {
        parent::__construct($msg);
    }
}