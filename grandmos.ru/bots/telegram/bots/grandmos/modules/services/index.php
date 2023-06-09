<?php 

$message = 'Вы можете воспользоваться нашей рекоментдательной системой через следующие сервисы';

$site = DOMAIN;
$alisa = 'https://dialogs.yandex.ru/store/skills/71feb33f-pensionery-moskvy';
$vk = 'https://vk.com/app51666613';

if (!empty($xc['user_id'])) {
    $vk .= urlencode('#').$xc['user_id'];
    $site .= '/?user='.$xc['user_id'];
}

$btnArr[] = array(
  'text' => 'Наш сайт',
  'field' => 'url',
  'value' => $site
);

$btnArr[] = array(
  'text' => 'Голосовой навык Алисы',
  'field' => 'url',
  'value' => $alisa
);

$btnArr[] = array(
  'text' => 'Приложение VK',
  'field' => 'url',
  'value' => $vk
);


$replyMarkup = getButtons($btnArr);

sendMessage($xc['chat_id'],$message,$replyMarkup);