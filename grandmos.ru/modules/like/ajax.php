<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_getLike') {
    
    if (!empty($_COOKIE['user_id'])) {
        $group_index = clearData($_POST['group_index'],'get');
        $user_id = clearData($_COOKIE['user_id'],'int');
        
        if ($_POST['status'] == 'add') {
            $add = db_query("INSERT INTO likes (
            user_id,
            group_index,
            date
            ) VALUES (
            '".$user_id."',
            '".$group_index."',
            '".date('Y-m-d')."'
            )","i");
        }
        
        else {
            $del = db_query("DELETE FROM likes 
            WHERE user_id='".$user_id."' 
            AND group_index='".$group_index."' 
            LIMIT 1","d");
        }
        
        
    }
    
}