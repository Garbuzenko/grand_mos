<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsGetMessagePopup') {
    
    $tmp = clearData($_POST['form']);
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/modules/vk/components/popup/includes/'.$tmp.'.inc.php')) {
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/vk/components/popup/includes/'.$tmp.'.inc.php';
        $html = ob_get_clean();
        
        $width = 490;
        $height = 250;
        
        
        if (MOBILE == true) {
            $width = '90%';
            $height = '50%';
        }
        
        
        $zIndex = 5000;
        
        
        $form = popup_window($html,$width,$height,$zIndex);
        exit($form);
    }   
}