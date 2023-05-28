<?php defined('DOMAIN') or exit(header('Location: /'));

$userInfo = false;
$similar = null;
$group_index = clearData($xc['url']['g'],'get');

$info = db_query("SELECT a.*,
 dict.d_level1 
 FROM groups AS a 
 LEFT JOIN dict ON a.dict_id = dict.dict_id 
 WHERE a.group_index='".$group_index."'");

if ($info == false) {
    exit(header('Location: /'));
}

$title = $info[0]['level3'];

$schedule = null;

// расписание
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
        $schedule .= '<div>'.$b['schedule_2'].'</div>';
     }
     
    }
}

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

// если пользователь авторизован
if (!empty($xc['url']['user'])) {
    $user_id = intval($xc['url']['user']);
    
    $userInfo = db_query("SELECT address, lng, lat FROM users WHERE user_id='".$user_id."' LIMIT 1");
}

