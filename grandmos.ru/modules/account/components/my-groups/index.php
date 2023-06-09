<?php

// смотрим есть ли пользователь с этим телеграм id
$user_id = clearData($_COOKIE['user_id'],'int');
$searchResult = null;
$thisYearGroups = null;
$actualGroups = null;
$lastGroups = null;
$page = 1;
$filters = null;

$date = '2023-01-01';

$groups = db_query("SELECT a.id,
 groups.* 
 FROM groups_signed AS a 
 JOIN groups ON a.group_id = groups.group_id 
 WHERE a.user_id='".$user_id."' 
 GROUP BY groups.group_index");

if ($groups != false) {
    ob_start();
    require $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/searchResult.inc.php';
    $searchResult = ob_get_clean();
    
    foreach($groups as $b) {
        if ($b['online_id']==0) {
            $actualGroups[] = array(
              'group_index' => $b['group_index'],
              'name' => $b['level3'],
              'lng' => $b['lng'],
              'lat' => $b['lat']
            );
        } 
    }
}

$groups = db_query("SELECT a.group_id AS groupId,
 groups.* 
 FROM attend_stat AS a 
 JOIN groups ON a.group_id = groups.group_id 
 WHERE a.user_id='".$user_id."' 
 AND a.date_last > '".$date."'
 GROUP BY groups.group_index");
 
 if ($groups != false) {

    ob_start();
    require $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/searchResult.inc.php';
    $thisYearGroups = ob_get_clean();
    
    foreach($groups as $b) {
        if ($b['online_id']==0) {
            $lastGroups[] = array(
              'group_index' => $b['group_index'],
              'name' => $b['level3'],
              'lng' => $b['lng'],
              'lat' => $b['lat']
            );
        } 
    }
}

// цвета маршрутов

$colorsRoute = array(
  1 => '#DC143C',
  2 => '#FF1493',
  3 => '#FF4500',
  4 => '#FFD700',
  5 => '#32CD32',
  6 => '#006400',
  7 => '#008B8',
  8 => '#4682B4',
  9 => '#00008B',
  10 => '#00FFFF',
  11 => '#FF00FF',
  12 => '#800000',
  13 => '#8B4513',
  14 => '#F4A460',
  15 => '#4B0082',
  16 => '#DA70D6',
  17 => '#D2691E',
  18 => '#A0522D',
  19 => '#008000',
  20 => '#20B2AA',
  21 => '#1E90FF',
  22 => '#483D8B',
  23 => '#EE82EE',
  24 => '#B8860B',
  25 => '#32CD32',
  26 => '#DC143C',
  27 => '#FF1493',
  28 => '#FF4500',
  29 => '#FFD700',
  30 => '#32CD32',
  31 => '#006400',
  32 => '#008B8',
  33 => '#4682B4'
);