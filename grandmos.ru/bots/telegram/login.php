<?php
$xc['lang'] = 'ru';

// проверяем зарегистрирован ли пользователь в боте
$a = db_query("SELECT *   
     FROM users  
     WHERE tg_id='".$xc['chat_id']."' 
     AND bot='".$xc['bot_uniq_name']."' 
     LIMIT 1");
     
if ( $a == false ) {
    
    if ( !empty($xc['chat_id']) ) {
        
        // записываем данные пользователя в базу
        $b = db_query("INSERT INTO users (
        reg_date,
        tg_id,
        username,
        first_name,
        last_name,
        activ,
        bot) VALUES (
        '".date('Y-m-d')."',
        '".$xc['chat_id']."',
        '".$arr['message']['chat']['username']."',
        '".$arr['message']['chat']['first_name']."',
        '".$arr['message']['chat']['last_name']."',
        1,
        '".$xc['bot_uniq_name']."'
        )","i");
        
    }
    
}

else {
    
    // если пользователь заново подписывается на бота
    if ($a[0]['activ'] == 0) {
        $b = db_query("UPDATE users 
        SET activ=1 
        WHERE id=".$a[0]['id']." 
        LIMIT 1","u");
    }
    
    //$xc['lang'] = $a[0]['lang'];
}