<?php

namespace PhpTemplates;

use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\BuilderFactory;
use PhpParser\Node\Stmt\Class_;
use PhpParser\PrettyPrinter;
use PhpParser\Node\Expr\Variable;

/**
 * Check dependencies foreach file => filemtime and returns false in case of modification
 *
 * @param array $files
 * @return void
 */
function check_dependencies(array $files)
{
    foreach ($files as $file => $m) {
        if ($m < filemtime($file)) {
            return false;
        }
    }
    return true;
}

/**
 * Make all variables from input source code to refer to $this->scope
 */
function enscope_variables(string $str): string
{try {
    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    $asts = $parser->parse("<?php $str;"); 

    $r = function ($ast) use (&$r) 
    {
        if ($ast instanceof Variable && $ast->name != 'this') {
            $ast->name = 'this->scope->' . $ast->name;
        }
          
        if (! is_iterable($ast) && ! $ast instanceof \PhpParser\Node) {
           return;
        }

        foreach ($ast as $ast) {
            $r($ast);
        }
    };
    $r($asts);

    $prettyPrinter = new PrettyPrinter\Standard;
    $result = $prettyPrinter->prettyPrint($asts);
    $result = rtrim($result, ';');

    return $result;} catch (\Exception) {dump($str);}
}