<?php

namespace PhpTemplates\Entities;

use PhpTemplates\Config;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Source;
use PhpTemplates\Dom\Parser;
use PhpTemplates\Closure;
use PhpTemplates\Dom\PhpNodes\SlotAssign;

class TemplateEntity extends AbstractEntity
{ // de documentat p-scope scos default $slot
    const WEIGHT = 100;

    protected $attrs = [
        'is' => null,
    ];

    public static function test(DomNode $node, EntityInterface $context): bool
    {
        if (!$node->nodeName) {
            return false;
        }

        if ($node->nodeName == 'tpl' && $node->hasAttribute('is')) {
            return true;
        }

        $config = $context->getConfig();

        return !!$config->getAliased($node->nodeName);
    }

    /**
     * <div><tpl is="comp/x"></tpl></div>
     */
    public function simpleNodeContext()
    {
        $data = $this->depleteNode($this->node);
        $dataString = $data->toArrayString();

        $nodeValue = sprintf(
            '<?php $this->comp["%s"] = $this->template("%s", new Context(%s)); ?>',
            $this->id,
            $this->name,
            $dataString
        );
        $this->node->changeNode('#php', '');
        $slots = $this->parseSlots($this->node);
        $this->node->appendChild(new DomNode('#php', $nodeValue));

        foreach ($slots as $slot) {
            $this->node->appendChild($slot);
            $this->factory->make($slot, new StartupEntity($this->config))->parse();
        }

        $nodeValue = sprintf('<?php $this->comp["%s"]->render(); ?>', $this->id);
        $this->node->appendChild(new DomNode('#php', $nodeValue));
    }

    /**
     * Unreachable because of Dom manipulation in self::simpleNodeContext
     */
    public function templateContext()
    {
    }

    /**
     * Unreachable because of Dom manipulation in self::simpleNodeContext
     */
    public function extendContext()
    {
    }

    /**
     * <slot><tpl is="comp/x"></tpl></slot>
     */
    public function slotContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * <tpl><tpl is="comp/x"></tpl></tpl>
     */
    public function anonymousContext()
    {
        $this->simpleNodeContext();
    }

    /**
     * <tpl is="comp/x"></tpl> -> entry point of a normal parse
     */
    public function startupContext()
    {
        return $this->simpleNodeContext();
    }

    /**
     * Never reached
     */
    public function textNodeContext()
    {
    }

    /**
     * Never reached
     */
    public function verbatimContext()
    {
    }

    /**
     * Resolve/separately parse this componnt template into a new process and store the results into current cache
     *
     * @param CacheInterface $cache
     * @param EventHolder $eventHolder
     * @return void
     */
    public function resolve(CacheInterface $cache, EventHolder $eventHolder)
    {
        $config = $this->context->getConfig();
        if ($this->node->nodeName == 'tpl' && $this->node->hasAttribute('is')) {
            $rfilepath = $this->node->getAttribute('is');
        } else {
            $rfilepath = $config->getAliased($this->node->nodeName);
        }

        // aliased may return domain:rfilepath in case of not directly own the alias, or refer directly from module namespace
        if (strpos($rfilepath, ':')) {
            list($cfgKey, $rfilepath) = explode(':', $rfilepath);
            $config = $config->getRoot()->find($cfgKey);
        }

        if (!$config->isDefault()) {
            $this->name = $config->getName() . ':' . $rfilepath;
        } else {
            $this->name = $rfilepath;
        }

        // cache already has this template, no parse needed
        if ($cache->has($this->name)) {
            return;
        }

        $srcFile = $this->resolvePath($rfilepath, $config);
        // add file as dependency to template for creating hash of states
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

        $eventHolder->event('parsing', $this->name, $node);
        is_callable($cb) && $cb($node, $eventHolder);

        $entity = $this->factory->make($wrapper, new StartupEntity($config));
        $entity->simpleNodeContext();

        $eventHolder->event('parsed', $this->name, $wrapper);

        $fnSrc = (string)$this->buildTemplateFunction($node);

        $fn = Closure::fromSource(new Source($fnSrc, $srcFile), 'namespace PhpTemplates;');

        $cache->set($this->name, $fn, new Source($fnSrc, $srcFile));
    }

    /**
     * Gain a relative path and test it against config paths with fallback on default config (in case)
     *
     * @param string $rfilepath
     * @param Config $config
     * @return string
     */
    private function resolvePath(string $rfilepath, Config $config): string
    {
        $srcFile = null;
        // try to find file on current config, else try to load it from default config
        foreach ($config->getPath() as $srcPath) {
            $filepath = rtrim($srcPath, '/') . '/' . $rfilepath . '.t.php';
            if (file_exists($filepath)) {
                $srcFile = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        // file not found in any2 config
        if (!$srcFile) {
            $message = implode(' or ', $tried);
            throw new \Exception("View file $message not found");
        }

        return $srcFile;
    }

    /**
     * Returns an associative array containing assigned component slots grouped under their positions
     *
     * @param DomNode $node
     * @return array
     */
    protected function parseSlots(DomNode $node): array
    {
        $slots = [];
        foreach ($node->childNodes as $cn) {
            $pos = $cn->getAttribute('slot');
            $cn->removeAttribute('slot');
            $pos = $pos ? $pos : 'default';
            if (!isset($slots[$pos])) {
                $slots[$pos] = new SlotAssign($this->id, $pos);
            }
            $slots[$pos]->appendChild($cn->detach());
        }
        return array_reverse($slots);
    }
}
