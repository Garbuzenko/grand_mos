<?php

// достаём id пользователя
$text = $arr['message']['text'];
$user_id = str_replace('/start','',$text);
$user_id = trim( clearData($user_id,'int') );
$xc['user_id'] = 0;

// проверяем зарегистрирован ли пользователь на сайте
$a = db_query("SELECT *   
     FROM users  
     WHERE user_id='".$user_id."'  
     LIMIT 1");
     
if ( $a != false ) {
    
    $xc['user_id'] = $a[0]['user_id'];
    
    // если пользователь зарегистрирован, то добавляем его данные из телеграм
    $b = db_query("UPDATE users 
    SET 
    tg_id='".$xc['chat_id']."',
    username='".$arr['message']['chat']['username']."',
    first_name='".$arr['message']['chat']['first_name']."',
    last_name='".$arr['message']['chat']['last_name']."',
    activ=1 
    WHERE user_id=".$a[0]['user_id']." 
    LIMIT 1","u");
}

else {
     
     // проверяем зарегистрирован ли пользователь на сайте
     $isUser = db_query("SELECT user_id 
     FROM users WHERE tg_id='".$xc['chat_id']."' 
     LIMIT 1");
     
     if ($isUser != false) {
        $xc['user_id'] = $isUser[0]['user_id'];
     }
     
         
    if ( empty($arr['callback_query']['data']) && $isUser == false && $xc['module']!='services/index.php' && $xc['module']!='help/index.php' ) {
        
        $message = 'Вы зарегистрированы в проекте "Московское долголетие"?';
    
        $btnArr[] = array(
         'text' => 'Да',
         'field' => 'callback_data',
         'value' => 'login|sign_in.php|tg_message'
        );
    
        $btnArr[] = array(
         'text' => 'Нет',
         'field' => 'callback_data',
         'value' => 'login|quiz.php|tg_message'
        );
    
        $replyMarkup = getButtons($btnArr);
        sendMessage($xc['chat_id'],$message,$replyMarkup);
        exit('ok');
    }
    
    
}