<?php

namespace PhpTemplates\Attributes;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\DomNodeAttr;
use PhpTemplates\Config;

class AttributePack
{
    private $config;
    private $attrs = [];
    
    public function __construct(Config $config) 
    {
        $this->config = $config;
    }

    public function add(DomNodeAttr $attr)
    {
        $this->attrs[] = $attr;
    }

    /**
     * used inside html
     */
    public function addToNode(DomNode $node)
    {
        $attrs = [];
        $binds = [];
        $excludes = ['class'];
        foreach ($this->attrs as $attr) {
            $isBind = strpos($attr->nodeName, ':') === 0;
            $k = ltrim($attr->nodeName, ' :');
            $val = trim($attr->nodeValue);
            
            if ($k == 'p-raw') {
                $val = "<?php echo $val; ?>";
                $attrs[$val] = '';
            }
            elseif ($k == 'p-bind') {
                // collect separate p-bind to treat them ignoring existing attrs
                $binds[] = $val;
            }
            elseif ($k == 'class') {
                if ($isBind && strpos($val, '[') === 0) {
                    $val = "<?php e(resolve_class($val)); ?>";
                } 
                elseif ($isBind) {
                    $val = "<?php e($val); ?>";
                }
                else {
                    $val = $this->evaluateTags($val);
                }
                $attrs[$k] = trim(($attrs[$k] ?? '') .' '. $val);
            } 
            elseif ($isBind) {
                $attrs[$k] = "<?php e($val); ?>";
                $excludes[] = $k;
            }
            else {
                $val = $this->evaluateTags($val);
                $attrs[$k] = $val;
                $excludes[] = $k;
            }
        }
       
        foreach ($attrs as $k => $val) {
            $node->addAttribute($k, $val);
        }
        $excludes = "['" . implode("','", $excludes) . "']";
        if (count($binds) > 1) {
            $binds = 'array_merge(' . implode(', ', $binds) . ')';
            $node->addAttribute("<?php e_bind($binds, $excludes); ?>");
        }
        elseif ($binds) {
            $node->addAttribute("<?php e_bind($binds[0], $excludes); ?>");
        }
    }

    /**
     * used on php entities calls
     */
    public function toArrayString()
    {
        $attrs = [];
        $binds = [];
        $excludes = ['class'];
        foreach ($this->attrs as $attr) {
            $isBind = strpos($attr->nodeName, ':') === 0;
            $k = ltrim($attr->nodeName, ' :');
            $val = trim($attr->nodeValue);
            
            if ($k == 'p-raw') {
                $attrs[$val] = 'true';
            }
            elseif ($k == 'p-bind') {
                // collect separate p-bind to treat them ignoring existing attrs
                $binds[] = $val;
            }
            elseif ($k == 'class') {
                if ($isBind && strpos($val, '[') === 0) {
                    $val = "resolve_class($val)";
                } 
                elseif (!$isBind) {
                    $val = "'$val'";
                }
                $attrs["'$k'"] = trim(($attrs["'$k'"] ?? '') .' . '. $val, ' .');
            } 
            elseif ($isBind) {
                $attrs["'$k'"] = $val;
                $excludes[] = $k;
            }
            elseif (!$val) {
                $attrs["'$k'"] = 'true';
                $excludes[] = $k;
            }
            else {
                $attrs["'$k'"] = "'" . addslashes($val) . "'";
                $excludes[] = $k;
            }
        }
        
        $result = [];
        foreach ($attrs as $k => $val) {
            $result[] = "$k=>$val";
        }
        $result = ['[' . implode(',', $result) . ']'];
        $excludes = "['" . implode("','", $excludes) . "']";
        if (count($binds) > 1) {
            $binds = 'array_merge(' . implode(', ', $binds) . ')';
            $result[] = "arr_except($binds, $excludes)";
        }
        elseif ($binds) {
            $result[] = "arr_except($binds[0], $excludes)";
        }
        if (count($result) > 1) {
            return "array_merge(" . implode(',', $result) . ")";
        }
        
        return $result[0];
    }
    
    private function evaluateTags($val) 
    {
        $val = preg_replace('/{{(((?!{{).)*)}}/', '<?php e($1); ?>', $val);
        return $val;
        // custom tags
        $t = $this->config->getCustomTags();
        if (!$t) {
            return $val;
        }
        $t = implode('|', $t);
        return preg_replace_callback("/{($t) (((?!{($t) ).)*)}/", function($m) {
            $fn = $this->config->customTag($m[1]);
            return $fn($this->config, trim($m[2]));
        }, $val);
    }
}
