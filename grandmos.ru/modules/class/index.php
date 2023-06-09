<?php defined('DOMAIN') or exit(header('Location: /'));

$userInfo = false;
$similar = null;
$friendsArr = array();

$group_index = clearData($xc['url']['g'],'get');

$user_id = 0;

if (!empty($_COOKIE['user_id'])) {
    $user_id = clearData($_COOKIE['user_id'],'int');
}

if (!empty($xc['url']['user'])) {
    $user_id = clearData($xc['url']['user'],'int');
}

$info = db_query("SELECT a.*
 FROM groups AS a 
 WHERE a.group_index='".$group_index."'");

if ($info == false) {
    exit(header('Location: /'));
}

// если пользователь авторизован
if (!empty($user_id)) {
    
    // ищем его знакомых
    $fr = db_query("SELECT group_id, friends 
    FROM recomend_users_groups 
    WHERE user_id='".$user_id."' 
    AND friends!=0");
    
    if ($fr != false) {
        foreach($fr as $b) {
            $friendsArr[ $b['group_id'] ] = $b['friends'];
        }
    }
    
    // данные взять из модуля login
    $userInfo = db_query("SELECT address, lng, lat FROM users WHERE user_id='".$user_id."' LIMIT 1");
}

$title = $info[0]['level3'];
$schedule = null;
$today = '2023-03-01';//date('Y-m-d');
$i = 0;
$signedArr = array();

// расписание 
$sh = db_query("SELECT * 
  FROM shedule
  WHERE group_index='".$group_index."' 
  AND endda >= '".$today."' ");

if ($sh != false) {
    foreach($sh as $b) {
        
        $signedArr[ $b['group_id'] ][$i] = '<div>с '.date('d.m.Y',strtotime($b['begda'])).' по '.date('d.m.Y',strtotime($b['endda'])).'</div>
        <div class="classScheduleTextDiv">'.$b['text'].'</div>';
        
        if (!empty($friendsArr[ $b['group_id'] ])) {
          $signedArr[ $b['group_id'] ][$i] .= '<div>'.lang_function($friendsArr[ $b['group_id'] ], 'ваш знакомый посещает этот курс').'</div>';
        }
        
        $i++;
    }
}

/*
foreach($info as $b) {
    if (empty($b['schedule_2'])) {
      $b['schedule_2'] = $b['schedule_1'];
    }
    
    if (empty($b['schedule_2'])) {
      $b['schedule_2'] = $b['schedule_3'];
    }
  
    if (!empty($b['schedule_2'])) {
     $b['schedule_2'] = str_replace(array('. ,','.,'),'|',$b['schedule_2']);
     $b['schedule_2'] = str_replace(array(';',','),'<br>',$b['schedule_2']);
     $b['schedule_2'] = str_replace('|',',',$b['schedule_2']);
     
     if (preg_match('/2023/',$b['schedule_2'])) {
        $schedule .= '<div>'.$b['schedule_2'].'</div><div class="classGroupIdDiv">ID группы - '.$b['group_id'].'</div>';
        
        if (!empty($friendsArr[ $b['group_id'] ])) {
          $schedule .= '<div>'.lang_function($friendsArr[ $b['group_id'] ], 'ваш знакомый посещает этот курс').'</div>';
        }
     }
     
    }
}
*/

// похожие курсы
$ajaxAutoLoadPage = 1;
$ajaxLoadPage = 2;

// если это оффлайн мероприятия
if ($info[0]['online_id'] == 0) {
   $sql = "SELECT * 
   FROM groups 
   WHERE level3_id='".$info[0]['level3_id']."' 
   AND district_id='".$info[0]['district_id']."' 
   AND group_index!='".$group_index."' 
   GROUP BY group_index 
   LIMIT 30";
}

else {
   $sql = "SELECT * 
   FROM groups 
   WHERE level3_id='".$info[0]['level3_id']."' 
   AND group_index!='".$group_index."' 
   GROUP BY group_index 
   LIMIT 30";
}

$groups = db_query($sql);
 
if ($groups != false) {
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/searchResult.inc.php';
    $similar = ob_get_clean();
}