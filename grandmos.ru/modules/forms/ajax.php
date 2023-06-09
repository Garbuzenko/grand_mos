<?php

if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsEmptySearch') {
    exit('ok');
}

// вызов всплывающих форм
if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_getPopup') {
    
    $formTmp = clearData($_POST['form']);
    $width = 600;
    $height = 610;
    $zIndex = 5500;
    $url = $_POST['url'];
    $vk_id = null;
    
    if (!empty($_POST['vk_id'])) {
        $vk_id = $_POST['vk_id'];
    }
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/modules/forms/includes/'.$formTmp.'.inc.php')) {
        
        if ($formTmp == 'signIn') {
            
            $us = db_query("SELECT user_id, age, gender FROM users WHERE test=1");
            $width = 600;
            $height = 400;
            $zIndex = 6000;
        }
        
        if ($formTmp == 'isUserForm') {
            $width = 490;
            $height = 200;
            $zIndex = 5000;
        }
        
        if($formTmp == 'popupHello') {
            $width = 490;
            $height = 200;
            $zIndex = 5000;
            
            setcookie('popup', '123', time() + 3600 * 24, '/');
        }
        
        if ($formTmp == 'askQuestion') {
            $width = 500;
            $height = 220;
            $zIndex = 5100;
        }
        
        if ($formTmp == 'reg') {
            
            $width = 600;
            $height = 590;
            $zIndex = 7000;
        }
        
        if (MOBILE == true) {
          $width = '100%';
          $height = '100%';
        }
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/forms/includes/'.$formTmp.'.inc.php';
        $html = ob_get_clean();
        
        $form = popup_window($html,$width,$height,$zIndex);
        exit($form);
        
    }

}