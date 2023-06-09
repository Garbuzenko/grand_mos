<?php defined('DOMAIN') or exit(header('Location: /'));

// выход из админки
if (!empty($xc['url']['exit'])) {
    
    setcookie("user_id", "", time() - 9999999, "/");
    session_destroy();
    
    exit(header('Location: '.DOMAIN));
}
// ---------------------------------------------------------------------------------------------------------------
    
// автоматическая авторизация
if (!empty($_COOKIE["user_id"])) {

   $user_id = clearData($_COOKIE['user_id'],'int');
   
   $xc['userInfo'] = db_query("SELECT * 
   FROM users 
   WHERE user_id='".$user_id."' 
   LIMIT 1");
} 

else {
    if (!empty($xc['close'][ $xc['module'] ]) || !empty($xc['close'][ $xc['component'] ])) {
        $xc['module'] = 'login';
        $xc['component'] = null;
    }
}


// ---------------------------------------------------------------------------------------------------------------

?>