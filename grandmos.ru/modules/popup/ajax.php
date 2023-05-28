<?php defined('DOMAIN') or exit(header('Location: /'));

// нижнее всплывающее окно
if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsPopupBottomWindow') {
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/popup/includes/bottomWindowMob.inc.php';
    $w = ob_get_clean();
    
    $html = popup_bottom_window($w,'100%','70%',100000); 
    exit($html);
    
}