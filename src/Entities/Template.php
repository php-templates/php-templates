<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;

class Template extends AbstractParser
{
    private $trimHtml = false;

    public function __construct(Document $doc, $node, string $name)
    {
        $this->document = $doc;
        $this->node = $node;
        $this->name = $name;

        if (!$node || Helper::isComponent($node)) {
            $requestName = preg_replace('(\.template|\.php)', '', $this->name);
            $this->document->registerDependency($requestName);
            $f = trim(Config::get('src_path'), '/').'/';
            $srcFile = $f.$requestName.'.template.php';
            $node = new HTML5DOMDocument;
            $node->substituteEntities = false;
            $node->formatOutput = true;
            $html = file_get_contents($srcFile);
            $html = $this->escapeSpecialCharacters($html);
            $html = $this->removeHtmlComments($html);
            $this->trimHtml = strpos($html, '</body>') === false;
            $node->loadHtml($html);

            if ($extends = $node->querySelector('extends')) {
                $this->extends($extends);
            }
        } elseif ($node->nodeName !== '#document') {
            // create extra scope to ensure safe insertbefore and insertafter
            $container = new HTML5DOMDocument();
            $node = $container->importNode($node, true);
            $container->appendChild($node);
            $node = $container;
        }

        $this->node = $node;
    }

    public function register()
    {
        // $this->parseNode($dom); ala mare

        while ($this->document->toberemoved) {
            $node = array_pop($this->document->toberemoved);
            try {
                @$node->parentNode && @$node->parentNode->removeChild($node);
            } catch (\Exception $e) {}
        }

        if ($trimHtml) {
            $htmlString = $this->trimHtml($dom);
        }
        elseif ($dom->ownerDocument) {
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

        $htmlString = CodeBuffer::getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }

    public function rootContext()
    {

    }

    public function componentContext()
    {

    }

    public function slotContext()
    {

    }
}