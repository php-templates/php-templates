<?php
//todo remove fn src closure
namespace PhpTemplates\Entities;

use PhpTemplates\Parser;
use PhpTemplates\Closure;
use PhpDom\DomNode;
use PhpTemplates\Source;

class SimpleNodeEntity extends Entity
{
    /**
     * <tpl><div></div></tpl>
     */
    public function anonymousContext()
    {
        return $this->simpleNodeContext();
    }

    /**
     * <div><div></div></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        foreach ($this->node->getChildNodes() as $slot) {
            $this->child($slot)->parse();
        }

        $data->addToNode($this->node);
    }

    /**
     * <tpl extends="comp/x"><div></div></tpl>
     */
    public function extendContext()
    {
        $this->templateContext();
    }

    /**
     * <tpl is="comp/x"><div></div></tpl>
     */
    public function templateContext()
    {
        $data = $this->depleteNode($this->node);
        $data->addToNode($this->node);

        foreach ($this->node->getChildNodes() as $cn) {
            $this->child($cn)->parse();
        }
    }

    /**
     * <slot><div></div></slot>
     */
    public function slotContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * <div></div> -> when we call template->makeRaw('<div></div>');
     */
    public function startupContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * Never reached
     */
    public function textNodeContext()
    {}

    /**
     * Never reached
     */
    public function verbatimContext()
    {}
}
