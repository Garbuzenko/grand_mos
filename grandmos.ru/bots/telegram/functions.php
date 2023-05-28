<?php

function botAnswer($arr,$botDir,$filename) {
    
    ob_start();
    print_r($arr);
    $h = ob_get_clean();

    file_put_contents($botDir.'/files/'.$filename.'.txt',$h);
    
}

function smiles($name) {
   
   // https://apps.timwhitlock.info/emoji/tables/unicode - смайлики для сообщений
   
   $arr = array(
    'closed_book' => 'F09F9395',
    'bookmark_tabs' => 'F09F9391',
    'photo_camera' => 'F09F93B7',
    'point_down' => 'F09F9187',
    'arrow_down' => 'E2AC87',
    'arrow_right' => 'E29EA1',
    'arrow_left' => 'E2AC85',
    'arrow_north_east' => 'E28697',
    'mobile_phone' => 'F09F93B1',
    'open_lock' => 'F09F9493',
    'door' => 'F09F9AAA',
    'exclamation_mark' => 'E29D97',
    'party_popper' => 'F09F8E89',
    'video_game' => 'F09F8EAE',
    'multiple_musical_notes' => 'F09F8EB6',
    'glowing_star' => 'F09F8C9F',
    'winking_face' => 'F09F9889',
    'smiling_face_with_sunglasses' => 'F09F988E',
    'disappointed_but_relieved_face' => 'F09F98A5',
    'smirking_face' => 'F09F988F',
    'squared_sos' => 'F09F8698',
    'ledger' => 'F09F9392',
    'multiplication_x' => 'E29C96'
   );
   
   if (!empty($arr[$name])) {
      return hex2bin($arr[$name]);
   }
   
   return null;
}

function answerInlineQuery($inline_query_id,$arr,$offset) {
    
    global $xc;
    
    $results = json_encode($arr);
    $url = "https://api.telegram.org/bot".$xc['bot_key']."/answerInlineQuery";

    $post = array(
      "inline_query_id" => $inline_query_id, 
      "results" => $results, 
      "cache_time" => 300, 
      "next_offset" => $offset
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $res = curl_exec($ch);
    curl_close($ch);
    
    if (!empty($res)) {
        $a = json_decode($res,true);
        
        if ($a['ok'] == true || $a['ok'] == 1) {
            return true;
        }
    }
    
    return false;
}

function userPhoto($chat_id,$width,$limit) {
    
    // доступны размеры
    // 160x160
    // 320x320
    // 640x640
    
    global $xc;
    
    $photos = array();
    
    $res = file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/getUserProfilePhotos?user_id='.$chat_id.'&limit='.$limit);
    
    if (!empty($res)) {
        $result = json_decode($res,true);
        
        if ($result['ok'] == true && $result['result']['total_count'] > 0) {
            
            foreach($result['result']['photos'] as $key=>$val) {
                foreach($val as $k=>$v) {
                    if ($v['width'] == $width) {
                        $photos[] = array(
                          'file_id' => $v['file_id'],
                          'file_unique_id' => $v['file_unique_id']
                        );
                    }
                }
            }
            
            return $photos;
            
        }
        
    }
    
    return false;
}

function botWebhook($botToken,$act,$url=null) {
    
    $a = null;
    
    // подключить webhook к боту
    if ($act == 1) {
        $a = file_get_contents('https://api.telegram.org/bot'.$botToken.'/setWebhook?url='.$url);
    }
    
    // отключить webhook
    if ($act == 2) {
        $a = file_get_contents('https://api.telegram.org/bot'.$botToken.'/deleteWebhook');
    }
    
    if (!empty($a)) {
        $result = json_decode($a,true);
        
        if ($result['ok'] == true && $result['result'] == true) {
            return $result['description'];
        }
    }
    
    return false;
}

function getUserInfo($arr) {
    $chat_id = 0;
    $username = null;
    $first_name = null;
    $last_name = null;
    $message_id = 0;
    $callback = false;
    
    if (!empty($arr['message']['chat']['id'])) {
       $chat_id = $arr['message']['chat']['id']; // id пользователя в телеграм
       $username = $arr['message']['chat']['username'];
       $first_name = $arr['message']['chat']['first_name'];
       $last_name = $arr['message']['chat']['last_name'];
       $message_id = $arr['message']['message_id'];
    }
    
    if ( !empty($arr['callback_query']['data']) ) {
        
        $callback = true;
        $chat_id = $arr['callback_query']['from']['id'];
        $username = $arr['callback_query']['from']['username'];
        $first_name = $arr['callback_query']['from']['first_name'];
        $last_name = $arr['callback_query']['from']['last_name'];
        $message_id = $arr['callback_query']['message']['message_id'];
    }
    
    if (!empty($arr['inline_query'])) {
        $chat_id = $arr['inline_query']['from']['id'];
        $username = $arr['inline_query']['from']['username'];
        $first_name = $arr['inline_query']['from']['first_name'];
        $last_name = $arr['inline_query']['from']['last_name'];
    }
    
    if (!empty($chat_id)) {
        
        $user = array(
          'chat_id' => $chat_id,
          'username' => $username,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'message_id' => $message_id,
          'callback_query' => $callback
        );
        
        return $user;
    }
    
    
    return false;
    
}

function linkUserAccount($chat_id,$username=null,$first_name=null,$last_name=null) {
    
    $name = null;
    $link = null;
    $anonimName = 'Без имени';
    $userAccount = null;
    $widthName = 40;
    
    
    if (!empty($username)) {
       
       $link .= 'https://t.me/'.$username;    
    }
        
    else {
       $link .= 'tg://user?id='.$chat_id;
    }
    
    if (!empty($first_name)) {
        
        if (strlen($first_name) > $widthName) {
            $first_name = substr($first_name,0,$widthName).'...';
        }
        
        $name .= $first_name.' ';
    }
    
    if (!empty($last_name)) {
        
        if (strlen($last_name) > $widthName) {
            $last_name = substr($last_name,0,$widthName).'...';
        }
        
        $name .= $last_name;
    }
    
    if (!empty($name)) {
        $anonimName = trim($name);
    }
    
    $userAccount = '<b><a href="'.$link.'">'.$anonimName.'</a></b>';
    return $userAccount;
}

function activeUser($chat_id) {
    
    global $xc;
    
    $activ = @file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/sendChatAction?chat_id='.$chat_id.'&action=typing');
        
    // если пользователь заблокировал бота
    if (empty($activ)) {
       return false;
    }
    
    return true;
}

// функция для отправки уведомлений в телеграм бота
function sendRequestInTelegram($token,$users,$text,$disable_web_page_preview=true,$buttons=null) {
    
    if (empty($users)) {
        return false;
    }
    
    $result = null;
    
    foreach($users as $key=>$chat_id) {
       
       $status = @file_get_contents('https://api.telegram.org/bot'.$token.'/sendChatAction?chat_id='.$chat_id.'&action=typing');
       
       if ($status == true) {
         
          $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id.'&parse_mode=html&text='.$text;
    
          if ($disable_web_page_preview==true) {
            $url .= '&disable_web_page_preview=true';
          }
    
          if (!empty($buttons)) {
            $url .= '&reply_markup='.$buttons;
          } 
       
          $result = file_get_contents($url);
         
       }
    
    }
    
    return $result;
}
// --------------------------------------------------------------------------


function delMessage($chat_id,$message_id) {
    global $xc;
    
    file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/deleteMessage?chat_id=' .$chat_id . '&message_id='.$message_id);
}

function updateMessage($chat_id,$message_id,$text,$replyMarkup=null) {
    
    global $xc;
    
    file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/editMessageText?chat_id=' .$chat_id . '&message_id='.$message_id.'&text='.$text.'&parse_mode=html');
    
    if (!empty($replyMarkup)) {
        file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/editMessageReplyMarkup?chat_id=' .$chat_id . '&message_id='.$message_id.'&reply_markup='.$replyMarkup);
    }
}

function generateSecretKey($chat_id,$keyword) {
    
    $key = md5($chat_id);
    $key = $key.time().mt_rand(1000,1000000);
    $key = sha1($key);
    $key = substr($key,5,14);
    $key = $keyword.$key;
    
    return $key;
} 

// определение какое сообщение отправил пользователь - текст, картинку, аудио или видео
function typeMessage($arr) {
    
    global $xc;
    
    if (!empty($arr['message']['entities']) && $arr['message']['entities'][0]['type'] == 'bot_command') {
        return 'bot_command';
    }
    
    if (!empty($arr['message']['forward_from_message_id']) && !empty($arr['message']['forward_from_chat']['id'])) {
        return 'forward_message';
    }
    
    if (!empty($arr['message']['text'])) {
        return 'text';
    }
    
    if (!empty($arr['message']['photo'])) {
        return 'photo';
    }
    
    // если отправляют файл без сжатия
    if (!empty($arr['message']['document'])) {
        if (preg_match('/image/',$arr['message']['document']['mime_type'])) {
            return 'photo';
        }
        
        if (preg_match('/video/',$arr['message']['document']['mime_type'])) {
            return 'video';
        }
    }
    
    if (!empty($arr['message']['video'])) {
        return 'video';
    }
    
    if (!empty($arr['message']['voice'])) {
        return 'audio';
    }
    
    if (!empty($arr['message']['audio'])) {
        return 'audio';
    }
    
    if (!empty($arr['message']['sticker'])) {
        return 'sticker';
    }
    
    if (!empty($arr['message']['video_note'])) {
        return 'video';
    }
    
    if (!empty($arr['message']['location'])) {
        return 'location';
    }
    
}

// всплывающее окно
function popupWindow($text,$callback_query_id,$show_alert) {
    
    global $xc;
    
    $url = 'https://api.telegram.org/bot'.$xc['bot_key'].'/answerCallbackQuery';
    
    $post_fields = array(
      'callback_query_id' => $callback_query_id,
      'text' => $text,
      'show_alert' => $show_alert
    );
    
    //file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/answerCallbackQuery?callback_query_id='.$callback_query_id.'&show_alert=true&text='.$text.'&show_alert=false&cache_time=0');

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
    $output = curl_exec($ch);
        
    curl_close($ch);
}

// проверка является ли бот админом канала
function isBotAdmin($chanel_id,$botName) {
    
    global $xc;
    
    $is = @file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/getChatAdministrators?chat_id='.$chanel_id);
    
    if (!empty($is)) {
        $result = json_decode($is,true);
        
        if ($result['ok'] === false) {
            return false;
        }
        
        if ($result['ok'] == true) {
            foreach($result['result'] as $key=>$val) {
                if ($val['user']['is_bot'] == true && $val['user']['username'] == $botName) {
                    if ($val['status'] == 'administrator') {
                        return true;
                    }
                }
            }
        }
        
        
    }
    
    return false;
    
}

// проверка подписан ли пользователь на указанный канал
function userSubscribe($chat_id,$chanel) {
    
    global $xc;
    
    // статусы пользователей, которые не подписаны на канал
    $userStatus = array(
     'left' => 1,
     'kicked' => 1
    );
    
    // проверяем подписан ли пользователь на канал
    $isUser = file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/getChatMember?chat_id=@' . $chanel . '&user_id='.$chat_id);
    $user = json_decode($isUser, true); //Разбираем json запрос на массив
    
    $memberStatus = trim($user['result']['status']); // статус пользователя
    
    // если пользователь не подписан на канал
    if (!empty($userStatus[ $memberStatus ])) {
        return false;
    }
    
    // если уже подписан
    else {
        return true;
    }
    
}

function getFileId($arr,$type) {
    
    $file_id = null;
    
    if ($type == 'sticker') {
       $file_id = $arr['message']['sticker']['file_id'];
    }
    
    if ($type == 'audio') {
        
        if (!empty($arr['message']['voice'])) {
           $file_id = $arr['message']['voice']['file_id'];
        }
    
        if (!empty($arr['message']['audio'])) {
           $file_id = $arr['message']['audio']['file_id'];
        }
        
    }
    
    if ($type == 'video') {
        
        if (!empty($arr['message']['video'])) {
           $file_id = $arr['message']['video']['file_id'];
        }
    
        if (!empty($arr['message']['document'])) {
           $file_id = $arr['message']['document']['file_id'];
        }
    
        if (!empty($arr['message']['video_note'])) {
           $file_id = $arr['message']['video_note']['file_id'];
        }
        
    }
    
    if ($type == 'photo') {
        
        if (!empty($arr['message']['photo'])) {
           $colArr = count($arr['message']['photo']);
           $lastIndex = $colArr - 1;
           $file_id = $arr['message']['photo'][$lastIndex]['file_id'];
        }
    
        if (!empty($arr['message']['document'])) {
           $file_id = $arr['message']['document']['file_id'];
        }
        
    }
    
    return $file_id;
}

function getFileUrl($file_id) {
    
    global $xc;
    
    if (empty($file_id))
      return false;
    
    $result = file_get_contents('https://api.telegram.org/bot'.$xc['bot_key'].'/getFile?file_id='.$file_id);
        
    if (!empty($result)) {
       
       $res = json_decode($result,true);
            
       if ($res['ok'] == true) {
         $path = $res['result']['file_path'];
         $url = 'https://api.telegram.org/file/bot'.$xc['bot_key'].'/'.$path;
         return $url;
       }
            
    }
    
    return false;
}

function sendMessage($chat_id,$text,$buttons=null,$disable_web_page_preview=true) {
    
    global $xc;
    
    $url = 'https://api.telegram.org/bot'.$xc['bot_key'].'/sendMessage?chat_id='.$chat_id.'&parse_mode=html&text='.$text;
    
    if ($disable_web_page_preview==true) {
        $url .= '&disable_web_page_preview=true';
    }
    
    if (!empty($buttons)) {
        $url .= '&reply_markup='.$buttons;
    }
      
    $result = file_get_contents($url);
    
    return $result;
}

function sendLocation($chat_id,$text,$replyMarkup=null) {
    
    global $xc;
    $title = null;
    $address = null;
    
    $lc = explode('|',$text);
    
    $lat = $lc[0];
    $lng = $lc[1];
    
    if (!empty($lc[2]) && !empty($lc[3])) {
        $title = $lc[2];
        $address = $lc[3];
        
        sendMessage($chat_id,$title.'. '.$address);
    }
    
    $url = 'https://api.telegram.org/bot'.$xc['bot_key'].'/sendLocation?chat_id='.$chat_id.'&latitude='.$lat.'&longitude='.$lng;
    
    if (!empty($replyMarkup)) {
        $url .= '&reply_markup='.$replyMarkup;
    }
    
    $result = file_get_contents($url);
    
    return $result;
}

// отправка сообщения с медиа файлом, который находится на своём сервере
function sendMediaPost($chat_id,$file_url,$text,$type,$reply) {
    
    global $xc;
    $method = null;
    $fileType = null;
    
    if (empty($file_url))
      return false;
      
    if ($type == 'audio') {
        $method = 'sendVoice';
        $fileType = 'voice';
    }
    
    if ($type == 'video') {
        $method = 'sendVideo';
        $fileType = 'video';
    }
    
    if ($type == 'photo') {
        $method = 'sendPhoto';
        $fileType = 'photo';
    }
    
    if ($type == 'sticker') {
        $method = 'sendSticker';
        $fileType = 'sticker';
    }
      
    $bot_url = "https://api.telegram.org/bot".$xc['bot_key']."/";
    $url = $bot_url . $method . "?chat_id=" . $chat_id;
    
    if (!empty($text)) {
        $url .= '&parse_mode=html&caption='.$text;
    }
        
    if (!empty($reply)) {
      $url .= '&reply_markup='.$reply;
    }
        
    if (file_exists($_SERVER['DOCUMENT_ROOT'].$file_url)) {
            
            $post_fields = array(
              'chat_id' => $chat_id,
              $fileType => new CURLFile($_SERVER['DOCUMENT_ROOT'].$file_url)
            );
  
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
            $output = curl_exec($ch);
        
            curl_close($ch);
            
            if (!empty($output)) {
              //$path = $_SERVER['DOCUMENT_ROOT'].'/bots/telegram/qr';
              //botAnswer($output,$path,'test5');
              
              $arr = json_decode($output,true);
              
              if ($arr['ok'] == true || $arr['ok'] == 1) {
                 return true;
              }
            }

     }
     
     return false;
}

// отправка сообщения с медиа файлом, который находится на своём сервере
function sendMediaPost2($chat_id,$file_url,$text,$type,$reply) {
    
    global $xc;
    $method = null;
    $fileType = null;
    
    if (empty($file_url))
      return false;
      
    if ($type == 'audio') {
        $method = 'sendVoice';
        $fileType = 'voice';
    }
    
    if ($type == 'video') {
        $method = 'sendVideo';
        $fileType = 'video';
    }
    
    if ($type == 'photo') {
        $method = 'sendPhoto';
        $fileType = 'photo';
    }
    
    if ($type == 'sticker') {
        $method = 'sendSticker';
        $fileType = 'sticker';
    }
      
    $bot_url = "https://api.telegram.org/bot".$xc['bot_key']."/";
    $url = $bot_url . $method . "?chat_id=" . $chat_id;
    
    if (!empty($text)) {
        $url .= '&parse_mode=html&caption='.$text;
    }
        
    if (!empty($reply)) {
      $url .= '&reply_markup='.$reply;
    }
        
    if (file_exists($file_url)) {
            
            $post_fields = array(
              'chat_id' => $chat_id,
              $fileType => new CURLFile($file_url)
            );
  
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
            $output = curl_exec($ch);
        
            curl_close($ch);
            return true;
            
     }
     
     return false;
}

function sendMediaInTgPost($chat_id,$file_url,$path,$text,$type,$reply) {
    
         global $xc;
         $method = null;
         $fileType = null;
    
         if (empty($file_url))
            return false;
      
         if ($type == 'audio') {
            $method = 'sendVoice';
            $fileType = 'voice';
         }
    
         if ($type == 'video') {
           $method = 'sendVideo';
           $fileType = 'video';
         }
    
         if ($type == 'photo') {
           $method = 'sendPhoto';
           $fileType = 'photo';
         }
    
         if ($type == 'sticker') {
           $method = 'sendSticker';
           $fileType = 'sticker';
         }
    
        $fileName = basename($file_url);
        $bot_url = "https://api.telegram.org/bot".$xc['bot_key']."/";
        $url = $bot_url . $method . "?chat_id=" . $chat_id;
        
        if (!empty($text)) {
           $url .= '&parse_mode=html&caption='.$text;
        }
        
        if (!empty($reply)) {
          $url .= '&reply_markup='.$reply;
        }
        
        $im = file_get_contents($file_url);
        file_put_contents($path.$fileName,$im);
        
        if (file_exists($path.$fileName)) {
            
            $post_fields = array(
              'chat_id' => $chat_id,
               $fileType => new CURLFile($path.$fileName)
            );
  
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
            $output = curl_exec($ch);
        
            curl_close($ch);
            
            // удаляем отправленный файл с сервера
            unlink($path.$fileName);
            
            return true;
            
        }
    
    return false;
    
}

function sendMediaInTgPost2($chat_id,$file_id,$text,$type,$reply) {
         
         global $xc;
         $method = null;
         $fileType = null;
    
         if (empty($file_id)) {
            return false;
         }
            
         if ($type == 'audio') {
            $method = 'sendVoice';
            $fileType = 'voice';
         }
    
         if ($type == 'video') {
           $method = 'sendVideo';
           $fileType = 'video';
         }
    
         if ($type == 'photo') {
           $method = 'sendPhoto';
           $fileType = 'photo';
         }
    
         if ($type == 'sticker') {
           $method = 'sendSticker';
           $fileType = 'sticker';
         }
        
        $bot_url = "https://api.telegram.org/bot".$xc['bot_key']."/";
        $url = $bot_url . $method . "?chat_id=" . $chat_id.'&'.$fileType.'='.$file_id;
        
        if (!empty($text)) {
           $url .= '&parse_mode=html&caption='.$text;
        }
        
        if (!empty($reply)) {
          $url .= '&reply_markup='.$reply;
        }
        
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        $output = curl_exec($ch);
        
        curl_close($ch);
        
        if (!empty($output)) {
            $arr = json_decode($output,true);
            
            if ($arr['ok'] == true || $arr['ok'] == 1) {
                return true;
            }
        }
        
        return false;
}

function sendMediaGroupInTg($chat_id,$filesArr,$path,$type) {
    
        global $xc;
        
        $bot_url = "https://api.telegram.org/bot".$xc['bot_key']."/";
        $url = $bot_url . "sendMediaGroup?chat_id=" . $chat_id;
         
        $files = array();
        
        foreach($filesArr as $b) {
            $fileName = basename($b['file_url']);
            $im = file_get_contents($b['file_url']);
            file_put_contents($path.$fileName,$im);
            
            if (file_exists($path.$fileName)) {
                $files[$fileName] = $path.$fileName;
            }
        }
        
        foreach($files as $filename=>$filepath) {
            $media[] = array("type" => $type, "media" => "attach://".$filename);
            $list[$filename] = new CURLFile($filepath);
        }
        
        $obj = array(
           'chat_id' => $chat_id,
           'media' => json_encode($media)
        );
        
        $postContent = array_merge($obj, $list);
        
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postContent); 
        $output = curl_exec($ch);
        
        curl_close($ch);
            
        // в цикле удвляем файлы с сервера
        foreach($files as $filename=>$filepath) {
            unlink($filepath);
        }
}

function getKeyBoard($data) {
 
 $keyboard = array(
   "keyboard" => $data,
   "one_time_keyboard" => false,
   "resize_keyboard" => true
 );
 
 return json_encode($keyboard);
}

function getInlineKeyBoard($data) {
        
 $keyboard = array(
   "inline_keyboard" => $data,
   "one_time_keyboard" => false,
   "resize_keyboard" => true
 );
 
 return json_encode($keyboard);
}

function getButtons($buttonsArr) {
    
    foreach($buttonsArr as $key=>$b) {
        
        if ($key === 'list') {
             
             $inline = array();
             
             foreach($b as $val) {
                $inline[] = array("text"=>$val['text'],$val['field'] => $val['value']);
             } 
             
             if (count($inline) == 2) {
                $inline_keyboard[] = array($inline[0],$inline[1]);
             }
             
             if (count($inline) == 3) {
                $inline_keyboard[] = array($inline[0],$inline[1],$inline[2]);
             }
             
             if (count($inline) == 4) {
                $inline_keyboard[] = array($inline[0],$inline[1],$inline[2],$inline[3]);
             }
        }
        
        else {
           $inline_button = array("text"=>$b['text'],$b['field'] => $b['value'] );
           $inline_keyboard[] = array($inline_button);   
        }
        
    }
    
    $replyMarkup = getInlineKeyBoard($inline_keyboard); 
    return $replyMarkup;
}


function calendar($month, $year, $type, $path, $pathDate, $emptyDates=null, $dates=null,$mensesDatesUser=null) {
  
  $weekDays = array(
    1 => 'ПН',
    2 => 'ВТ',
    3 => 'СР',
    4 => 'ЧТ',
    5 => 'ПТ',
    6 => 'СБ',
    7 => 'ВС'
  );
  
  $monthsName = array(
    1 => 'январь',
    2 => 'февраль',
    3 => 'март',
    4 => 'апрель',
    5 => 'май',
    6 => 'июнь',
    7 => 'июль',
    8 => 'август',
    9 => 'сентябрь',
    10 => 'октябрь',
    11 => 'ноябрь',
    12 => 'декабрь'
  );
  
  // если нужно показать годы
  if ($type == 'years') {
      
      for($i=-3;$i<=8;$i++) {
        
         $thisYear = $year + $i;
        
         $inline[$i] = array("text"=>$thisYear, "callback_data"=> $path."|show-months|".$thisYear);
      }
    
      $inline_keyboard[] = array($inline[-3],$inline[-2],$inline[-1],$inline[0]);
      $inline_keyboard[] = array($inline[1],$inline[2],$inline[3],$inline[4]);
      $inline_keyboard[] = array($inline[5],$inline[6],$inline[7],$inline[8]);
  }
  // --------------------------------------------------------------
  
  // если нужно показать месяцы текущего года
  if ($type == 'months') {
     foreach($monthsName as $key=>$val) {
        
        $m = $key;
        
        if ($key<10) {
            $m = '0'.$key;
        }
        
        $inline[$key] = array("text"=>$val, "callback_data"=> $path."|change-month|".$year.'-'.$m);
     }
     
     // годы
     $yearBtn[] = array("text"=>$year.' г.', "callback_data"=> $path."|show-years|".$year);
     $inline_keyboard[] = array($yearBtn[0]);
     
     // месяцы
     $inline_keyboard[] = array($inline[1],$inline[2],$inline[3]);
     $inline_keyboard[] = array($inline[4],$inline[5],$inline[6]);
     $inline_keyboard[] = array($inline[7],$inline[8],$inline[9]);
     $inline_keyboard[] = array($inline[10],$inline[11],$inline[12]);
  }
  // --------------------------------------------------------------
  
  // показ выбранного месяца
  if ($type == 'days') {

     $start = $year . '-' . $month . '-01';
     $finish = date('Y-m-t', strtotime($start));
  
     $day = 86400;
     $startTime = strtotime($start);
     $endTime = strtotime($finish); 
     $numDays = round(($endTime - $startTime) / $day) + 1;    
     
     $days = array();    
    
     for ($i = 0; $i < $numDays; $i++) {  
        
       $date = date('Y-m-d', ($startTime + ($i * $day)));
        
       $weekDay = date('w', strtotime($date));
        
       if ($weekDay == 0) {
          $weekDay = 7;
       }
        
       $days[] = array('week_day' => $weekDay, 'day' => (int)substr($date,-2), 'date' => $date); 
     }
  
     foreach($weekDays as $key=>$val) {
       $inline[$key] = array("text"=>" ".$val." ", "callback_data"=> $path."|empty");
     }
  
     $row = 1;
     
     foreach($days as $key=>$val) {
        
       if (count($arr[$row]) == 7) {
         $row++;
       }
       
       $dayBtn = $val['day'];
       
       if (!empty($dates) && !empty($dates[ $val['date'] ]) && empty($emptyDates[ $val['date'] ])) {
          $val['day'] = $dayBtn.hex2bin('E29D97');
       }
       
       if (!empty($mensesDatesUser) && !empty($mensesDatesUser[ $val['date'] ])) {
          $val['day'] = $dayBtn.hex2bin('F09F8CB9');
       }
        
       if ($key == 0 && $val['week_day'] > 1) {
            
          for($i=1;$i<$val['week_day'];$i++) {
            $arr[$row][$i] = array("text"=>' ', "callback_data"=> $path."|empty");
          }
          
          $arr[$row][ $val['week_day'] ] = array("text"=>$val['day'], "callback_data"=> $pathDate.'|'.$val['date']);
       }
        
       else {
            
          $arr[$row][ $val['week_day'] ] = array("text"=>$val['day'], "callback_data"=> $pathDate.'|'.$val['date']); 
          
          if ($val['date']==$finish) {
            
            $col = count($arr[$row]) + 1;
            
            for($i=$col;$i<=7;$i++) {
               $arr[$row][$i] = array("text"=>' ', "callback_data"=> $path."|empty");
            }
          }
       }         
     }   
  
     // годы
     $yearBtn[] = array("text"=>$year.' г.', "callback_data"=> $path."|show-years|".$year);
     $inline_keyboard[] = array($yearBtn[0]);
     // ------------------------------------------------------------------------
     
     // кнопки для переключения между месяцами
     $m = (int)$month;
  
     $prevMonth = date("Y-m", mktime(0, 0, 0, $m-1, 1, $year));
     $nextMonth = date("Y-m", mktime(0, 0, 0, $m+1, 1, $year));
  
     $nextPrevBtn[] = array("text"=>'<<<', "callback_data"=> $path."|change-month|".$prevMonth);
     $nextPrevBtn[] = array("text"=>'>>>', "callback_data"=> $path."|change-month|".$nextMonth);
     $monthBtn[] = array("text"=>$monthsName[$m], "callback_data"=> $path."|show-months|".$year);
  
     $inline_keyboard[] = array($nextPrevBtn[0],$monthBtn[0],$nextPrevBtn[1]);
     // ------------------------------------------------------------------------
  
     // список дней недели
     $inline_keyboard[] = array($inline[1],$inline[2],$inline[3],$inline[4],$inline[5],$inline[6],$inline[7]);
  
     // список дат
     for($i=1;$i<=count($arr);$i++) {
       $inline_keyboard[] = array($arr[$i][1],$arr[$i][2],$arr[$i][3],$arr[$i][4],$arr[$i][5],$arr[$i][6],$arr[$i][7]);
     }
  
  }
  
  $replyMarkup = getInlineKeyBoard($inline_keyboard); 
  return $replyMarkup;
}