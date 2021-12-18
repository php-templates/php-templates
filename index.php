<?php

require('autoload.php');

use DomDocument\PhpTemplates\Facades\Template;
use DomDocument\PhpTemplates\Facades\Config;

if ($_GET['plain'] ?? false) {
header("Content-Type: text/plain");
}
$doc = $_GET['file'] ?? 'test';

Config::set('aliased', [
    'x-form-group' => 'components/form-group',
    'x-input-group' => 'components/input-group',
    'x-card' => 'components/card',
    'x-helper' => 'components/helper',
]);

$data['entry_firstname'] = 'Prenume';
$data['firstname'] = 'Florin';
$data['entry_lastname'] = 'Nume';
$data['lastname'] = 'Botea';
$data['entry_gender'] = 'Sex';
$data['entry_email'] = 'Email';
$data['email'] = 'florin@email.com';
$data['gender'] = 'male';
$data['entry_male'] = 'Masculin';
$data['entry_female'] = 'Feminin';

echo Template::load($doc, $data);
die();



echo Template::load($doc, $data, [
    'slot1' => Template::component('simple-component', ['s1' => 123]),
    'slot-array' => [
        Template::component('simple-component'),
        Template::component('simple-component', ['s1' => 123]),
    ]
]);