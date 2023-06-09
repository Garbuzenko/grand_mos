<?php

// смотрим есть ли пользователь с этим телеграм id

$user_id = clearData($xc['url']['user'],'int');
$searchResult = null;

$groups = db_query("SELECT a.id,
 groups.* 
 FROM groups_signed AS a 
 JOIN groups ON a.group_id = groups.group_id 
 WHERE a.user_id='".$user_id."'");

if ($groups != false) {
    $page = 1;
    $filters = null;
    
    $xc['telegram'] = true;
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/searchResult.inc.php';
    $searchResult = ob_get_clean();
}

