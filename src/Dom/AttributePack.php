<?php

namespace PhpTemplates\Dom;

use PhpDom\Contracts\DomNodeInterface as DomNode;
use PhpDom\DomNodeAttr;
use PhpTemplates\Config;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\BuilderFactory;
use PhpParser\Node\Stmt\Class_;
use PhpParser\PrettyPrinter;
use PhpTemplates\Exceptions\InvalidNodeException;
use function PhpTemplates\enscope_variables;

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
        $line = '';
        if ($lineNr = $this->getLine($node)) {
            $line = '/*line:'.$lineNr.'*/';
        }
        
        $attrs = [];
        $binds = [];
        $excludes = ['class'];
        foreach ($this->attrs as $attr) {
            $isBind = strpos($attr->getName(), ':') === 0;
            $k = ltrim($attr->getName(), ' :');
            $val = $attr->getValue();
            
            if ($isBind && !strlen(trim($val))) {
                throw new InvalidNodeException('Empty binding', $node);
            }

            if ($isBind || strpos($k, 'p-') === 0) {
                $val = $this->getEnscopedAttrValue($attr, $node);
            }
            
            if ($k == 'p-raw') {
                $val = "<?php echo $val; ?>";
                $attrs[$val] = null;
            }
            elseif ($k == 'p-bind') {
                // collect separate p-bind to treat them ignoring existing attrs
                $binds[] = $val;
            }
            elseif ($k == 'class') {
                if ($isBind && strpos($val, '[') === 0) {
                    $val = "<?php \$this->__e(\$this->__resolveClass($val)); ?>";
                } 
                elseif ($isBind) {
                    $val = "<?php \$this->__e($val); ?>";
                }
                else {
                    $val = $this->evaluateTags($val);
                }
                
                if (isset($attrs[$k])) {
                    $attrs[$k] .= ' '. $val;
                }
                else {
                    $attrs[$k] = $val;
                }
            } 
            elseif ($isBind) {
                $attrs[$k] = "<?php \$this->__e($val); ?>";
                $excludes[] = $k;
            }
            else {
                $val = $this->evaluateTags($val);
                $attrs[$k] = $val;
                $excludes[] = $k;
            }
        }

        foreach ($attrs as $k => $val) {
            if ($line && strpos($val, '<?php') === 0) {
                $val = str_replace('<?php', '<?php '.$line, $val);
                $line = '';
            }
            elseif ($line && strpos($k, '<?php') === 0) {
                $k = str_replace('<?php', '<?php '.$line, $k);
                $line = '';
            }
            $node->setAttribute($k, $val);
        }
        
        $excludes = "['" . implode("','", $excludes) . "']";
        if (count($binds) > 1) {
            $binds = 'array_merge(' . implode(', ', $binds) . ')';
            $node->setAttribute("<?php {$line}\$this->__eBind($binds, $excludes); ?>");
        }
        elseif ($binds) {
            $node->setAttribute("<?php {$line}\$this->__eBind({$binds[0]}, $excludes); ?>");
        }
    }

    /**
     * used on php entities calls
     */
    public function toArrayString()
    {// todo, test this if used… or what, if scoped
        $attrs = [];
        $binds = [];
        $excludes = ['class'];
        foreach ($this->attrs as $attr) {
            $isBind = strpos($attr->getName(), ':') === 0;
            $k = ltrim($attr->getName(), ' :');
            $val = trim($attr->getValue());
            
            if ($k == 'p-raw') {
                $attrs[$val] = 'true';
            }
            elseif ($k == 'p-bind') {
                // collect separate p-bind to treat them ignoring existing attrs
                $binds[] = $val;
            }
            elseif ($k == 'class') {
                if ($isBind && strpos($val, '[') === 0) {
                    $val = "t\\resolve_class($val)";
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
            $result[] = "\$this->__arrExcept($binds, $excludes)";
        }
        elseif ($binds) {
            $result[] = "\$this->__arrExcept($binds[0], $excludes)";
        }
        if (count($result) > 1) {
            return "array_merge(" . implode(',', $result) . ")";
        }
        
        return $result[0];
    }
    
    private function evaluateTags($val) 
    {
        if (is_null($val)) {
            return null; // do not alterate null to ''
        }
        
        $val = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            return '<?php $this->__e('. enscope_variables($m[1]) .'); ?>';
        }, $val);
        // todo
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
    
    private function getEnscopedAttrValue($attr, $node) 
    {
        $val = $attr->value;
        try {
            return enscope_variables($val);
        } catch (\Throwable $e) {
            throw new InvalidNodeException("Error trying to evaluate the syntax '{$val}': ". $e->getMessage(), $node);
        }
    }
    
    public function getLine($node) 
    {
        if ($node->getLine()) {
            return $node->getLine();
        }
        
        $refNode = $node;
        while ($refNode->getParentNode()) {
            $refNode = $refNode->getParentNode();
            if ($refNode instanceof \PhpDom\DomNode && $refNode->getLine()) {
                return $refNode->getLine();
            }
        }
    }
}
