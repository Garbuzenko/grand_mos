<?php
// смотрим есть ли пользователь с этим телеграм id

$tg_id = clearData($xc['url']['tg_id'],'int');

$isUser = db_query("SELECT user_id 
 FROM users 
 WHERE tg_id='".$tg_id."' 
 LIMIT 1"); 
 
 // если пользователь ещё не авторизован
 if ($isUser == false) {
    $us = db_query("SELECT user_id, age, gender FROM users WHERE test=1");
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/tg/components/login/includes/signIn.inc.php';
    $html = ob_get_clean();
 }

 else {
    // если пользователь уже авторизован через телеграм
     // присваиваем метку    
    setcookie('user_id', $isUser[0]['user_id'], time() + 3600 * 24 * 30, '/');
    
    // загружаем рекомендованные курсы
    $xc['telegram'] = true;
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/index.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/tmp.inc.php';
    $html = ob_get_clean();
 }