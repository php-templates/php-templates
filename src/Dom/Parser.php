<?php

namespace PhpTemplates\Dom;

class Parser
{ 
    private $noises = [];
    
    private $preservePatterns = [];
    private $keepEmptyTextNodes = false;   
    
    public function parse(string $str)
    {
        $str = $this->collectAndReplaceNoises($str);
          
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
        $chunks = $this->validateAndRepairNodes($tmp);
        //dd($chunks);
        // now we have a list of valid tags
        
    //dd($chunks);
        $hierarchyQueue = [];
        $inBuildNode = new DomNode('#root');
        $hierarchyQueue[] = $inBuildNode;
        $x = $inBuildNode;
        
        foreach ($chunks as $str) {
            if (preg_match('/^<\/\s*(\w+[-_\w]*)>/', $str, $m)) {
                //d('close.'.$m[1]); //close tag m1
                if (end($hierarchyQueue)->nodeName != $m[1]) {
                    // TODO:throw error no close tag
                    // wrong close, ignore it is better
                    //$node = new DomNode('#text', $str);
                    //$inBuildNode->appendChild($node);
                    continue; // wrong close tag
                }
                $node = array_pop($hierarchyQueue);
                if ($node === $inBuildNode) {
                    $inBuildNode = end($hierarchyQueue);
                }
            }
            elseif (preg_match('/^<(\w+[-_\w]*)/', $str, $m)) {
                $node = new DomNode($m[1]);
                $attrs = $this->getTagAttributes($str);
                foreach ($attrs as $attr) {
                    $node->addAttribute($attr[0], $attr[1]);
                }
                $inBuildNode->appendChild($node);
                // if is not self closing tag, or short closing tag, don t push to hierarchy queue
                //d('appending to queue', $node);
                preg_match('/\/\s*>$/', $str, $m);
                if (!$m && !$node->isSelfClosingTag()) {
                    $hierarchyQueue[] = $node;
                    $inBuildNode = $node;
                } 
                elseif ($m) {
                    $node->shortClose = true;
                }
            } 
            elseif ($this->keepEmptyTextNodes || trim($str)) {
                $str = str_replace(array_keys($this->noises), $this->noises, $str);
                $node = new DomNode('#text', $str);
                $inBuildNode->appendChild($node);
            }
        }
        //dd(''.$x);
       // die();
        if (isset($hierarchyQueue[0])) {
            return $hierarchyQueue[0];
        }
        return null;
    }
    
    private function getTagAttributes($str)
    {
//$x = strpos($str, 'M68.982,108.52892q-11.5965-18.582-23.49-37.242-11.895-18.6555-23.49-36.2v73.442H0V2.23092H23.192q12.042,17.9895,23.713,36.052,11.66852,18');
        $attrs = [];
        $originalStr = $str;
        $str = preg_replace_callback('/(((?![= ]).)*)=("(((?!").)*)"|\'(((?!\').)*)\')/s', function($m) use (&$attrs, $str) {
            $attrs[] = [
                $m[1],
                isset($m[6]) ? $m[6] : $m[4]
            ];
            return '';
        }, $str);
     
        preg_match_all('/ (((?![ \/>]).)+)/', $str, $html5attrs);
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
            $k = strpos($originalStr, ' '.$attr[0]);
            if (!isset($_attrs[$k])) {
                $_attrs[$k] = $attr;
            } else {
                $_attrs[] = $attr;
            }
        }
        ksort($_attrs);
        
        foreach ($_attrs as &$attr) {
            if (isset($this->noises[$attr[0]])) {
                $attr[0] = $this->noises[$attr[0]];
            }
            if ($attr[1] && isset($this->noises[$attr[1]])) {
                $attr[1] = $this->noises[$attr[1]];
            }
        }
        
        return array_values($_attrs);
    }
    
    private function collectAndReplaceNoises($str)
    {
        // isolate scripts cuz are dangerous
        $str = $this->freezeTagContent($str, 'script');
        
        // handle php tags {{ and @php and <?= and scripts
        foreach ($this->preservePatterns as $regexp) {
            $str = preg_replace_callback($regexp, function($m) {
                $rid = '__r'.uniqid();
                $this->noises[$rid] = $m[0];
                return $rid;
            }, $str);
        }
        
        return $str;
    }
    
    public function addPreservePattern(string $regexp)
    {
        $this->preservePatterns[] = $regexp;
    }
    
    private function validateAndRepairNodes($arr, $limit = 0)
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
                if ($limit) {
                    return $result;
                }
            }
        }
        
        return $result;
    }
    
    private function isCompleteTag($str) {
        $x = $str;
        $str = preg_replace('/="(((?!").)*)"/s', '', $str);
        $str = preg_replace("/='(((?!').)*)'/s", '', $str);
        $isComplete = strpos($str, '"') === false && strpos($str, "'") === false;
       // strpos($str, '<path') == 0 && !$isComplete && dd('baaa'.$x.$str);
        return $isComplete;
    }
    
    private function freezeTagContent($str, $tag) 
    {
        $arr = preg_split("/<\/\s*{$tag}>/", $str);
        $max = count($arr) -1;
        $arr = array_map(function($str, $i) use($max, $tag) {
            if ($i < $max) {
                return $str.'</'.$tag.'>';
            }
            return $str;
        }, $arr, array_keys($arr));
        //dd($arr);
        // now we have an array like
        // ['foo bar <script>fnfnfn', '</script>dhdhdh']
        $tmp = [];
        foreach ($arr as $str) {
            $arr = explode('<'.$tag, $str);
            $max = count($arr) -1;
            foreach ($arr as $i => $str) {
                if (($i > 0)) {
                    $tmp[] = '<'.$tag.$str;
                } 
                else {
                    $tmp[] = $str;
                }
            }
        }
        $arr = $tmp;
        // now we have an array like
        // ['foo bar', '<script ___>fnfnfn</script>', 'dhdhdh']
       
        foreach ($arr as &$str) {
            if (strpos($str, '<'.$tag) === 0) {
                $_arr = explode('>', $str);
                $max = count($_arr) -1;
                $_arr = array_map(function($str, $i) use($max) {
                    if ($i < $max) {
                        return $str.'>';
                    }
                    return $str;
                }, $_arr, array_keys($_arr));
                
                $chunks = $this->validateAndRepairNodes($_arr, 1);
                // now we have an array like
                // ['<script ___>', 'fnfnfn']
                // and we have to isolate content and keep tag
                
                $tagDecl = array_shift($chunks);
                $content = implode('', $chunks);
                $content = substr($content, 0, -(strlen($tag)+3));
               
                if (trim($content)) {
                    $rid = '__r'.uniqid();
                    $this->noises[$rid] = $content;
                    $str = $tagDecl.$rid.'</'.$tag.'>';
                }
            }
        }

        return implode('', $arr);
    }
}