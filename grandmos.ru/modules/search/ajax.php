<?php defined('DOMAIN') or exit(header('Location: /'));

if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsGetSearchText') {
    
    $num = 9;
    $page = intval($_POST['page']);
    $search = clearData($_POST['search']);
    $tmp = 'searchResult';
    $distance = array();
    $distance2 = array();
    $user_id = 0;
    
    
    if (!empty($_COOKIE['user_id'])) {
       $user_id = clearData($_COOKIE['user_id'],'int');
    }
    
    $arr['search'] = $search;
    
    $start = $page * $num - $num;
    $page++;
    
    $where = " WHERE MATCH (level1,level2,level3,address_full,district) AGAINST ('" . $search  . "') ";
    //$where = " WHERE MATCH (a.search_str) AGAINST ('" . $search  . "') ";
    
    $limit = " LIMIT $start, $num";
    $orderBy = "";
    $groupBy = " GROUP BY a.group_index ";
    $userJoin = "";
    $userFields = "a.group_index,";
    $userLng = null;
    $userLat = null;
    
    if (!empty($user_id)) {
        
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
         
        $groupBy = " GROUP BY r.user_id, a.group_index ";
        $userJoin = " LEFT JOIN recomend_users_groups2 as r ON (a.group_index =  r.group_index  AND r.user_id='".$user_id."') ";
        $orderBy = " ORDER BY r.recommend DESC ";
        $userFields = "r.user_id,a.group_index,r.recommend,";
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
    
    if ($groups == false && strlen($search) > 28) {
         ob_start();
         require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/emptySearchResult.inc.php';
         $html = ob_get_clean();
        
         exit($html);
    }
   
    if ($groups != false) {
        
         if (!empty($user_id) && !empty($userLng)) {
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
        
        
        $filters = serialize($arr);
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/'.$tmp.'.inc.php';
        $html = ob_get_clean();
        
        exit($html);
    }
    
}

if (isset($_POST['form_id']) && ($_POST['form_id']=='form_searchGroups' || $_POST['form_id']=='form_jsAjaxAutoLoad')) {
    
    $where = null;
    $var = null;
    $num = 9;
    $page = 1;
    $map = 0;
    $filtersUser = null;
    $groups = false;
    $user_id = 0;
    $ajax_app = 0;
    
    if (!empty($_POST['ajax_app'])) {
        $ajax_app = intval($_POST['ajax_app']);
    }
    
    if (!empty($_POST['map'])) {
        $map = intval($_POST['map']);
    }
    
    if (!empty($_POST['page'])) {
        $page = intval($_POST['page']);
    }
    
    $ajaxLoadPage = $page;
    
    if (!isset($_POST['filters'])) {
        $filters = $_POST;
    }
    
    else {
        $filters = unserialize($_POST['filters']);
    }
    
    $start = $page * $num - $num;
    $page++;
    
    if (!empty($filters)) {
        foreach($filters as $k=>$v) {
        
        if ($k == 'format') {
            foreach($v as $ind=>$format_id) {
                $var .= $format_id.',';
            }
            
            $var = trim($var,',');
            $where .= " AND a.online_id IN (".$var.") ";
            $filtersUser .= " AND groups.online_id IN (".$var.") ";
            $var = null;
        }
        
        if ($k == 'type') {
            foreach($v as $ind=>$format_id) {
                $var .= $format_id.',';
            }
            
            $var = trim($var,',');
            $where .= " AND a.type_id IN (".$var.") ";
            $filtersUser .= " AND groups.type_id IN (".$var.") ";
            $var = null;
        }
        
        if ($k == 'direction') {
            foreach($v as $ind=>$format_id) {
                $var .= $format_id.',';
            }
            
            $var = trim($var,',');
            $where .= " AND a.level3_id IN (".$var.") ";
            $filtersUser .= " AND groups.level3_id IN (".$var.") ";
            $var = null;
        }
        
        if ($k == 'online') {
            $where .= " AND a.online_id=".intval($v)." ";
            $filtersUser .= " AND groups.online_id=".intval($v)." ";
        }
        
        if ($k == 'id_level1') {
            $where .= " AND a.level1_id=".intval($v)." ";
            $filtersUser .= " AND groups.level1_id=".intval($v)." ";
        }
        
        if ($k == 'id_level2') {
            $where .= " AND a.level2_id=".intval($v)." ";
            $filtersUser .= " AND groups.level2_id=".intval($v)." ";
        }
        
        if ($k == 'dict_id') {
            $where .= " AND a.dict_id=".intval($v)." ";
            $filtersUser .= " AND groups.dict_id=".intval($v)." ";
        }
        
        if ($k == 'search') {
            //$where .= " AND MATCH (a.search_str) AGAINST ('" . clearData($v)  . "') ";
            $where .= " WHERE MATCH (level1,level2,level3,address_full,district) AGAINST ('" . clearData($v)  . "') ";
        }
        
        if ($k == 'districts') {
            foreach($v as $ind=>$dist_id) {
                $var .= $dist_id.',';
            }
            
            $var = trim($var,',');
            $where .= " AND a.district_id IN (".$var.") AND a.online_id=0 ";
            $filtersUser .= " AND groups.district_id IN (".$var.") AND groups.online_id=0 ";
            $var = null;
        }
        
      }
    }
    
    $limit = " LIMIT $start, $num";
    $tmp = 'searchResult';
    
    /*
    if (empty($where)) {
        exit('');
    }
    */
    
    if ($map==1) {
        
        $limit = "";
        
        $tmp = 'searchMapResult';
        $where .= " AND a.online_id=0  AND a.last_date > '2023-01-01' ";
    }
    
    $orderBy = "";
    $groupBy = " GROUP BY a.group_index ";
    $userJoin = "";
    $userFields = "a.group_index,";
    $userLng = null;
    $userLat = null;
    
    if (!empty($_POST['user_id'])) {
        
        $user_id = intval($_POST['user_id']);
        
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
        
        $groupBy = " GROUP BY r.user_id, a.group_index ";
        $userJoin = " LEFT JOIN recomend_users_groups2 as r ON (a.group_index =  r.group_index  AND r.user_id='".$user_id."') ";
        $orderBy = " ORDER BY r.recommend DESC ";
        $userFields = "r.user_id,a.group_index,r.recommend,";
    }
    
    if (!empty($where)) {
        $where = str_replace_once('AND','WHERE',$where);
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
    
    if ($groups == false) {
         ob_start();
         require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/emptySearchResult.inc.php';
         $html = ob_get_clean();
        
         exit($html);
    }
    
    if ($groups != false) {
        
        //$col = db_query("SELECT FOUND_ROWS() AS cnt");
        
        if (!empty($user_id) && !empty($userLng)) {
            foreach ($groups as $b) {
                $d = distance($userLat, $userLng, $b['lat'], $b['lng']);
                
                $distance2[ $b['group_id'] ] = $d;
                
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
        
        
        if ($map == 1) {
            
            $arr = array();
            $arr['type'] = 'FeatureCollection';
            
            foreach ($groups as $b) {
            
              if (!empty($user_id) && !empty($distance2) && $distance2[ $b['group_id'] ] <= 3) {
                
                $b['d_level1'] = clearData($b['d_level1']);
                $b['address'] = clearData($b['address']);
            
                $arr['features'][] = array(
                'type' => 'Feature',
                'id' => $b['group_id'],
                'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $b['lat'], 1 => $b['lng'])),
                'properties' => array(
                    'type' => 'kurs',
                    'balloonContent' => '<div class=\"searchBaloonDiv\"><p>'.$b['d_level1'].'</p><p>'.$b['address'].'</p></div>',
                    'clusterCaption' => clearData($b['level3']),
                    'hintContent' => clearData($b['level3']) ),
                'options' => array('preset' => 'islands#blueCircleDotIconWithCaption'));

               }
               
               if (empty($user_id)) {
                   $b['d_level1'] = clearData($b['d_level1']);
                   $b['address'] = clearData($b['address']);
            
                   $arr['features'][] = array(
                   'type' => 'Feature',
                   'id' => $b['group_id'],
                   'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $b['lat'], 1 => $b['lng'])),
                   'properties' => array(
                   'type' => 'kurs',
                   'balloonContent' => '<div class=\"searchBaloonDiv\"><p>'.$b['d_level1'].'</p><p>'.$b['address'].'</p></div>',
                   'clusterCaption' => clearData($b['level3']),
                   'hintContent' => clearData($b['level3']) ),
                   'options' => array('preset' => 'islands#blueCircleDotIconWithCaption'));
                 }
               }
               
               $json = json_encode($arr, true);

            }
        
        $filters = serialize($filters);
        
        if (!empty($ajax_app)) {
            $xc['telegram'] = true;
        }
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/'.$tmp.'.inc.php';
        $html = ob_get_clean();
        
        exit($html);
    }
    
}

/*
if (isset($_POST['form_id']) && $_POST['form_id']=='form_jsAjaxAutoLoadUser') {
    
    $page = intval($_POST['page']);
    $user_id = clearData($_POST['user_id'],'int');
    
    $page++;
    
    $userInfo = db_query("SELECT gender_id,
    lng,
    lat,
    age 
    FROM users 
    WHERE user_id=".$user_id." 
    LIMIT 1");
    
    $searchResult = null;
    include $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/searchUser2.php';
    
    exit($searchResult);
    
}
*/

?>