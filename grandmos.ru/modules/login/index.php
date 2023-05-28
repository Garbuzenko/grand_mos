<?php defined('DOMAIN') or exit(header('Location: /'));


// выход из админки
if (!empty($xc['url']['exit'])) {
    
    setcookie("user_id", "", time() - 9999999, "/");
    session_destroy();
    
    exit(header('Location: '.DOMAIN.$_SERVER['PHP_SELF']));
}
// ---------------------------------------------------------------------------------------------------------------
    
// автоматическая авторизация
if (!empty($_COOKIE["user_id"])) {

    //$hash = clearData($_COOKIE['hash'], 'guid');
    //$loginMess = 'Вам нужно авторизоваться';
    /*
    $login = db_query("SELECT * 
    FROM xc_users  
    WHERE hash='".$hash."' 
    AND `archive`=0  
    LIMIT 1");
   */
   
   $_SESSION['user_id'] = intval($_COOKIE['user_id']);
} 


// ---------------------------------------------------------------------------------------------------------------

?>