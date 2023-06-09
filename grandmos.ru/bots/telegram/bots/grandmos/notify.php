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

// достаём из базы название и токен бота
$botInfo = db_query("SELECT * FROM bot_settings WHERE id=".$xc['bot_id']." LIMIT 1");

if ($botInfo == false) {
    exit();
}

$xc['bot_key'] = $botInfo[0]['token'];
$xc['bot_uniq_name'] = $botInfo[0]['name'];

$mes = $_GET['mes'];
$chat_id = clearData($_GET['chat_id'],'int');

if ($mes == 'quiz') {
    
    $user_id = clearData($_GET['user_id'],'int');

    $message = 'Подборка курсов для вас';

    $btnArr[] = array(
      'text' => 'Посмотреть',
      'field' => 'web_app',
      'value' => array('url' => 'https://grandmos.ru/tg?user='.$user_id)
    );
    
    $replyMarkup = getButtons($btnArr);
    
    sendMessage($chat_id,$message,$replyMarkup);
    
}
exit('ok');