<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Helper;
use PhpTemplates\TemplateFunction;
use PhpTemplates\ViewParser;
use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\Source;
use PhpTemplates\Dom\Parser;

class Extends extends Component
{
    protected $attrs = [
        'template' => null,
        'is' => null
    ];

    public function rootContext() {
        $data = $this->depleteNode($this->node);
        $dataString = $this->fillNode(null, $data);

        //$dataString = Helper::arrayToEval($data);

        $nodeValue = sprintf('<?php $this->comp["%s"] = $this->template("%s", $context); ?>',
            $this->id, $this->name
        );
        $this->node->changeNode('#php', $nodeValue);
        //dd($nodeValue);
        foreach ($this->node->childNodes as $slot) {
            //todo: grupam dupa slots o fn ceva?
            $this->factory->make($slot, $this)->parse();
        }

        $r = sprintf('<?php $this->comp["%s"]->render(); ?>', $this->id);
        $this->node->appendChild(new DomNode('#php', $r));
    }
}