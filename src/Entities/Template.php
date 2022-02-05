<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;

/**
 * is actually component, but used in different contexts, even on root
*/
class Template extends AbstractParser
{
    private $trimHtml = false;
/*
    public function __construct(Document $doc, $node, $context)
    {
        
        $this->document = $doc;
        $this->node = $node;

        } elseif ($node->nodeName !== '#document') {
            // create extra scope to ensure safe insertbefore and insertafter
            $container = new HTML5DOMDocument();
            $node = $container->importNode($node, true);
            $container->appendChild($node);
            $node = $container;
        }

        $this->node = $node;
    }*/
    
    public function newContext()
    {
        if (!$this->node) {
            $this->name = $this->node;
            $this->node = $this->load($this->name);
            if ($extends = $this->node->querySelector('extends')) {
                //$this->extends($extends);
            }
        }
        $this->parseNode($this->node);
        $this->register();
    }
    
    protected function register()
    {
        while ($this->document->toberemoved) {
            $node = array_pop($this->document->toberemoved);
            try {
                @$node->parentNode && @$node->parentNode->removeChild($node);
            } catch (\Exception $e) {}
        }

        if ($this->trimHtml) {
            $htmlString = $this->trimHtml($dom);
        }
        elseif ($this->node->ownerDocument) {
            $htmlString = $dom->ownerDocument->saveHtml($dom);
        } else {
            $htmlString = $dom->saveHtml();
        }
        // make replaces
        $htmlString = preg_replace('/<html>[\s\n\r]*<\/html>/', '', $htmlString);
        $htmlString = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo htmlspecialchars($eval); ?>";
            }
            return '';
        }, $htmlString);

        $htmlString = $this->getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }

    public function componentContext()
    {

    }

    public function slotContext()
    {

    }
}