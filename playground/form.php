<?php

require('./../autoload.php');

use DomDocument\PhpTemplates\Facades\Template;
use DomDocument\PhpTemplates\Facades\Config;

Config::set('src_path', './views/');
Config::set('dest_path', './results/');
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

Template::load('user-profile-form', $data);