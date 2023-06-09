<?php

if ($xc['m'][2] == 'tg_message') {
    
    $message = 'Тогда войдите в свой личный кабинет по кнопке ниже';
    
    $btnArr[] = array(
       'text' => 'Войти в личный кабинет',
       'field' => 'web_app',
       'value' => array('url' => 'https://grandmos.ru/tg/login?tg_id='.$xc['chat_id'])
     );
            
     $btnArr[] = array(
       'text' => smiles('arrow_left').' назад',
       'field' => 'callback_data',
       'value' => 'login|back.php|main'
     );
            
     $replyMarkup = getButtons($btnArr);
            
     updateMessage($xc['chat_id'],$xc['message_id'],$message,$replyMarkup);
}