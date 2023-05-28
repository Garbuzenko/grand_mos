<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

$botDir = __DIR__;

date_default_timezone_set("UTC"); // Устанавливаем часовой пояс по Гринвичу

// если бот работает с базой данных сайта
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/modules/recom/functions.php';

// конфигурационный файл бота
require_once $botDir.'/config.php';

// список модулей
require_once $botDir.'/modules.php';

// список кнопок главного меню
require_once $botDir.'/modules/menu/index.php';

// функции для голосовых навыков
require_once $_SERVER['DOCUMENT_ROOT'].'/bots/alisa/lib/functions.php';

$dataRow = file_get_contents('php://input');

try {
    if (!empty($dataRow)) {
        
        //Преобразуем запрос пользователя в массив
        $data = json_decode($dataRow, true);
        
        //Определим протокол (Сбер или Алиса)
        $protocol = get_protocol($data);

        file_put_contents('log/'. $protocol .'_input.txt', date('Y-m-d H:i:s') . PHP_EOL . $dataRow . PHP_EOL, FILE_APPEND);
        
        //Получим ответ
        $content =  main($protocol, $botDir, $data);

        $result = get_response( $protocol, $data, $content);
        
        file_put_contents('log/'. $protocol . '_output.txt', date('Y-m-d H:i:s') . PHP_EOL .   $result . PHP_EOL, FILE_APPEND);
        
        echo   $result ;
    }
    else {
        echo 'Empty data';
    }
}
    catch (Exception $e) {
        echo '["Error occured"]';
}
