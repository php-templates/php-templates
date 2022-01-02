
<?php
namespace DomDocument\PhpTemplates\Entities;

use DomDocument\PhpTemplates\CodeBuffer;
use DomDocument\PhpTemplates\Document;
use DomDocument\PhpTemplates\Helper;
use DomDocument\PhpTemplates\Parser;
use IvoPetkov\HTML5DOMDocument;
use IvoPetkov\HTML5DOMElement;

class AnonymousComponent extends Parser implements Mountable
{
    protected $document;
    protected $name;
    protected $codebuffer;
    
    public function __construct(Document $doc)
    {
        $this->document = $doc;
        $this->name = uniqid();
        $this->codebuffer = new CodeBuffer;
    }

    public function mount(HTML5DOMElement $node): void
    {
        $this->insertComponent($node);
        $nodeData = Helper::nodeStdClass($node);
        $this->codebuffer->component($this->name, $nodeData->attributes);
        $this->codebuffer->raw('$comp0->render($data);');

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode($this->codebuffer->getStream(true)),
            $node
        );

        $this->document->toberemoved[] = $node;
    }

    public function _mount(HTML5DOMElement $node, CodeBuffer $cbf) 
    {
        $this->codebuffer = $cbf;
        $nodeData = Helper::nodeStdClass($node);
        $this->insertComponent($node);
        $this->codebuffer->slot(0, $nodeData->slot, $this->name, $nodeData->attributes);
    }

    protected function insertComponent($node)
    {
        $nodeData = Helper::nodeStdClass($node);
        // childnodes
        $childs = new HTML5DOMDocument();
        foreach ($node->childNodes as $cn) {
            $childs->appendChild($childs->importNode($cn, true));
        }
        (new Parser($this->document, $this->name))->parse($childs);
    }
}