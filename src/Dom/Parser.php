<?php

namespace PhpTemplates\Dom;

class Parser
{ 
    private $noises = [];
    
    private $state = 'root';
    
    const STATE_ROOT = 'root';
    const STATE_NODE_OPEN = 'nodeOpen';
    const STATE_NODE_DECLARATION = 'nodeDeclaration';
    const STATE_NODE_INNER_TEXT = 'nodeInnerText';
    
    private $hierarchyQueue = [];
    private $glue = ' ';
    
    public function parse(string $str)
    {
        d($str);
        
        $str = $this->collectAndReplaceNoises($str);
        $str = $this->collectAndReplaceEndTags($str);
    /*  
        >foo>bar>
        '' foo bar ''
        foo>foo>bar>bar
        foo foo bar bar
        la prima pun oricum
        ultima nu primeste niciodata inapoi
        
        <foo<bar<
        '' foo bar ''
        foo<foo<bar<bar
        foo foo bar bar
        prima primeste doar daca e plina
        ultima primeste doar daca e goala
*/        
        $arr = explode('>', $str);
        $max = count($arr) -1;
        $arr = array_map(function($str, $i) use($max) {
            if ($i < $max) {
                return $str.'>';
            }
            return $str;
        }, $arr, array_keys($arr));
        $tmp = [];
        foreach ($arr as $str) {
            $arr = explode('<', $str);
            $max = count($arr) -1;
            foreach ($arr as $i => $str) {
                if (($i > 0)) {
                    $tmp[] = '<'.$str;
                } 
                else {
                    $tmp[] = $str;
                }
            }
        }
        
        // now we have an array containing '<div ..attrs>', or text sequences and we have to validate them                                                      
        //d($tmp);
        $chunks = $this->validateAndRepairNodes($tmp);
        // now we have a list of valid tags
        //d($chunks);
        
        foreach ($chunks as $str) {
            if (preg_match('/^<\/\s*(\w+)>/', $str, $m)) {
                d('close.'.$m[1]); //close tag m1
            }
            elseif (preg_match('/^<\w+/', $str)) {
                d('attr.'.$str);
                $attrs = $this->getTagAttributes($str);
                d($attrs);
            } else {
                d('0'.$str);
            }
        }
        
        die();
        
        
    }
    
    private function getTagAttributes($str)
    {
        $attrs = [];
        $originalStr = $str;
        $str = preg_replace_callback('/(((?![= ]).)*)=("(((?!").)*)"|\'(((?!\').)*)\')/', function($m) use (&$attrs) {
            $attrs[] = [
                $m[1],
                $m[4]
            ];
            return '';
        }, $str);
     
        preg_match_all('/ (((?![ >]).)+)/', $str, $html5attrs);
        if (isset($html5attrs[1])) {
            $html5attrs = array_map(function($attr) {
                return [$attr, ''];
            }, $html5attrs[1]);
        } else {
            $html5attrs = [];
        }
        
        $attrs = array_merge($attrs, $html5attrs);
        $_attrs = [];
        foreach ($attrs as $attr) {
            $k = ' '.strpos($attr[0], $originalStr);
            if (!isset($_attrs[$k])) {
                $_attrs[$k] = $attr;
            } else {
                $_attrs[] = $attr;
            }
        }
        ksort($_attrs);
        
        return array_values($_attrs);
    }
    
    private function collectAndReplaceNoises($str)
    {
        // handle php tags {{ and @php and <?= and scripts
        return $str;
    }
    
    private function collectAndReplaceEndTags($str)
    {
        return $str;
    }
    
    private function validateAndRepairNodes($arr)
    {
        $result = [];
        $push = '';
        foreach ($arr as $str) {
            if (!$str) {
                continue;
            }
            $str = $push . $str;
           
            $hasTagStart = preg_match('/^<\w+/', $str);
            if (!$push && !$hasTagStart) {
                // text node
                $result[] = $str;
            }
            // count str ' and " and decide if is properly closed with >, if not, it becomes buffer, else it is pushed and reset buffer
            elseif ($hasTagStart) {
                if ($this->isCompleteTag($str)) {
                    $result[] = $str;
                    $push = '';
                } else {
                    $push = $str;
                }
            }
            else {
                $result[] = $str;
                $push = '';
            }
        }
        
        return $result;
    }
    
    private function isCompleteTag($str) {
        
        $str = preg_replace('/="(((?!").)*)"/', '', $str);
        $str = preg_replace("/='(((?!').)*)'/", '', $str);
        
        return strpos($str, '"') === false && strpos($str, "'") === false;
    }
    
    private function root($ch) 
    {
        if ($ch == '<') {
            $this->state = self::STATE_NODE_OPEN;
        }
    }
    
    private function nodeOpen($ch)
    {
        echo $ch;
    }
}