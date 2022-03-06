<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;

/**
 * is actually component, but used in different contexts, even on root
*/
class Template extends AbstractEntity
{
    private $name;
    private $tobereplaced = [
        '="__empty__"' => '',
        '&gt;' => '>',
        '&amp;\gt;' => '&gt;',
        '&lt;' => '<',
        '&amp;\lt;' => '&lt;',
        '&amp;' => '&',
        '&amp;\amp;' => '&amp;',
        '<php>' => '<?php',
        '</php>' => '?>'
    ];

    public function __construct(Document $doc, $node, $context = null)
    {
        parent::__construct($doc, $node, is_string($context) ? null : $context);
        if (is_string($node)) {
            $this->name = $node;
        } 
        elseif (is_string($context)) {
            $this->name = $context;
        }
    }
    
    public function newContext()
    {
        $this->thread = uniqid();
        Php::setThread($this->thread);
        $this->document->tobereplaced[$this->thread] = $this->tobereplaced;
        if (method_exists($this->node, 'querySelector')) {
            if ($extends = $this->node->querySelector('extends')) {
                $this->extends($extends);
            }
        }
        $this->parseNode($this->node);

        $this->register();
    }
    
    protected function register()
    {
        if ($this->trimHtml) {
            $htmlString = $this->trimHtml($this->node);
        }
        elseif ($this->node->ownerDocument) {
            $htmlString = $this->node->ownerDocument->saveHtml($this->node);
        } else {
            $htmlString = $this->node->saveHtml();
        }

        $htmlString = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo htmlspecialchars($eval); ?>";
            }
            return '';
        }, $htmlString);

        $htmlString = str_replace(array_keys($this->document->tobereplaced[$this->thread]), array_values($this->document->tobereplaced[$this->thread]), $htmlString);

        $htmlString = $this->getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }

    private function extends($extends)
    {
        $extendedTemplate = $extends->getAttribute('template');
        (new Template($this->document, $extendedTemplate))->newContext();

        $this->document->addEventListener('rendering', $this->name, "function(\$template, \$data) {
            \$comp = Parsed::template('$extendedTemplate', \$data);
            \$comp->addSlot('default', \$template);
            \$comp->render(\$data);
            return false;
        }");

        $extends->parentNode->removeChild($extends);
    }
}