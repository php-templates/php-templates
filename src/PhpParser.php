<?php

namespace PhpTemplates;

use PhpTemplates\Contracts\EventDispatcher;
use PhpTemplates\Dom\WrapperNode;
use PhpTemplates\Entities\AbstractEntity;
use PhpTemplates\Entities\SimpleNodeEntity;
use PhpTemplates\Entities\SlotEntity;
use PhpTemplates\Entities\TextNodeEntity;
use PhpTemplates\Entities\TemplateEntity;
use PhpTemplates\Entities\AnonymousEntity;
use PhpTemplates\Entities\Entity;
use PhpTemplates\Entities\ExtendEntity;
use PhpTemplates\Entities\VerbatimEntity;
use PhpDom\DomNode;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\BuilderFactory;
use PhpParser\Node\Name\FullyQualified;

class PhpParser
{
    /**
     * Pass parser in each entity, at the end gather an array of every parsed template and its meta
     */
    public function parse(ParsingTemplate $template): TemplateClassDefinition
    {
        $code = $template->getCode();
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $asts = $parser->parse($code);
        
        $ast = null;
        $uses = [];
        foreach ($asts as $_ast) {
            if ($_ast instanceof \PhpParser\Node\Stmt\Use_) {
                $use = implode('\\', $_ast->uses[0]->name->parts);
                if (!empty($_ast->uses[0]->alias->name)) {
                    $use .= ' as ' . $_ast->uses[0]->alias->name;
                }
                if (!in_array($use, $uses)) {
                    $uses[] = $use;
                }
            }
            if ($_ast instanceof \PhpParser\Node\Stmt\Return_) {
                $ast = $_ast;
                break;
            }
        }
        
        if (!$ast) {
            throw new \Exception("Error parsing template");
        }
        
        $ast = $ast->expr->class;
        
        $ast->name = 'PHPT_' . preg_replace('/[^A-Za-z0-9]/', '_', $template->getName() . '_' . uniqid());// todo replace non alfanum

        foreach ($ast->stmts as $i => $stmt) {
            if (! $stmt instanceof \PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            if (in_array($stmt->name, ['render', 'parsing', 'parsed'])) {
                unset($ast->stmts[$i]);
            }
        }
        /* todo, in parser
        $factory = new BuilderFactory;
        $config = '';
        if (strpos($name, ':')) {
            list($config) = explode(':', $name);
        }

 */
 
        return new TemplateClassDefinition($ast, $uses);
    }
}