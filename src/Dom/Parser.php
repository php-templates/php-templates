<?php

namespace PhpTemplates\Dom;

use Closure;
use PhpTemplates\InvalidNodeException;
use PhpTemplates\Source;

class Parser
{
    protected $noises = [];

    protected $preservePatterns = [
        '/(?<!<)<\?php(.*?)\?>/s',
        '/(?<!@)@php(.*?)@endphp/s',
        '/{{(((?!{{).)*)}}/',
        '/{\!\!(((?!{\!\!).)*)\!\!}/',
    ];
    protected $keepEmptyTextNodes = false;
    protected $currentLineRange = [0, 0];
    protected $srcFile;

    public function parse(Source $source)
    {
        $this->noises = [];
        $this->currentLineRange = [$source->getStartLine(), $source->getStartLine()];
        $this->srcFile = $source->getFile();
        $str = (string) $source;
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

        // now we have a list of valid tags
        $hierarchyQueue = [];
        $inBuildNode = new DomNode('#root');
        $inBuildNode->srcFile = $this->srcFile;
        $inBuildNode->lineNumber = $this->currentLineRange[0];
        $hierarchyQueue[] = $inBuildNode;
        $x = $inBuildNode;
        // iterate over each array chunk and build the virtual dom
        $prev = '';
        foreach ($chunks as $str) {
            // save node line position for debugging
            $this->currentLineRange[0] = $this->currentLineRange[1];
            $this->currentLineRange[1] += substr_count($str, "\n");
            preg_match_all('/\@phpt_eols-(\d+)/', $str, $m);
            if ($m[1]) {
                $this->currentLineRange[1] += array_sum($m[1]);
            }

            // end node
            if (preg_match('/^<\/\s*(\w+[-_\w]*)>/', $str, $m)) {
                if (end($hierarchyQueue)->nodeName != $m[1]) {
                    throw new InvalidNodeException('Missing or wrong closing tag', end($hierarchyQueue));
                }
                $node = array_pop($hierarchyQueue);
                $node->indentEnd = !trim($prev) && strpos($prev, "\n") !== false;
                if ($node === $inBuildNode) {
                    $inBuildNode = end($hierarchyQueue);
                }
            }
            // start node
            elseif (preg_match('/^<(\w+[-_\w]*)/', $str, $m)) {
                $node = new DomNode($m[1]);
                $attrs = $this->getTagAttributes($str);
                foreach ($attrs as $attr) {
                    $node->addAttribute(new DomNodeAttr($attr[0], $attr[1]));
                }
                $node->srcFile = $this->srcFile;
                $node->lineNumber = $this->currentLineRange[0];
                $node->indentStart = !trim($prev) && strpos($prev, "\n") !== false;
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
            // text node
            elseif ($this->keepEmptyTextNodes || trim($str)) {
                $str = str_replace(array_keys($this->noises), $this->noises, $str);
                $node = new DomNode('#text', $str);
                $inBuildNode->appendChild($node);
            }

            $prev = $str;
        }

        if (count($hierarchyQueue) > 1) {
            // some nodes not closed
            throw new InvalidNodeException('Missing or wrong closing tag', end($hierarchyQueue));
        }

//dd($hierarchyQueue[0]->childNodes[0]->debug());
        if (isset($hierarchyQueue[0])) {
            return $hierarchyQueue[0];
        }
        return null;
    }

    public function beggfforeCallback(Closure $cb)
    {
        $this->beforeCallback = $cb;
    }

    protected function removeHtmlComments($content = '') {
    	return preg_replace_callback('~<!--.+?-->~ms', function($m) {
    	    return str_repeat("\n", substr_count($m[0], "\n")+1);
    	}, $content);
    }

    protected function getTagAttributes($str)
    {
        preg_match_all('/\@phpt_eols-(\d+)/', $str, $m);
        if ($m[1]) {
            $this->currentLineRange[1] += array_sum($m[1]);
        }
        $attrs = [];
        $originalStr = $str;
        $noises = [
            '\\"' => '&quot_;',
            '\\\'' => '&#039_;',
        ];
        $str = str_replace(array_keys($noises), $noises, $str);
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

        $noises = [
            '&quot_;' => '"',
            '&#039_;' => '\'',
        ];
        $attrs = array_merge($attrs, $html5attrs);
        $attrs = array_filter($attrs, function($attr) {
            return trim($attr[0] . $attr[1]);
        });

        $_attrs = [];
        foreach ($attrs as &$attr) {
            $attr[1] = str_replace(array_keys($noises), $noises, $attr[1]);
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

    protected function collectAndReplaceNoises($str)
    {
        // isolate scripts cuz are dangerous
        $str = $this->freezeTagContent($str, 'script');

        // handle php tags {{ and @php and <?= and scripts
        foreach ($this->preservePatterns as $regexp) {
            $str = preg_replace_callback($regexp, function($m) {
                $rid = '__r'.uniqid().'@phpt_eols-'.substr_count($m[0], "\n");
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

    protected function validateAndRepairNodes($arr, $limit = 0)
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

    protected function isCompleteTag($str) {
        $str = str_replace(['\\"', '\\\''], '', $str);
        $str = preg_replace('/="(((?!").)*)"/s', '', $str);
        $str = preg_replace("/='(((?!').)*)'/s", '', $str);
        $isComplete = strpos($str, '"') === false && strpos($str, "'") === false;
       // strpos($str, '<path') == 0 && !$isComplete && dd('baaa'.$x.$str);
        return $isComplete;
    }

    protected function freezeTagContent($str, $tag)
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