<?php defined('DOMAIN') or exit(header('Location: /'));

   $start = $page * $num - $num;
   $page++;
   
   $orderBy = " ORDER BY a.count_i DESC ";
   $groupBy = " GROUP BY a.group_index ";
   $userJoin = "";
   $userFields = "a.group_index,";
   $where = " WHERE a.count > 0 ";
   
   
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