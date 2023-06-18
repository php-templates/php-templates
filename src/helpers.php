<?php

namespace PhpTemplates;

use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\BuilderFactory;
use PhpParser\Node\Stmt\Class_;
use PhpParser\PrettyPrinter;

/**
 * Echo escaped string
 *
 * @param string $string
 * @return void
 */
function e($string)
{
    if ($string && !is_string($string)) {
        $string = json_encode($string);
    }
    echo htmlentities((string)$string);
}

function resolve_class(array $class) 
{
    $result = [];
    foreach ($class as $k => $val) {
        if (is_numeric($k)) {
            // class="[foo ? bar : '']"
            if ($val) {
                $result[] = $val;
            }
        }
        elseif ($val) {
            // class="[foo => true]"
            $result[] = $k;
        }
    }
    
    return implode(' ', $result);
}

function e_bind($array, array $except = [])
{
    $array = array_diff_key((array)$array, array_flip($except));
    $result = [];
    foreach ($array as $k => $val) {
        if (is_bool($val)) {
            if ($val) {
                $result[] = $k;
            }
            continue;
        }
        
        $val = !is_string($val) ? json_encode($val) : $val;
        if (strlen(trim($val))) {
            $result[] = $k . '="' . htmlentities($val) . '"';
        }
        elseif ($k) {
            $result[] = $k;
        }
    }
    
    echo implode(' ', $result);
}

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

function parse_path(string $rfilepath, Config $config): array
{
    $cfgkey = '';
    if (strpos($rfilepath, ':')) {
        list($cfgkey, $rfilepath) = explode(':', $rfilepath);
    }
    
    if (!$cfgkey) {
        return [$rfilepath, $config->getRoot()];
    }
    
    // support for spearing proggrammer of write module namespace each time on a component
    if ($cfgkey == '@') {
        return [$rfilepath, $config];
    }
  
    $config = $config->getRoot()->find($cfgkey);
        
    return [$rfilepath, $config];
}

function arr_except(array $arr, $except) {
    foreach ((array)$except as $except) {
        unset($arr[$except]);
    }
    
    return $arr;
}

/**
 * Make all variables from input source code to refer to $this->scope
 */
function enscope_variables(string $str): string
{
    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    $asts = $parser->parse("<?php $str;");   
    $r = function ($ast) use (&$r) 
    {
        if (isset($ast->name) && is_string($ast->name)) {
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
    
    return $result;
}