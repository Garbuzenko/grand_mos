<?php
$botDir = __DIR__;

date_default_timezone_set("UTC"); // Устанавливаем часовой пояс по Гринвичу

// если бот работает с базой данных сайта
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/functions.php';

// конфигурационный файл бота
require_once $botDir.'/config.php';

// функции для телеграм ботов
require_once $_SERVER['DOCUMENT_ROOT'].'/bots/telegram/functions.php';

// функции для этого бота
require_once $_SERVER['DOCUMENT_ROOT'].'/modules/recom/functions.php';

// достаём из базы название и токен бота
$botInfo = db_query("SELECT * FROM bot_settings WHERE id=".$xc['bot_id']." LIMIT 1");

if ($botInfo == false) {
    exit();
}

$xc['bot_key'] = $botInfo[0]['token'];
$xc['bot_uniq_name'] = $botInfo[0]['name'];
// -----------------------------------------------------------------------------------------

$body = file_get_contents('php://input'); //Получаем в $body json строку
$arr = json_decode($body, true); //Разбираем json запрос на массив в переменную $arr

// что присылает бот
botAnswer($arr,$botDir,'test');
// -----------------------------------------------------------------------------------------

$xc['chat_id'] = 0;
$xc['user'] = getUserInfo($arr);

if (!empty($xc['user']['chat_id'])) {
    $xc['chat_id'] = $xc['user']['chat_id'];
    $xc['message_id'] = $xc['user']['message_id'];
}

// главное меню (которое под строкой ввода)
//require_once $botDir.'/modules/menu/buttons.php';
// -----------------------------------------------------------------------------------------

$xc['module'] = null;

// если кликают по кнопке под сообщением
if ( !empty($arr['callback_query']['data']) ) {
    $xc['m'] = explode('|',$arr['callback_query']['data']);
    $xc['module'] = $xc['m'][0].'/'.$xc['m'][1];
}
// -----------------------------------------------------------------------------------------

// определяем какой модуль будет работать с запросом
require_once $botDir.'/modules.php';
// -----------------------------------------------------------------------------------------

// авторизация
require_once $_SERVER['DOCUMENT_ROOT'].'/bots/telegram/login.php';
// -----------------------------------------------------------------------------------------

// подключение модуля, для обработки запроса бота
if (file_exists($botDir.'/modules/'.$xc['module'])) {
   require_once $botDir.'/modules/'.$xc['module'];
}
// -----------------------------------------------------------------------------------------

exit('ok');