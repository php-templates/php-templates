<?php

namespace PhpTemplates;

use PhpTemplates\Dom\DomNode;
use PhpTemplates\Entities\EntityInterface;
use PhpTemplates\Cache\CacheInterface;
use PhpTemplates\EventHolder;
use PhpTemplates\Config;

//TODO: RENAME INTO NODEPARSER
class NodeParser
{
    private $document;
    private $config;
    private $eventHolder;

    private $entities = [];

    public function __construct(CacheInterface $document, Config $config, EventHolder $eventHolder)
    {
        $this->document = $document;
        $this->config = $config;
        $this->eventHolder = $eventHolder;

        $this->globEntities();
    }

    public function make(DomNode $node, EntityInterface $context)
    {

        foreach ($this->entities as $entity) {
            if ($entity::test($node, $context)) {
                return new $entity($node, $context->getConfig(), $context, $this->document, $this, $this->eventHolder);
            }
        }
    }

    private function globEntities()
    {
        $files = array_filter(glob(__DIR__ . '/Entities/*'), 'is_file');

        $entities = [];
        foreach ($files as $file) {
            if (strpos($file, 'Abstract') || strpos($file, 'Interface') || strpos($file, 'StartupEntity')) {
                continue;
            }

            $entity = preg_split('/(\\/|\\\)/', $file);
            $entity = str_replace('.php', '', end($entity));
            $entity = '\\PhpTemplates\\Entities\\' . $entity;
            $entities[] = $entity;
        }

        usort($entities, function($b, $a) {
            return $a::WEIGHT - $b::WEIGHT;
        });

        $this->entities = $entities;
    }
}