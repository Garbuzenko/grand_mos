<?php
define('DOMAIN', 'https://'.$_SERVER['HTTP_HOST']);
define('YANDEX_API_KEY', '');
define('PASS_STR', '');

$xc = array();

// данные для подключения к БД
$xc['db_host'] = 'localhost';
$xc['db_name'] = '';
$xc['db_user'] = '';
$xc['db_pass'] = '';

$xc['update'] = true; 
$xc['noMainTmp'] = false;
$xc['admin_panel_only'] = false; // если нужна только админка, то при заходе на сайт будет сразу перенаправлять туда
$xc['admin_main_module'] = ''; // модуль по умолчанию (для главной страницы в админке)

$xc['ya_map'] = false; // яндекс карты
$xc['bottom_popup_window'] = false;
$xc['no_metrika'] = false;
$xc['telegram'] = false;
$xc['vk'] = false; 

$xc['title'] = '';
$xc['canonical'] = null;
$xc['close'] = array(
  'settings' => 1,
  'my-groups' => 1
);