<?php

if ($xc['m'][2] == 'main') {
    
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
    updateMessage($xc['chat_id'],$xc['message_id'],$message,$replyMarkup);
}