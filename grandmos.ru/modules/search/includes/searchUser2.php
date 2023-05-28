<?php defined('DOMAIN') or exit(header('Location: /'));

   $start = $page * $num - $num;
   $page++;
   
   $groupBy = " GROUP BY r.user_id, a.group_index ";
   $userJoin = " LEFT JOIN recomend_users_groups2 as r ON (a.group_index =  r.group_index  AND r.user_id='".$user_id."') ";
   $orderBy = " ORDER BY r.recommend DESC ";
   $userFields = "r.user_id,a.group_index,r.recommend,";
   $limit = " LIMIT $start, $num";
   $tmp = 'searchResult';
   
   $sql = "SELECT 
    ".$userFields."
    a.group_id, 
    a.d_level1,
    a.schedule_2, 
    a.online_id, 
    a.level3, 
    a.img, 
    a.address, 
    a.district, 
    a.lng, 
    a.lat 
    FROM groups AS a 
    ".$userJoin.$where.$groupBy.$orderBy.$limit;
     
    $groups = db_query($sql);
    
    if ($groups != false) {
        
        $filters = null;
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/'.$tmp.'.inc.php';
        $searchResult = ob_get_clean();
    }