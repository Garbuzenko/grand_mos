<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


date_default_timezone_set("UTC"); // Устанавливаем часовой пояс по Гринвичу
header('Content-Type: text/html; charset=utf-8'); // устанавливаем кодировку

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/functions.php";

$test = array();
$csv = "уникальный номер участника,уникальный номер группы";

$users = db_query("SELECT * FROM recomend_test_users");

foreach($users as $b) {
    $a = db_query("SELECT user_id, 
     group_id,
     group_index,
     recommend 
     FROM recomend_users_groups
     WHERE recommend!='0.0000000000' 
     AND user_id='".$b['uniq_id']."' 
     ORDER BY recommend DESC 
     LIMIT 1000");
     
     if ($a != false) {
        foreach($a as $v) {
            
            if (!empty($test[ $b['uniq_id'] ]) && count($test[ $b['uniq_id'] ]) == 10) {
                continue;
            }
            
            if (empty($test[ $b['uniq_id'] ][ $v['group_index'] ])) {
                $test[ $b['uniq_id'] ][ $v['group_index'] ] = $v['group_id'];
            }
        }
     }
}

// формируем csv файл
foreach($test as $user_id=>$value) {
  $groups = null;
  foreach($value as $group_index=>$group_id) {
    $groups .= ",".$group_id;
  }
            
  $csv .= "\n".$user_id.$groups;
}

file_put_contents($_SERVER['DOCUMENT_ROOT'].'/files/test.csv',$csv);