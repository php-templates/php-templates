<?php

namespace PhpTemplates\Traits;

trait IsContextual {
    public function makeExpressionWithContext(string $string) 
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
            }
            elseif (!$stringRange) {
                $stringRange['char'] = $m[0];
                $stringRange['start'] = $m[1];
            }
            elseif ($stringRange && $k == $last) {
                // todo throw error unclosed string
            }
        }
        
        $stringRange = null;
        // match all $ not inside of a string declaration, considering escapes
        $count = null;
        $string = preg_replace_callback('/(?<!\\\\)\$([a-zA-Z0-9_]*)/', function($m) use (&$stringRange, &$stringRanges) {
            if (empty($m[1][0]) || $m[1][0] == 'this') {
                return '$' . $m[1][0];
            }
            $var = $m[1][0];
            $pos = $m[0][0];
            
            if ($stringRange && ($stringRange['start'] > $pos || $pos > $stringRange['end'])) {
                $stringRange = null;
            }
            if (!$stringRange && $stringRanges && $stringRanges[0]['start'] < $pos && $pos < $stringRanges[0]['end']) {
                $stringRange = array_shift($stringRanges);
            }
            
            // check if is interpolation
            if (!$stringRange || $stringRange['char'] != "'") {
                return '$context->'.$var;
            } 
            return '$' . $var;
        }, $string, -1, $count, PREG_OFFSET_CAPTURE);
        
        return $string;        
    }
}