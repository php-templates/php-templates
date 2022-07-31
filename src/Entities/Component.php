<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\ViewParser;
use PhpTemplates\Config;
use PhpTemplates\Dom\DomNode;

class Component extends AbstractEntity
{
    protected $attrs = ['is' => null];

    public function __construct(ViewParser $parser, Config $config, DomNode $node, string $name, AbstractEntity $context)
    {
        parent::__construct($parser, $config, $node, $context);

        $this->name = $name;
    }
    
    public function simpleNodeContext()
    {
        $this->rootContext();
    }
    
    public function rootContext()
    {
        $data = $this->depleteNode($this->node);
        $data = $this->fillNode(null, $data);

        $dataString = Helper::arrayToEval($data);
       
        $nodeValue = sprintf('<?php $this->comp["%s"] = $this->template("%s", %s); ?>', 
            $this->id, $this->name, $dataString
        );      
        $this->node->changeNode('#php', $nodeValue);
//dd($nodeValue);
        foreach ($this->node->childNodes as $slot) {
            $this->parser->parseNode($slot, $this->config, $this);
        }

        $r = sprintf('<?php $this->comp["%s"]->render(); ?>', $this->id);
        $this->node->appendChild(new DomNode('#php', $r));
    }

    /**
     * When a component is passed as slot to another component
     */
    public function componentContext()
    {
        $this->attrs['slot'] = 'default';
        
        $wrapper = new DomNode('#slot');
        $this->node->parentNode->insertBefore($wrapper, $this->node);
        $wrapper->appendChild($this->node->detach());
        
        //$data = $this->depleteNode($this->node);
        //$data = $this->fillNode(null, $data);   
        //$dataString = Helper::arrayToEval($data);
        $wrapper->setAttribute('slot', $this->node->getAttribute('slot') ?? 'default');
//dd($this->id);
        $this->parser->parseNode($wrapper, $this->config, $this->context);
        return;
        //if (!$this->process->hasTemplateFunction($this->name)) {
            //(new Root($this->process, null, $this->name, $this->context))->rootContext();
        //}

        $r = sprintf('<?php $this->comp["%s"] = $this->comp["%s"]->addSlot("%s", $this->template("%s", %s)); ?>', 
            $this->id, $this->context->getId(), $this->attrs['slot'], $this->name, $dataString
        );
        $this->node->changeNode('#php', $r);
        
        foreach ($this->node->childNodes as $slot)
        {
            $this->parseNode($slot);
        }
    }

    /**
     * When component is passed as block default
     */
    public function blockContext()
    {
        $this->node->setAttribute('slot', $this->context->name);
        $this->componentContext();
    }

    /**
     * When a component is passed as slot default
     */
    public function slotContext()
    {
        $this->rootContext();
    }
    
    public function templateContext() {
        $this->simpleNodeContext();
    }
    
    private function register()
    {
        $node = $this->load($name, $config);
        $this->parseNode($node, $config);
        $tplfn = $this->nodeToTemplateFunction($node);
        
        $this->document->addTemplate($name, $tplfn);
    }
}