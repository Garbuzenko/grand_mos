<?php 

$message = 'Потом придумаем';

/*
$btnArr[] = array(
      'text' => 'Посмотреть',
      'field' => 'web_app',
      'value' => array('url' => 'https://grandmos.ru/tg?user='.$xc['user_id'])
    );
    
$replyMarkup = getButtons($btnArr);
*/

$replyMarkup = null;
sendMessage($xc['chat_id'],$message,$replyMarkup);