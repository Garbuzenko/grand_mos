<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsGetSing') {
    
    $user_id = clearData($_POST['user_id'],'int');
    $tg_id = clearData($_POST['tg_id'],'int');
    
    // находим пользователя по логину и паролю
    
    // и если нашли, то привязываем id телеграма к нему
    $upd = db_query("UPDATE users 
    SET tg_id='".$tg_id."' 
    WHERE user_id='".$user_id."' 
    LIMIT 1","u");
    
    if ($upd == true) {
        // присваиваем метку    
        setcookie('user_id', $user_id, time() + 3600 * 24 * 30, '/');
    
       // загружаем рекомендованные курсы
       $xc['telegram'] = true;
       ob_start();
       require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/index.php';
       require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/tmp.inc.php';
       $search = ob_get_clean();
       
       exit($search);
    }
    
}