<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsShowSelection') {
    
    $xc['url']['user'] = clearData($_POST['user_id'],'int');
    $xc['telegram'] = true;
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/index.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/tmp.inc.php';
    $search = ob_get_clean();
    
    exit($search);
    
}