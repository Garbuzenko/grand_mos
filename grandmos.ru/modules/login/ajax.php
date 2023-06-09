<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsGetSing') {
    
    //$first_name = clearData($_POST['first_name']);
    //$last_name = clearData($_POST['last_name']);
    //$patronomic = clearData($_POST['patronomic']);
    //$birthday = date('Y-m-d',strtotime($_POST['birthday']));
    $url = $_POST['url'];
    $vk_id = null;
    
    if (!empty($_POST['vk_id'])) {
        $vk_id = clearData($_POST['vk_id'],'int');
    }
    
    $user_id = intval($_POST['user_id']);
    
    $a = db_query("SELECT user_id  
    FROM users 
    WHERE user_id='".$user_id."' 
    LIMIT 1");
    
    if ( $a == false ) {
        $html = popup_window('Неправильный логин или пароль'); 
        exit($html);
    }
    
    setcookie('user_id', $user_id, time() + 3600 * 24 * 30, '/');
    
    if (!empty($vk_id)) {
        $xc['url']['user'] = $user_id;
        $xc['telegram'] = true;
        
        // удаляем привязку к предыдущему аккаунту
        $upd = db_query("UPDATE users 
        SET vk_id='' 
        WHERE vk_id='".$vk_id."'","u");
        
        
        // привязываем vk_id к выбранному аккаунту
        $upd = db_query("UPDATE users 
        SET vk_id='".$vk_id."' 
        WHERE user_id=".$user_id." 
        LIMIT 1","u");
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/index.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/tmp.inc.php';
        $search = ob_get_clean();
    
        exit($search);
    }
    
    $r = json_encode( array( 0 => 'redirect', 1 => DOMAIN.$url ) );
    exit($r);
}