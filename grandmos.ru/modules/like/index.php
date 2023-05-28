<?php defined('DOMAIN') or exit(header('Location: /'));

$userLikes = array();

if (!empty($_COOKIE['user_id'])) {
    $lk = db_query("SELECT * 
    FROM likes 
    WHERE user_id='".clearData($_COOKIE['user_id'],'int')."'");
    
    if ($lk != false) {
        foreach($lk as $b) {
            $userLikes[ $b['user_id'] ][ $b['group_index'] ] = 1;
        }
    }
}