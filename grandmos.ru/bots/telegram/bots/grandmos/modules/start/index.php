<?php 

$message = 'Здравствуйте! Теперь Вам сюда будут приходить подборки новых курсов от проекта "Московское долголетие"';
/*
$btnArr[] = array(
      'text' => 'Подборка курсов для вас',
      'field' => 'web_app',
      'value' => array('url' => 'https://grandmos.ru/tg?user=101385865')
    );
    
    $replyMarkup = getButtons($btnArr);
 */  

sendMessage($xc['chat_id'],$message);