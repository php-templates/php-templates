<?php
//todo remove fn src closure
namespace PhpTemplates\Entities;

use PhpTemplates\Parser;
use PhpTemplates\Closure;
use PhpDom\DomNode;
use PhpTemplates\Source;

class SimpleNodeEntity extends Entity
{
    public function startupContext() 
    {
        $this->simpleNodeContext();
    }
    
    /**
     * <div><div></div></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        foreach ($this->node->getChildNodes() as $cn) {
            $this->child($cn)->simpleNodeContext();
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
            $this->child($cn)->simpleNodeContext();
        }
    }

    /**
     * <slot><div></div></slot>
     */
    public function slotContext()
    {
        $this->simpleNodeContext();
    }
}
