<?php

$_SESSION['query_id'] = null;
$user = array();

if (!empty($_GET['user'])) {
    
    $user = json_decode($_GET['user'],true);
    
    
    
    
    
    $_SESSION['query_id'] = $user['query_id'];
}





require $_SERVER['DOCUMENT_ROOT'] . "/bots/telegram/bots/shop/modules/web/config.php";
require_once $_SERVER['DOCUMENT_ROOT'].'/bots/telegram/bots/shop/modules/web/modules/main/tmp.inc.php';