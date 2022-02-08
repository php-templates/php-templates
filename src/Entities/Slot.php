<?php

namespace PhpTemplates\Entities;

use PhpTemplates\CodeBuffer;
use PhpTemplates\Document;
use PhpTemplates\Helper;
use PhpTemplates\Parser;
use IvoPetkov\HTML5DOMElement;
use PhpTemplates\InvalidNodeException;

class Slot extends AbstractEntity
{
    protected $attrs = ['name' => 'default', 'slot' => 'default'];
    private $hasSlotDefault;

    public function __construct(Document $doc, $node, AbstractEntity $context)
    {
        parent::__construct($doc, $node, $context);

        $this->hasSlotDefault = $this->node->childNodes->length > 0;
    }

    public function simpleNodeContext()
    {
        $phpStart = '<?php';
        $phpEnd = '?>';

        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);
        $closeTag = $this->hasSlotDefault ? '' : '?>';

        $definition = '%s foreach ($this->slots("%s") as $_slot) {'
            .PHP_EOL.'$_slot->render(array_merge($this->data, %s));'
            .PHP_EOL.'} %s';

        $this->println(
            sprintf($definition, $phpStart, $this->attrs['name'], $dataString, $this->hasSlotDefault ? '' : $phpEnd)
        );

        if ($this->hasSlotDefault) {
            $definition = 'if (empty($this->slots("%s"))) {';
            $this->println(sprintf($definition, $this->attrs['name']));

            foreach ($this->node->childNodes as $slotDefault) {
                $this->parseNode($slotDefault);
            }

            $this->println('} '.$phpEnd);
        }

        $this->document->toberemoved[] = $this->node;
    }

    public function slotContext()
    {
        // throw new InvalidNodeException('Invalid slot location (slot in slot not allowed)', $this->node->parentNode);
    }

    /**
     * <myComp><slot name="mytitle" slot="title"></slot></myComp>
     *
     */
    public function componentContext()
    {
        $phpStart = '<?php';
        $phpEnd = '?>';

        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);

        $definition = '%s foreach ($this->slots("%s") as $_slot) {'
            .PHP_EOL.'$this->comp[%d]->addSlot("%s", $_slot);'
            .PHP_EOL.'} %s';

        $this->println(
            sprintf($definition, $phpStart, $this->attrs['name'], $this->context->depth, $this->attrs['slot'], $this->hasSlotDefault ? '' : $phpEnd)
        );

        if ($this->hasSlotDefault) {
            $definition = 'if (empty($this->slots("%s"))) {';
            $this->println(sprintf($definition, $this->attrs['name']));

            foreach ($this->node->childNodes as $slotDefault) {
                $this->parseNode($slotDefault);
            }

            $this->println('} '.$phpEnd);
        }
    }

    public function mount($i = 0): void
    {
        $name = Helper::isComponent($this->node);
        // deplete node
        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);
        $slotDefault = $this->getNodeSlots($node, true);
        
        $cbf = new CodeBuffer($node);
        $cbf->raw("<?php foreach (\$this->slots($this->name) as $_slot) {");
        $cbf->raw("\$_slot->render(array_merge(\$this->data, $dataString))");
        $cbf->raw('}');
        
        if (!empty($slotDefault['default'])) {
            $this->insertBefore("if (!\$this->slots($this->name)) {", $node);
            foreach ($slotDefault['default'] as $slot) {
                NodeParser::parse($slot, $this);
            }
        }
        
        $cbf->raw('?>');
        
        return;
        $this->insertBefore("} ?>", $node);
        
        
        
        
        $this->insertSlot($node);

    
        $this->document->toberemoved[] = $node;
    }

    public function _mount(HTML5DOMElement $node, CodeBuffer $cbf)
    {
        $this->codebuffer = $cbf;

        $this->insertSlot($node);
    }

    public function insertSlot($node)
    {
        $nodeData = Helper::nodeStdClass($node);
        $this->name = $nodeData->name;

        $this->codebuffer->nestedExpression($nodeData->statements, function() use ($nodeData, $node) {
            if (!$this->nest) {
                //$this->codebuffer->raw("DomEvent::event('renderingSlots', '$this->name', \$this->slots['$this->name'] ?? [], []);");
            }
            $this->codebuffer->if('!empty($this->slots["'.$this->name.'"])', function() use ($nodeData) {
                $this->codebuffer->foreach("\$this->slots['$this->name'] as \$slot", function() use ($nodeData) {
                    $dataString = Helper::arrayToEval($nodeData->attributes);
                    if ($this->nest) {
                        $this->codebuffer->raw("\$this->comp[{$this->i}]->addSlot('{$nodeData->slot}', \$slot);");
                    } else {
                        $this->codebuffer->raw('$slot->render(array_merge($this->data, '.$dataString.'));');
                    }
                });
            }); 
            if ($slotDefault = $this->getNodeSlots($node, true)) {
                $slotDefault = $slotDefault['default'];
                // check for empty cn first
                $this->codebuffer->else(null, function() use ($slotDefault) {
                    foreach ($slotDefault as $_node) {
                        // skip empty nodes
                        if ($_node->nodeName === 'slot') {
                            continue;
                        }
                        
                        $_name = $isComponent = Helper::isComponent($_node);
                        $_name = $_name ? $_name : 'slot_default?id='.uniqid();
                        if ($isComponent) {
                            (new Component($this->document, $_name))->_mount($_node, $this->codebuffer);
                        } else {
                            $_nodeData = Helper::nodeStdClass($_node);
                            (new Parser($this->document, $_name))->parse($_node);
                            $this->codebuffer->nestedExpression($_nodeData->statements, function() use ($_name, $_nodeData) {
                                $this->codebuffer->raw('$this->comp[0] = Parsed::template("'.$_name.'", $_attrs);');
                                $this->codebuffer->raw('$this->comp[0]->setSlots($slots);');
                                $this->codebuffer->raw('$this->comp[0]->render($this->data);');
                            });
                        }
                    }
                });
            }
        });
    }
}