<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;

class Block extends AbstractEntity
{
    protected $attrs = ['name' => null];
    protected $itemsIteration = 0;
    
    protected $name;

    public function __construct(Document $doc, $node, AbstractEntity $context = null)
    {
        parent::__construct($doc, $node, $context);
        //todo: set name with throw error
        $this->name = $node->getAttribute('name');
    }

    /**
     * When a block is passed as a component slot
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);
        $this->println(
            sprintf('$this->comp[%d] = $this->comp[%d]->addSlot("%s", Parsed::template("***block", %s)->withName("%s")->setSlots($this->slots));', 
            $this->depth, 
            $this->context->depth, 
            $this->attrs['slot'], 
            $dataString,
            $this->name
            )
        );
        foreach ($this->node->childNodes as $slot) {
            // register block defaults 
            //todo: iterate over non empty slots
            $this->itemsIteration++;
            $this->parseNode($slot);
        }
    }
    
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);
        $this->println(
            sprintf('<?php $this->comp[%d] = Parsed::template("***block", %s)->withName("%s")->setSlots($this->slots);', 
            $this->depth, 
            $dataString,
            $this->name
            )
        );
        foreach ($this->node->childNodes as $slot) {
            // register block defaults 
            //todo: iterate over non empty slots
            $this->itemsIteration++;
            $this->parseNode($slot);
        }
    
        $this->println(
            sprintf('$this->comp[%d]->render($this->data); ?>', $this->depth)
        );

        $this->document->toberemoved[] = $this->node;
    }

    /**
     * 2 components having same block name will conflict... we must make them unique somehow
     */
    protected function getName($name) {
        return $name.'?id='.uniqid();
    }

    public function mount(HTML5DOMElement $node): void
    {dd(334);
        $nodeData = Helper::nodeStdClass($node);
        $this->name = $this->getName($nodeData->name);
        $this->insertBlock($node);

        $node->parentNode->insertBefore(
            $node->ownerDocument->createTextNode("<?php Parsed::template('$this->name', [])->setSlots(\$slots)->render(\$this->data); ?>"),
            $node
        );
        $this->document->toberemoved[] = $node;
    }

    public function _mount(HTML5DOMElement $node, CodeBuffer $cbf = null): string
    {
        $nodeData = Helper::nodeStdClass($node);
        $this->name = $this->getName($nodeData->name);
        $this->insertBlock($node);
        if ($cbf) {
            $cbf->slot(0, $nodeData->slot, $this->name, $nodeData->attributes);
        }

        return $this->name;
    }

    /**
     * we keep this outside for recursive calling from mount()
     */
    private function insertBlock($node)
    {
        $nodeData = Helper::nodeStdClass($node);
        $this->codebuffer->nestedExpression($nodeData->statements, function() use ($node, $nodeData) {
            $this->codebuffer->block($nodeData->name);// declaration, set slots, set sort slots, 
            $dataString = Helper::arrayToEval($nodeData->attributes);
            // insert child blocks/slots/components
            $i = 0;
            foreach ($node->childNodes as $childNode) {
                if (Helper::isEmptyNode($childNode)) {
                    continue;
                }

                $i++;
                $_nodeData = Helper::nodeStdClass($childNode);
                $_dataString = Helper::arrayToEval($_nodeData->attributes);
                
                // case block
                if ($childNode->nodeName === 'block') {
                    // insert block nested
                    $_name = (new Block($this->document))->_mount($childNode);
                    $this->codebuffer->blockItem($nodeData->name, $_name, array_merge($nodeData->attributes, $_nodeData->attributes, ['_index' => $i]));
                    continue;
                }

                // case component or not
                $_name = $isComponent = Helper::isComponent($childNode);
                $_name = $_name ? $_name : 'block_'.$nodeData->name.'_slot?id='.uniqid();
                if (!isset($this->document->templates[$_name])) {
                    (new Parser($this->document, $_name))->parse($isComponent ? null : $childNode);
                }
                $this->codebuffer->blockItem($nodeData->name, $_name, array_merge($nodeData->attributes, $_nodeData->attributes, ['_index' => $i]));
            }

            $this->codebuffer->render('block', $nodeData->name);
        });
        
        $htmlString = CodeBuffer::getTemplateFunction($this->codebuffer->getStream(true));
        $this->document->templates[$this->name] = $htmlString;
    }
}