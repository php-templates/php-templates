<?php

namespace PhpTemplates;

use Closure;
use PhpTemplates\Closure as PhpTemplatesClosure;

// todo rename into view
class Template
{
    /**
     * Called template function name
     * @var string
     */
    protected $name;

    /**
     * Data passed to component using node attributes
     *
     * @var Context
     */
    public $context;

    /**
     * render function to be called
     * @var Closure
     */
    protected $func;

    /**
     * Array of closures keyed by slot position
     * @var array
     */
    public $slots = [];

    public $comp; //TODO: findout

    public function __construct(ViewFactory $repository, $name, PhpTemplatesClosure $fn, Context $context = null)
    {
        $this->repository = $repository;
        $this->name = $name;
        $this->context = $context;

        $this->func = $fn->bindTo($this);
    }

    /**
     * Render the template
     *
     * @return void
     */
    public function render()
    {
        $eventHolder = $this->repository->getEventHolder();
        $eventHolder->event('rendering', $this->name, $this->context);
        //TODO render event
        $func = $this->func;
        $func($this->context);
    }

    /**
     * Set data to template
     *
     * @param array $data
     * @return self
     */
    public function with(array $data = []): self
    {
        if (!$this->context) {
            $this->context = new Context($data);
        } else {
            $this->context->merge($data);
        }

        return $this;
    }

    /**
     * Add slot closure to given position
     *
     * @param string $pos
     * @param Closure $renderable
     * @return self
     */
    public function addSlot(string $pos, Closure $renderable): self
    {
        $this->slots[$pos][] = $renderable;

        return $this;
    }

    /**
     * Returns closures array for slot located at given position
     *
     * @param  $pos
     * @return array
     */
    public function slots($pos): array
    {
        if (isset($this->slots[$pos])) {
            return $this->slots[$pos];
        }
        return [];
    }

    /**
     * Absolutely set all slots array overriding any existing slot
     *
     * @param array $slots
     * @return self
     */
    public function setSlots(array $slots): self
    {
        $this->slots = $slots;

        return $this;
    }

    /**
     * Instantiate a new template from cache, within given context
     *
     * @param string $name
     * @param Context|null $context
     * @return self
     */
    public function template(string $name, Context $context = null): self
    {
        return $this->repository->get($name, $context);
    }
}
