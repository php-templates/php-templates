<?php

require('./../autoload.php');

use PhpTemplates\Facades\Template;
use PhpTemplates\DomEvent;
use PhpTemplates\Config;

Config::set('src_path', __DIR__.'/views/');
Config::set('dest_path', __DIR__.'/results/');
Config::set('aliased', [
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper',
]);

$folder_path = Config::get('dest_path').'*';
$files = glob($folder_path);//dd($folder_path);
foreach($files as $file) {
    if (is_file($file)) unlink($file);
}

$data['entry_firstname'] = 'Firstname';
$data['firstname'] = 'Florin';
$data['entry_lastname'] = 'Lastname';
$data['lastname'] = 'Botea';
$data['entry_gender'] = 'Gender';
$data['entry_email'] = 'Email';
$data['email'] = 'florin@email.com';
$data['gender'] = 'male';
$data['entry_male'] = 'Male';
$data['entry_female'] = 'Femele';
/*
// DomEvents to manipulate the original
// add an event on rendering user-profile-form.form-fields block
DomEvent::on('rendering', 'user-profile-form.form-fields', function($t, $data) {
    // $t is the block instance and we can add slots to any position using index
   // we can pass $data by reference and manipulate it too, manipulating $t->data won't take any effect in that stage 
   
    // we call Template::get to load a template with data. If the template is already loaded above, in user-profile-form, won't be done a new file request
    $extraField = Template::get('components/form-group', [
        'type' => 'text',
        'label' => 'Event added',
        'value' => 'Priceless',
        'class' => 'bg-success',
        '_index' => -1
    ]);
    $extraField2 = Template::get('components/form-group', [
        //'type' => 'text',
        'label' => 'Event added2',
        //'value' => 'Priceless2',
        'class' => 'bg-success',
        '_index' => 3,
    ]);
    // we can add slots programatically like this, in this case the compoment will be parsed&cached separate from the rest
    $extraField2->addSlot('default', Template::get('components/input-group', [
        'type' => 'select',
        'options' => ['o1' => 'o1', 'o2' => 'o2'],
        'value' => 'o2',
    ]));
    // we can have a non parsable template like this (pure php and html). It will produce a Parsed instance with no name
    $btn = Template::raw(function() {
        echo '<div class="text-right bg-success">
            <button class="btn btn-primary">Submit</button>
        </div>';
    }, ['_index' => 999]);
    // we can remove an element
    $removed = $t->slots['form-fields'][4];
    unset($t->slots['form-fields'][4]);
    $t->slots['form-fields'][] = $extraField;
    $t->slots['form-fields'][] = $extraField2;
    $t->slots['form-fields'][] = $btn;
    // we can change an element context and position
    $removed->data['class'] = 'bg-danger';
    $removed->render($data);
});

DomEvent::on('rendering', 'components/navbar.nav-items', function($t, $data) {
    $navItem = $t->addSlot('nav-items', Template::get('components/dropdown', [
        '_index' => 99,
        'text' => 'Event Added'
    ]));
    $navItem->addSlot('default', Template::raw(function() { ?>
      <a class="dropdown-item" href="#">Action</a>
      <a class="dropdown-item" href="#">Another action</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Something else here</a> <?php
    }));
});

// we can limitate by index renders like this
// Info: returning false on event rendering component will cancel its rendering
$x = false;
DomEvent::on('rendering', 'user-profile-form.components/card', function($t, $data) use (&$x) {
    if ($x) {
        return;
    }
    $x = true;
    
    // we can fully change layout, wrapping template in tabs
    $tabs = Template::get('components/tabs', [
        'tabs' => [
            'user-profile-form' => 'Form',
            'stats' => 'Stats'
        ]
    ]);
    $tabs->addSlot('default', Template::raw(function() use ($t, $data) { ?>
        <div class="tab-pane fade show active" id="user-profile-form" role="tabpanel">
            <?php $t->render($data); ?>
        </div> <?php
    }));
    $tabs->addSlot('default', Template::raw(function() use ($t, $data) { ?>
        <div class="tab-pane fade show" id="stats" role="tabpanel">
            <?php Template::get('stats', $data)->render($data); ?>
        </div> <?php
    }));
    $tabs->render($data);
    
    return false;
});

for ($i=0;$i<=50;$i++) {
    $products[] = [
        'name' => uniqid(),
        'price' => rand(0, 100)
    ];
}

DomEvent::on('rendering', 'user-profile-form.components/tabs', function($t, &$data) use($products) {
    $data['tabs']['pics'] = 'Pictures';
    $data['products'] = $products;
    $t->addSlot('default', Template::raw(function() use ($t, $data) { ?>
        <div class="tab-pane fade show" id="pics" role="tabpanel">
            <?php Template::get('products', $data)->render($data); ?>
        </div> <?php
    }));
});*/
// dom events end

// the original
Template::load('user-profile-form', $data);