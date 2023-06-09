<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsReg') {
    
    $gender_id = intval($_POST['gender']);
    $birthday = date('Y-m-d',strtotime($_POST['birthday']));
    $age = age($birthday);
    $address = clearData($_POST['address']);
    $gender = null;
    $phone = null;
    $lng = null;
    $lat = null;
    
    if (!empty($_POST['phone'])) {
        $phone = clearData($_POST['phone'],'int');
    }
    
    $g = db_query("SELECT * FROM gender");
    
    if ($g != false) {
        foreach($g as $b) {
            if ($b['id'] == $gender_id) {
                $gender = $b['name'];
                break;
            }
        }
    }
    
    $r = geocoder($address);
    
    if ($r != false) {
        $lng = $r[0];
        $lat = $r[1];
    }
    
    $add = db_query("INSERT INTO users (
    gender,
    gender_id,
    birthday,
    address,
    lng,
    lat,
    reg_date,
    age,
    phone) VALUES 
    ('".$gender."',
    '".$gender_id."',
    '".$birthday."',
    '".$address."',
    '".$lng."',
    '".$lat."',
    '".date('Y-m-d')."',
    '".$age."',
    '".$phone."'
    )","i");
    
    if ($add !== false) {
        
        $user_id = $add;
        setcookie('user_id', $user_id, time() + 3600 * 24 * 30, '/');
    
        $r = json_encode( array( 0 => 'redirect', 1 => DOMAIN.'/account/settings' ) );
        exit($r);
    }
    
}