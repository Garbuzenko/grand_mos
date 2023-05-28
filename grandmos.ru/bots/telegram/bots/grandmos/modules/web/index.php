<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
session_start();

date_default_timezone_set("UTC"); // Устанавливаем часовой пояс по Гринвичу
header('Content-Type: text/html; charset=utf-8'); // устанавливаем кодировку

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/functions.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/bots/telegram/bots/shop/modules/web/config.php";

// ----------------------------------------- Ajax запросы ---------------------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] == 'ajax' && !empty($_POST['module'])) {
    
    $xc['module'] = clearData($_POST['module'], 'get');
    $xc['component'] = null;

    if (!empty($_POST['component']))
        $xc['component'] = 'components/' . clearData($_POST['component'], 'get') . '/';
    
    if (file_exists(__DIR__ . '/modules/' . $xc['module'] . '/' . $xc['component'] . 'index.php'))
        require_once __DIR__ . '/modules/' . $xc['module'] . '/' . $xc['component'] .'index.php';

    exit();
}
// ----------------------------------------------------------------------------------------------------------------------

// собираем css и js файлы со всех модулей и объединяем их в один (1 css и 1 js файл)
$xc['style'] = get_file('css', $xc['update'], false, WEB_BOT);
$xc['scripts'] = get_file('js', $xc['update'], false, WEB_BOT);
// ---------------------------------------------------------------------------------------------------------------------

// для поддключениее css и js файлов отдельного модуля
$xc['head'] = null;
$xc['body'] = null;

if (file_exists(__DIR__ . '/modules/' . $xc['module'] . '/' . $xc['component'] . 'head.php'))
    $xc['head'] .= file_get_contents(__DIR__ . '/modules/' . $xc['module'] .'/' . $xc['component'] . 'head.php');

if (file_exists(__DIR__ . '/modules/' . $xc['module'] . '/' . $xc['component'] . 'body.php'))
    $xc['body'] .= file_get_contents(__DIR__ . '/modules/' . $xc['module'] .'/' . $xc['component'] . 'body.php');
// ---------------------------------------------------------------------------------------------------------------

// подключаем модуль для всплывающих окон
$xc['popup'] = null;

if (file_exists(__DIR__ . '/modules/popup/includes/popupWindows.inc.php')) {
    ob_start();
    include __DIR__ . '/modules/popup/includes/popupWindows.inc.php';
    $xc['popup'] = ob_get_clean();
}
// ---------------------------------------------------------------------------------------------------------------

// подключаем модуль для формирования меню
require_once __DIR__ . '/modules/menu/index.php';
// ---------------------------------------------------------------------------------------------------------------

// элементы главного шаблона
$xc['header'] = null;
$xc['footer'] = null;
$xc['menu'] = null;
$xc['js'] = null;

$tmpBlocks = @scandir(__DIR__.'/tmp');

if ($tmpBlocks != false) {
    foreach($tmpBlocks as $tmpBlock) {
        if ($tmpBlock != '.' && $tmpBlock != '..' && $tmpBlock != 'tmp.inc.php' && $tmpBlock != 'mob.inc.php' ) {
            if (@filesize(__DIR__.'/tmp/'.$tmpBlock) > 0) {
                
                $tmpBaseName = str_replace('.inc.php','',$tmpBlock);
                
                ob_start();
                include __DIR__.'/tmp/'.$tmpBlock;
                $xc[$tmpBaseName] = ob_get_clean();
            }
        }
    }
}
// ---------------------------------------------------------------------------------------------------------------

// подключение главного шаблона
if (MOBILE == true && file_exists(__DIR__ . '/mob.inc.php'))
    require_once __DIR__ . '/tmp/mob.inc.php';

else
    require_once __DIR__ . '/tmp/tmp.inc.php';
// ----------------------------------------------------------------------------------------------------------------

?>