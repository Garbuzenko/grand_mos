<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsShowMoreGroupInfo') {
    
    $user_id = clearData($_POST['user_id'],'int');
    $group_index = clearData($_POST['group_index'],'get');
    
    $info = db_query("SELECT a.*
    FROM groups AS a 
    WHERE a.group_index='".$group_index."'");

    if ($info == false) {
      exit();
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
    /*
    $isSigned = db_query("SELECT id FROM groups_signed 
    WHERE user_id='".$user_id."'
    AND group_index='".$group_index."' 
    LIMIT 1");
    */
}

$title = $info[0]['level3'];

// расписание
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
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/class/includes/groupInfo.inc.php';
    $html = ob_get_clean();
        
    $form = popup_window($html,'100%','100%',6000);
    exit($form);

}

// запись в группу
if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsSignedGroup') {
    
    $user_id = 0;
    $group_id = clearData($_POST['group_index'],'int');
    
    if (!empty($_POST['user_id'])) {
        $user_id = clearData($_POST['user_id'],'int');
    }
    
    if (empty($user_id)) {
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/class/includes/loginSiteForm.inc.php';
        $html = ob_get_clean();
        
        $width = 490;
        $height = 200;
        
        $h = popup_window($html,$width,$height,5000);
        exit($h);
    }
    
    if (!empty($user_id)) {
        $add = db_query("INSERT INTO groups_signed (
        user_id,
        group_id,
        date
        ) VALUES (
        '".$user_id."',
        '".$group_id."',
        '".date('Y-m-d')."'
        )","i");
        
        if (intval($add) > 0) {
            exit($group_id);
        }
        
    }
    
    
    
    
}