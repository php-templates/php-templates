<?php

namespace PhpTemplates;
require('../autoload.php');

use PhpTemplates\Template;
use PhpTemplates\TemplateRepository;
use PhpTemplates\Context;

$context = new Context();
$context->x = 123;
$context->x = 12;
dd($context->x);

$tr = new TemplateRepository();
$tr->add('default:props/c', function (Context $context) {
   $context->val = [1,2]; $context->name = "myname";   ?>
  <c>
        <?php  $context->loopStart(); foreach ($this->slots("default") as $slot) {
            ($slot)(['val' => $context->val, 'name' => $context->name]);
          } $context->loopEnd();  ?>
  </c> <?php
});
$tr->add('default:comp/comp_slot', function (Context $context) {
?>
  <div class="comp_slot">
    <span>
          <?php  $context->loopStart(); foreach ($this->slots("default") as $slot) {
              ($slot)(['name' => $context->name]);
            } $context->loopEnd();  ?>
    </span>
  </div> <?php
});
$x = new Template($tr, 'default:./temp/props2', function () {
    $context = new Context;
    $this->comp["62f3e2389c8b8"] = $this->template("default:props/c", new Context([]));
      $this->comp["62f3e2389c8b8"]->addSlot("default", function(array $data = []) use ($context) {
        $context = $context->subcontext($data);  ?>
    1<?php  e($context->name);
      });
      $this->comp["62f3e2389c8b8"]->addSlot("default", function(array $data = []) use ($context) {
        $context = $context->subcontext($data);
          $this->comp["62f3e2389dc66"] = $this->template("default:comp/comp_slot", new Context([]));
            $this->comp["62f3e2389dc66"]->addSlot("default", function(array $data = []) use ($context) {
              $context = $context->subcontext($data); dd($context); ?>2<?php  e($context->name);
            });
            $this->comp["62f3e2389dc66"]->render();
      });
      $this->comp["62f3e2389c8b8"]->render();  ?>
-----
 <?php
});

$x->render();