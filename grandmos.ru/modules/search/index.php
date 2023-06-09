<?php defined('DOMAIN') or exit(header('Location: /'));

$user_id = 0;

if (!empty($_COOKIE['user_id'])) {
    $user_id = clearData($_COOKIE['user_id'],'int');
}

if (!empty($xc['url']['user'])) {
    $user_id = clearData($xc['url']['user'],'int');
}

$searchUser = false;
$searchResult = null;
$searchUrl = false;
$where = null;
$ajaxLoadPage = 1;
$num = 9;
$searchFilters = array();
$level2Title = 'Расписание занятий';

foreach($xc['url'] as $k=>$v) {
        
        if ($k == 'online') {
            $searchUrl = true;
            $where .= " AND online_id=".intval($v)." ";
            $searchFilters[$k] = intval($v);
        }
        
        if ($k == 'id_level1') {
            $searchUrl = true;
            $where .= " AND level1_id=".intval($v)." ";
            $searchFilters[$k] = intval($v);
        }
        
        if ($k == 'id_level2') {
            $searchUrl = true;
            $where .= " AND level2_id=".intval($v)." ";
            $searchFilters[$k] = intval($v);
        }
        
        if ($k == 'dict_id') {
            $searchUrl = true;
            $where .= " AND dict_id=".intval($v)." ";
            $searchFilters[$k] = intval($v);
        }
}



// вытаскиваем список районов
$districts = db_query("SELECT district, district_id 
  FROM groups_address 
  WHERE district!='' 
  GROUP BY district");
  
$type = db_query("SELECT type 
 FROM dict 
 GROUP BY type");
 
$direction = db_query("SELECT level3, level3_id 
 FROM dict 
 GROUP BY level3_id");

 if (!empty($where)) {
    $where = str_replace_once('AND','WHERE',$where);
 }

// если это индивидуальный поиск по интересам пользователя
if (!empty($user_id)) {
    $page = 1;
    include $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/searchUser2.php';
}

if ($searchUrl == true && empty($user_id)) {

$groups = db_query("SELECT SQL_CALC_FOUND_ROWS group_id,
 address,
 district,
 level1,
 level2,
 level3,
 online_id,
 d_level1,
 img,
 lng,
 lat,
 group_index 
 FROM groups  
 ".$where." 
 GROUP BY group_index 
 LIMIT 0, 9");
 
 if ($groups != false) {
    
    
    $col = db_query("SELECT FOUND_ROWS() AS cnt");
    
    $level2Title = $groups[0]['level2'];
    
    if (!empty($searchFilters['id_level1'])) {
        $level2Title = $groups[0]['level1'];
    }
    
    if (!empty($searchFilters['dict_id'])) {
        $level2Title = $groups[0]['level3'];
    }
    
    if (!empty($searchFilters['online'])) {
        $level2Title = 'Онлайн курсы';
    }
    
    $page = 2;
    $filters = serialize($searchFilters);
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/searchResult.inc.php';
    $searchResult = ob_get_clean();
 }
 
}

if ($searchUrl == false && empty($user_id)) {
    $page = 1;
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/defaultSearch.php';
}