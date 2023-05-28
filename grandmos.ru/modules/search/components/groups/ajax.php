<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsShowGroupsList') {
    
    $groups = json_decode($_POST['groups'],true);
    $groupsList = implode(',',$groups);
    $tmp = 'groupsList';
    
    $list = db_query("SELECT a.*,
    dict.d_level1 
    FROM groups AS a 
    LEFT JOIN dict ON a.dict_id = dict.dict_id 
    WHERE a.group_id IN (".$groupsList.")");
    
    if ($list != false) {
        
        if (MOBILE == true) {
            $tmp = 'groupsListMob';
        }
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/components/groups/includes/'.$tmp.'.inc.php';
        $html = ob_get_clean();
        
        if (MOBILE == true) {
            $popup = popup_bottom_window($html, '100%', '80%', 6000);
        }
        
        else {
           $popup = popup_window($html,800,500,6000); 
        }
        
        exit($popup);
        
    }
}