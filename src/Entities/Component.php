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

class Component extends AbstractEntity
{
    protected $attrs = [
        'is' => null,
        'p-scope' => null
    ];

    public function simpleNodeContext() {
        $this->rootContext();
    }

    public function rootContext() {
        $data = $this->depleteNode($this->node);
        $dataString = $this->fillNode(null, $data);

        //$dataString = Helper::arrayToEval($data);

        $nodeValue = sprintf('<?php $this->comp["%s"] = $this->template("%s", new Context(%s)); ?>',
            $this->id, $this->name, $dataString
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

    /**
    * When a component is passed as slot to another component
    */
    public function componentContext() {
        //dd('nu va mai ajunge aici');
        $this->attrs['slot'] = 'default';

        $wrapper = new DomNode('#slot');
        $this->node->parentNode->insertBefore($wrapper, $this->node);
        $wrapper->appendChild($this->node->detach());

        //$data = $this->depleteNode($this->node);
        //$data = $this->fillNode(null, $data);
        //$dataString = Helper::arrayToEval($data);
        $wrapper->setAttribute('slot', $this->node->getAttribute('slot') ?? 'default');
        //dd($this->id);
        $this->factory->make($wrapper, $this->context)->parse();
        return;
        //if (!$this->process->hasTemplateFunction($this->name)) {
        //(new Root($this->process, null, $this->name, $this->context))->rootContext();
        //}

        $r = sprintf('<?php $this->comp["%s"] = $this->comp["%s"]->addSlot("%s", $this->template("%s", new Context(%s))); ?>',
            $this->id, $this->context->getId(), $this->attrs['slot'], $this->name, $dataString
        );
        $this->node->changeNode('#php', $r);

        foreach ($this->node->childNodes as $slot) {
            $this->parseNode($slot);
        }
    }

    /**
    * When component is passed as block default
    */
    public function blockContext() {
        $this->node->setAttribute('slot', $this->context->name);
        $this->componentContext();
    }

    /**
    * When a component is passed as slot default
    */
    public function slotContext() {
        $this->rootContext();
    }

    public function templateContext() {
        $this->simpleNodeContext();
    }

    private function registhgfcvder() {
        $node = $this->load($name, $config);
        $this->parseNode($node, $config);
        $tplfn = $this->nodeToTemplateFunction($node);

        $this->document->addTemplate($name, $tplfn);
    }
    
    public function resolve(Document $document, EventHolder $eventHolder)
    {
        $this->name = $this->node->getAttribute('is');
        
        if ($document->hasTemplate($this->name)) {
            return;
        }
        
        if (strpos($this->name, ':')) {
            // get own config
            list($configKey, $rfilepath) = explode(':', $this->name);
            $config = $this->config->getHolder()->get($configKey);
        } else {
            // get parent config
            $config = $this->config;
            $rfilepath = $this->name;
        }
        
        $srcFile = $this->resolvePath($rfilepath, $config);
        // add file as dependency to template for creating hash of states
        //$this->process->addDependencyFile($srcFile);
        ob_start();
        $cb = require($srcFile);
        $source = ob_get_contents();
        ob_end_clean();
        
        $source = new Source($source, $srcFile);
        $parser = new Parser();
        $node = $parser->parse($source);
        
        // we create a virtual dom to make impossible loosing actual node inside events (which would break the system)
        $wrapper = new DomNode('#root');
        $wrapper->appendChild($node->detach());
        //$name = $config->getName() . ':' . $rfilepath;
        
        $eventHolder->event('parsing', $this->name, $node);
        is_callable($cb) && $cb($node, $eventHolder);
        
        $entity = $this->factory->make($wrapper, null, $config);
        $entity->simpleNodeContext();
        
        $eventHolder->event('parsed', $this->name, $wrapper);
        
        $this->register($wrapper);
    }
    
    private function resolvePath($rfilepath, Config $config) 
    {
        $srcFile = null;
        // try to find file on current config, else try to load it from default config
        foreach ($config->getPath() as $srcPath) {
            $filepath = rtrim($srcPath, '/').'/'.$rfilepath.'.t.php';
            if (file_exists($filepath)) {
                $srcFile = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        // file not found in any2 config
        if (!$srcFile) {
            $message = implode(' or ', $tried);
            throw new \Exception("Template file $message not found");
        }        
        
        return $srcFile;
    }
    
    private function register(DomNode $node) 
    {
        $fnDeclaration = 'function (Context $context) {' . PHP_EOL
        //. '$data["_attrs"] = isset($data["_attrs"]) ? $data["_attrs"] : [];' . PHP_EOL
        //. 'extract($data);' . PHP_EOL
        . '?> '. $node .' <?php' . PHP_EOL
        . '}';
        
        $this->document->addTemplate($this->name, $fnDeclaration);
    }
}