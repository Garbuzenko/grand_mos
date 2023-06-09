<?php

if ($xc['m'][2] == 'tg_message') {
    
    $message = 'Для того, что б мы смогли подобрать максимально интересные вам курсы, пройдите небольшой опрос. Он займёт максимум 5 минут.';

    
    $btnArr[] = array(
       'text' => 'Пройти опрос',
       'field' => 'web_app',
       'value' => array('url' => 'https://grandmos.ru/tg/quiz?tg_id='.$xc['chat_id'])
     );
            
     $btnArr[] = array(
       'text' => smiles('arrow_left').' назад',
       'field' => 'callback_data',
       'value' => 'login|back.php|main'
     );
            
     $replyMarkup = getButtons($btnArr);
            
     updateMessage($xc['chat_id'],$xc['message_id'],$message,$replyMarkup);
}