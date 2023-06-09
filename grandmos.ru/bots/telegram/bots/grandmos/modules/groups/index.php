<?php 

// проверяем подписан ли пользователь на какие нибудь группы
$isGroups = db_query("SELECT id 
  FROM groups_signed 
  WHERE user_id='".$xc['user_id']."'");

// если нет групп, на которые подписан пользователь
if ($isGroups == false) {
    $message = 'У вас пока нет курсов, на которые вы подписаны. Для выбора интересных вам курсов, вы можете воспользоваться нашими рекомендациями';
    
    $btnArr[] = array(
      'text' => 'Посмотреть рекомендации',
      'field' => 'web_app',
      'value' => array('url' => 'https://grandmos.ru/tg?user='.$xc['user_id'])
    );
    
}

else {
    $message = 'Курсы, на которые вы подписаны';

    $btnArr[] = array(
      'text' => 'Посмотреть',
      'field' => 'web_app',
      'value' => array('url' => 'https://grandmos.ru/tg/groups?user='.$xc['user_id'])
    );
}

    
$replyMarkup = getButtons($btnArr);

sendMessage($xc['chat_id'],$message,$replyMarkup);