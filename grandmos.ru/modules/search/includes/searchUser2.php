<?php defined('DOMAIN') or exit(header('Location: /'));

   $start = $page * $num - $num;
   $page++;
   
   $distance = array();
   $groupBy = " GROUP BY r.user_id, a.group_index ";
   $userJoin = " LEFT JOIN recomend_users_groups2 AS r ON (a.group_index =  r.group_index  AND r.user_id='".$user_id."') ";
   $orderBy = " ORDER BY r.recommend DESC ";
   $userFields = "r.user_id,a.group_index,r.recommend,r.friends,";
   $limit = " LIMIT $start, $num";
   $tmp = 'searchResult';
   
   $userLng = null;
   $userLat = null;
   
   // достаёи координаты пользователя
   $u = db_query("SELECT lng, lat 
   FROM users 
   WHERE user_id='".$user_id."' 
   LIMIT 1");
        
   if ($u != false) {
     if (!empty($u[0]['lng'])) {
       $userLng = $u[0]['lng'];
       $userLat = $u[0]['lat'];
     }
   }
   
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
        
        if (!empty($userLng)) {
            foreach ($groups as $b) {
                $d = distance($userLat, $userLng, $b['lat'], $b['lng']);
                
                if ($d < 1) {
                    $d = $d * 1000;
                    $d = lang_function(round($d),'метр');
                }
                
                else {
                    $d = str_replace('.',',',round($d,'1')).' км.';
                }
                
                $distance[ $b['group_index'] ] = $d;
            }
        }
        
        
        $filters = null;
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/'.$tmp.'.inc.php';
        $searchResult = ob_get_clean();
    }