<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['categories/view/(:any)'] = 'categories/view/$1';
$route['pos/items'] = 'items/index';
$route['dashboard'] = 'dashboard/index';

$route['default_controller'] = 'login/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
