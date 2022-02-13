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
        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);

        $phpStart = $this->controlStructures ? '' : '<?php ';
        $phpEnd = $this->controlStructures ? '' : ' ?>';

        $definition = '%s foreach ($this->slots("%s") as $_slot) {'
            .PHP_EOL.'$_slot->render(array_merge($this->data, %s));'
            .PHP_EOL.'} %s';

        $this->println(
            sprintf($definition, $phpStart, $this->attrs['name'], $dataString, $this->hasSlotDefault ? '' : $phpEnd)
        );

        if ($this->hasSlotDefault) {
            $this->println(sprintf('if (empty($this->slots("%s"))) {', $this->attrs['name']));

            foreach ($this->childNodes($this->node) as $slotDefault) {
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
        $phpStart = '';//'?php';
        $phpEnd = '';//'?';

        $data = $this->depleteNode($this->node);
        $dataString = Helper::arrayToEval($data);

        $definition = '%s foreach ($this->slots("%s") as $_slot) {'
            .PHP_EOL.'$this->comp[%d]->addSlot("%s", $_slot);'
            .PHP_EOL.'} %s';

        $this->println(
            sprintf($definition, $phpStart, $this->attrs['name'], $this->context->depth, $this->attrs['slot'], $this->hasSlotDefault ? '' : $phpEnd)
        );

        if ($this->hasSlotDefault) {
            $this->println(sprintf('if (empty($this->slots("%s"))) {', $this->attrs['name']));

            foreach ($this->childNodes() as $slotDefault) {
                $this->parseNode($slotDefault);
            }

            $this->println('} '.$phpEnd);
        }
    }
}