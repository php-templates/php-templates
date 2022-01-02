<?php

require('./../autoload.php');

use DomDocument\PhpTemplates\Facades\Template;
use DomDocument\PhpTemplates\DomEvent;
use DomDocument\PhpTemplates\Facades\Config;

Config::set('src_path', __DIR__.'/views/');
Config::set('dest_path', __DIR__.'/results/');
Config::set('aliased', [
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper',
]);

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

new DomEvent('rendering', 'user-profile-form.form-fields', function($t, $data) {
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
    $extraField2->addSlot('default', Template::get('components/input-group', [
        'type' => 'select',
        'options' => ['o1' => 'o1', 'o2' => 'o2'],
        'value' => 'o2',
        //'class' => 'bg-success',
        //'_index' => 3,
    ]));
    $t->slots['form-fields'][] = $extraField;
    $t->slots['form-fields'][] = $extraField2;
});

Template::load('user-profile-form', $data);