<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;

class Component extends AbstractParser
{
    public function __construct(Document $doc, $node, string $name)
    {
        $this->document = $doc;
        $this->node = $node;
        $this->name = $name;

        $trimHtml = false;
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
            $trimHtml = strpos($html, '<body') === false;
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