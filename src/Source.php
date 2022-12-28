<?php

namespace PhpTemplates;
// todo doc this
class Source
{
    private $code;
    private $file;
    private $startLine;

    public function __construct(string $code, string $file, int $startLine = 0)
    {
        $this->code = $code;
        $this->file = $file;
        $this->startLine = $startLine;
    }

    public function __toString()
    {
        return $this->code;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getStartLine()
    {
        return $this->startLine;
    }
}
