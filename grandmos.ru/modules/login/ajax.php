<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsGetSing') {
    
    $first_name = clearData($_POST['first_name']);
    $last_name = clearData($_POST['last_name']);
    $patronomic = clearData($_POST['patronomic']);
    $birthday = date('Y-m-d',strtotime($_POST['birthday']));
    $url = $_POST['url'];
    
    $a = db_query("SELECT user_id  
    FROM users 
    WHERE `login`=1 
    LIMIT 1");
    
    if ( $a == false ) {
        $html = popup_window('Неправильный логин или пароль'); 
        exit($html);
    }
    
    /*
    $hash = get_hash($email);
   
    $b = db_query("UPDATE xc_users    
    SET hash='" . $hash . "' 
    WHERE id=" . $a[0]['id'] ." 
    LIMIT 1", "u");
    */
    
    
    setcookie('user_id', $a[0]['user_id'], time() + 3600 * 24 * 30, '/');
    
    if (preg_match('/\?/',$url)) {
        $url .= '&user='.$a[0]['user_id'];
    }
    
    else {
        $url .= '?user='.$a[0]['user_id'];
    }
    
    $r = json_encode( array( 0 => 'redirect', 1 => DOMAIN.$url ) );
    exit($r);
}