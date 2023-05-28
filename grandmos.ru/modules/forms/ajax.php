<?php

// вызов всплывающих форм
if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_getPopup') {
    
    $formTmp = clearData($_POST['form']);
    $width = 600;
    $height = 610;
    $zIndex = 5500;
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/modules/forms/includes/'.$formTmp.'.inc.php')) {
        
        if ($formTmp == 'signIn') {
            $width = 600;
            $height = 610;
            $zIndex = 6000;
        }
        
        if ($formTmp == 'popupHello') {
            $width = 600;
            $height = 400;
            $zIndex = 5000;
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