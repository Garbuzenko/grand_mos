<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsEditUserInfo') {
    
    $gArr = array(
     1 => 'Мужчина',
     2 => 'Женщина'
    );
    
    $birthday = date('Y-m-d',strtotime($_POST['birthday']));
    $age = age($birthday);
    $gender = intval($_POST['gender']);
    $address = clearData($_POST['address']);
    $user_id = clearData($_COOKIE['user_id'],'int');
    $lng = null;
    $lat = null;
    $phone = null;
    
    if (!empty($_POST['phone'])) {
        $phone = clearData($_POST['phone'],'int');
    }
    
    if (!empty($address)) {
        $r = geocoder($address);
        
        if ($r != false) {
            $lng = $r[0];
            $lat = $r[1];
        }
    }
    
    $upd = db_query("UPDATE users 
    SET birthday='".$birthday."',
    gender='".$gArr[$gender]."',
    gender_id='".$gender."',
    address='".$address."',
    lng='".$lng."',
    lat='".$lat."',
    age='".$age."',
    phone='".$phone."' 
    WHERE user_id='".$user_id."'
    LIMIT 1
    ","u");
    
    exit('ok');
    
}

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsEditNotify') {
    
    $notify = intval($_POST['notify']);
    $user_id = clearData($_COOKIE['user_id'],'int');
    
    $upd = db_query("UPDATE users SET 
    notify='".$notify."' 
    WHERE user_id='".$user_id."' 
    LIMIT 1","u");
    
    if ($upd == true) {
        
        $width = 600;
        $height = 450;
        
        if ($notify == 0) {
            $width = 400;
            $height = 250;
        }
        
        
       ob_start();
       require_once $_SERVER['DOCUMENT_ROOT'].'/modules/account/components/settings/includes/notify.inc.php';
       $html = ob_get_clean();
       
       $h = popup_window($html,$width, $height, 5500);
       exit($h);
    }
}