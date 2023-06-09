<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsGetContent') {
    
    $vk_id = clearData($_POST['vk_id'],'int');
    $user_id = clearData($_POST['user_id'],'int');
    $xc['vk'] = true;
    $first = 0;
    
    
    setcookie('vk_id', $vk_id, time() + 3600 * 24 * 30, '/');
    
    $width = 490;
    $height = 200;
    $zIndex = 5000;
            
    if (MOBILE == true) {
        $width = '100%';
        $height = '100%';
        
    }
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/forms/includes/popupHello.inc.php';
    $html = ob_get_clean();
    
    // пользователь приходит по ссылке с сайта (может и не первый раз)
    if (!empty($user_id)) {
        
        // проверим есть ли у него vk_id
        $isVk = db_query("SELECT * 
        FROM users 
        WHERE user_id='".$user_id."' 
        LIMIT 1");
        
        if ($isVk == false) {
            // выдаём стандартное приветствие
            $form = popup_window($html,$width,$height,$zIndex);
            exit($form);
        }
        
        // значит пользователь зашёл в первый раз
        if (empty($isVk[0]['vk_id'])) {
            
           // нужно выдать ему подборку
           // и уведомление, что мы теперь на связи
           $upd = db_query("UPDATE users 
           SET vk_id='".$vk_id."' 
           WHERE user_id='".$user_id."' 
           LIMIT 1","u"); 
           
           $first = 1;
        }
        
         $xc['url']['user'] = $user_id;
         $xc['telegram'] = true;
        
         ob_start();
         require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/index.php';
         require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/tmp.inc.php';
         $search = ob_get_clean();
           
         $arr = array(
         'content' => $search,
         'first' => $first,
         'user_id' => $user_id
         );
           
         $h = callbackFunction($arr);
         exit($h);
        
    }
    
    // проверяем есть ли в базе пользователь с текущим vk_id
    $isUser = db_query("SELECT user_id 
    FROM users 
    WHERE vk_id='".$vk_id."' 
    LIMIT 1");
    
    if ($isUser == false) {
        // если нет такого пользователя, то выдаём ему всплывающее окно с вопросом 
        // является ли он пользователем Московского долголетия
        $form = popup_window($html,$width,$height,$zIndex);
        exit($form);
    }
    
    
    $xc['url']['user'] = $user_id;
    $xc['telegram'] = true;
        
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/index.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/tmp.inc.php';
    $search = ob_get_clean();
           
    $arr = array(
    'content' => $search,
    'first' => $first,
    'user_id' => $user_id
    );
           
    $h = callbackFunction($arr);
    exit($h);
    
}