<?php

require('./../autoload.php');

use PhpTemplates\Template;
use PhpTemplates\DomEvent;
use PhpTemplates\Config;
use PhpTemplates\Dom\DomNode;

$template = new Template(__DIR__.'/views/', __DIR__.'/results/');
$aliases =[
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper',
];
foreach ($aliases as $k => $val) {
    $template->addAlias($k, $val);
}

$folder_path = __DIR__.'/results/*';
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

// DomEvents to manipulate the original Dom
// add an event on rendering user-profile-form.form-fields block
DomEvent::on('parsing', 'user-profile-form', function($node) {
    $extraField = new DomNode('x-form-group', [
        'type' => 'text',
        'label' => 'Event added',
        'value' => 'Price',
        'class' => 'bg-success',
        '_index' => -1
    ]);
    $extraField2 = new DomNode('x-form-group', [
        'label' => 'Event added2',
        'class' => 'bg-success',
        '_index' => 3,
    ]);
    
    // we can add slots programatically like this, in this case the compoment will be parsed&cached separate from the rest
    // note that we specified options atrribute with bind syntax
    $extraField2->appendChild(new DomNode('x-input-group', [
        'type' => 'select',
        ':options' => ['o1' => 'o1', 'o2' => 'o2'],
        'value' => 'o2',
    ]));
    
    // we can add raw html nodes like this
    $btn = DomNode::fromString(
        '<div class="text-right bg-success" _index="999">
            <button class="btn btn-primary">Submit</button>
        </div>'
    );
    // we can remove an element
    $removed = $node->querySelectorAll('x-form-group')[4];
    $removed->detach();
    
    // append newly generated nodes
    $block = $node->querySelector('block[name="form-fields"]');
    $block->appendChild($extraField);
    $block->appendChild($extraField2);
    $block->appendChild($btn);
    
    // we can change an element context and position
    $removed->addAttribute('class', 'bg-danger');
    $node->appendChild($removed);
});

DomEvent::on('parsing', 'components/navbar', function($node) {
    $navItems = $node->querySelector('block[name="nav-items"]');
    $navItem = $navItems->appendChild(new DomNode('template', [
        'is' => 'components/dropdown',
        '_index' => 99,
        'text' => 'Event Added'
    ]));
    $navItem->appendChild(DomNode::fromString(
      '<a class="dropdown-item" href="#">Action</a>
      <a class="dropdown-item" href="#">Another action</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#">Something else here</a>'
    ));
});

DomEvent::on('parsing', 'user-profile-form', function($node) {
    $formCard = $node->querySelector('x-card[title="My"]');
    // we can fully change layout, wrapping template in tabs
    $tabs = $formCard->parentNode->insertBefore(new DomNode('template', [
        'is' => 'components/tabs', 
        ':tabs' => [
            'user-profile-form' => 'Form',
            'stats' => 'Stats'
        ]
    ]), $formCard);
    
    // we detach main node, given on callback function and wrap it within a tab
    $tab = $tabs->appendChild(DomNode::fromString(
        '<div class="tab-pane fade show active" id="user-profile-form" role="tabpanel"></div>'
    ));
    $tab->querySelector('div')->appendChild($formCard->detach());
    
    $tab = $tabs->appendChild(DomNode::fromString(
        '<div class="tab-pane fade show" id="stats" role="tabpanel"></div>'
    ));
    $tab->querySelector('div')->appendChild(new DomNode('template', ['is' => 'stats']));
    
    return $tabs;
});

for ($i=0;$i<=50;$i++) {
    $products[] = [
        'name' => uniqid(),
        'price' => rand(0, 100)
    ];
}

DomEvent::on('rendering', 'user-profile-form', function($node) use($products) {
    $tabs = $node->querySelector('template[is="components/tabs"]');
    $tabs->setAttribute(':tabs', str_replace(')', "pics => 'Pictures')", $tabs->getAttribute(':tabs')));
    
    $data['products'] = $products;
    $t->addSlot('default', Template::raw(function() use ($t, $data) { ?>
        <div class="tab-pane fade show" id="pics" role="tabpanel">
            <?php Template::get('products', $data)->render($data); ?>
        </div> <?php
    }));
});
// dom events end

// the original
$template->load('user-profile-form', $data);