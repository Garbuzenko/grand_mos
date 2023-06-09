<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


date_default_timezone_set("UTC"); // Устанавливаем часовой пояс по Гринвичу
header('Content-Type: text/html; charset=utf-8'); // устанавливаем кодировку

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/lib/functions.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/modules/recom/functions.php";

//Обновить интересы
// INSERT INTO interests(user_id, online, field_name, field_value, count_lessons) SELECT user_id, online_id,'level1', level1, sum(COUNT)/5 FROM attend_stat GROUP by user_id, online_id, 'level1', level1;
// INSERT INTO interests(user_id, online, field_name, field_value, count_lessons) SELECT user_id, online_id,'level2', level2, sum(COUNT)/3 FROM attend_stat GROUP by user_id, online_id, 'level2', level2;
// INSERT INTO interests(user_id, online, field_name, field_value, count_lessons) SELECT user_id, online_id,'level3', level3, sum(COUNT)/1 FROM attend_stat GROUP by user_id, online_id, 'level3', level3;

$user_id = 0;

//Константы
$k_const = db_query("SELECT * FROM constant LIMIT 1")[0];


if (!empty($_GET['user'])) {
    $user_id = intval($_GET['user']);
}

if (!empty($user_id)) {
   $sql = "SELECT * FROM users WHERE user_id=".$user_id." LIMIT 1";
}else{
  $sql = "SELECT * FROM users WHERE test=1";
}

// достаём список пользователей
$users = db_query($sql);

if ($users != false) {
    foreach($users as $user) {
 
             $user_id = $user['user_id'];
              // удаляем предыдущие рекомендации
         
              $del = db_query("DELETE FROM recomend_users_groups  WHERE user_id='".$user['user_id']."'","d");   
              $del = db_query("DELETE FROM interests_friend       WHERE user_id='".$user['user_id']."'","d");
              $del = db_query("DELETE FROM recomend_users_groups2 WHERE user_id='".$user['user_id']."'","d");   
              
            //---------------------- Рекомендации ----------------------

            //Добавим интересы друзей


            $s = "INSERT INTO interests_friend(user_id,online, field_name, field_value, count_lessons)  
            SELECT f.user_id, online, field_name, field_value, ROUND(SUM(f.count_lessons + i.count_lessons)/COUNT(f.friend_user_id)) AS count_lessons FROM friends3 as f lEFT JOIN interests as i ON i.user_id = f.friend_user_id 
            WHERE f.user_id = ".$user['user_id']." GROUP BY field_name, field_value DESC LIMIT 15";
            // echo $s;
            $add = db_query($s,"i");

            //Подставить максимальный радиус, в который сейчас ходит + 1 километр и Добавим 30% к дистанции
            $radius = 2000 + $user['distance']*1.5; 

            if ($radius < 1001){
                //Исходный радиус для поиска груп 5 км
                $radius = 4000;
            }

            if ($radius > 20000){
              //Исходный радиус для поиска груп 5 км
              $radius = 20000;
          }

            $lng = $user['lng'];
            $lat = $user['lat'];
            $lng_r = $radius / 62600;
            $lat_r = $radius / 111200;
            $lng_min = $lng - $lng_r;
            $lng_max = $lng + $lng_r;
            $lat_min = $lat - $lat_r;
            $lat_max = $lat + $lat_r;

           
            //Для прогноза по тестовой выборке
            // $test = 1;
            // if ($test == 1){
            //     $condition =  "AND groups.test =". $test." ";
            // }

              //Исключить группы, в которые человек уже ходит
            $arr = array();
            $condition_group_geo = "";
            $list_attend_stat = db_query("SELECT distinct group_id FROM `attend_stat` WHERE user_id=".$user_id." ");   
            if ($list_attend_stat != false) {
                foreach($list_attend_stat as $k=>$v) {
                    $arr[] = $v['group_id'];
                }
                $group_id_ex = implode(',', $arr);
                $condition = "AND groups.group_id not in (" . $group_id_ex . ") ";
            }

            //Добавим адреса мест, в который человек уже ходит AND online=Нет 
            $list_group_geo = db_query("SELECT g_lng, g_lat, sum(count) FROM attend_stat WHERE user_id=".$user_id." AND online='Нет' GROUP by g_lng, g_lat");   
            if ($list_group_geo != false) {
                foreach($list_group_geo as $k=>$v) {
                    $condition_group_geo .= " OR ( lng = '".$v['g_lng']."' AND lat = '".$v['g_lat']."' ) ";
                }
            }

            $age_min = $user['age'] - 1;
            $age_max = $user['age'] + 1;
            
            //Офлайн мероприятия
            $sql = "
            
            INSERT INTO `recomend_users_groups`(`user_id`, `group_id`, `distance`, `age_gender`, `lng`, `lat`, `group_index`, `interes_u`, `interests_f`, `online_ofline`, online_id)
            SELECT DISTINCT
            '".$user_id."' as user_id,
            group_id, 
            (ABS(lng - ".$lng.")*62600 + ABS(lat - ".$lat.")*111200) / $radius AS distance,
            recommend_stat.present_users_lessons AS age_gender,
            groups.lng,
            groups.lat,
            groups.group_index, ".
            "SUM(interests.count_lessons) AS interests_u,
            SUM(interests_friend.count_lessons) AS interests_f,
            (CASE WHEN groups.online='Нет' THEN " . $user['procent_offline']. " ELSE ". $user['procent_online'] . " END) as online_offline,
            groups.online_id as online_id
            FROM groups
            LEFT JOIN recommend_stat ON recommend_stat.dict_id = groups.dict_id  AND recommend_stat.online='Нет'  AND recommend_stat.gender=".$user['gender_id']."  AND recommend_stat.age >= ".$age_min." ". "     AND recommend_stat.age <= ".$age_max." ". "   

            lEFT JOIN interests ON interests.user_id = ".$user_id."  AND interests.online = 0 AND (interests.field_value = groups.level1 OR interests.field_value = groups.level2 OR interests.field_value = groups.level3)
            lEFT JOIN interests_friend  ON interests_friend.user_id = ".$user_id."  AND interests_friend.online = 0 AND (interests_friend.field_value = groups.level1 OR interests_friend.field_value = groups.level2 OR interests_friend.field_value = groups.level3)
            WHERE
                ( ( lng BETWEEN ".$lng_min." AND ".$lng_max." AND lat BETWEEN ".$lat_min." AND ".$lat_max." ) ".$condition_group_geo." )
            AND groups.online_id = 0  "." 
            AND groups.test = 1 
            GROUP BY group_id";
            $ins = db_query($sql,"i");  
            // echo $sql;
            



            if ($user['count_online'] > 0){
            $sql = "
            INSERT INTO `recomend_users_groups`(`user_id`, `group_id`, `distance`, `age_gender`, `lng`, `lat`, `group_index`, `interes_u`, `interests_f`, `online_ofline`, online_id)
            SELECT DISTINCT
            '".$user_id."' as user_id,
            group_id, 
            '1' AS distance,
            recommend_stat.present_users_lessons AS age_gender,
            groups.lng,
            groups.lat,
            groups.group_index, ".
            "SUM(interests.count_lessons) AS interests_u,
            SUM(interests_friend.count_lessons)/3 AS interests_f,
            (CASE WHEN groups.online='Нет' THEN " . $user['procent_offline']. " ELSE ". $user['procent_online'] . " END) as online_offline,
            groups.online_id

            FROM groups
            LEFT JOIN recommend_stat ON recommend_stat.dict_id = groups.dict_id 
                        AND  recommend_stat.gender=".$user['gender_id']." 
                        AND recommend_stat.online='Да' 
                        AND recommend_stat.age >= ".$age_min." ". "  
                        AND recommend_stat.age <= ".$age_max." ". "  
        
            lEFT JOIN interests ON interests.user_id = ".$user_id."  AND interests.online = 1 AND (interests.field_value = groups.level1 OR interests.field_value = groups.level2 OR interests.field_value = groups.level3)
            lEFT JOIN interests_friend  ON interests_friend.user_id = ".$user_id."  AND interests_friend.online = 1 AND (interests_friend.field_value = groups.level1 OR interests_friend.field_value = groups.level2 OR interests_friend.field_value = groups.level3)
            WHERE
                groups.online_id = 1 "." 
            AND groups.test = 1 
            GROUP BY group_id";
            $ins = db_query($sql,"i");  
            // echo $sql;
            }

        
            //Бонус за знакомое место
            $sql = "UPDATE recomend_users_groups as r SET distance_bonus = 
                (SELECT SUM( a.count )  from attend_stat as a  WHERE a.user_id = r.user_id AND a.g_lng = r.lng AND a.g_lat = r.lat ) / ". $user['count_lessons'] ." 
            WHERE user_id = ".$user_id ." ";
            //  echo $sql;
            $upd = db_query($sql,"u");
          
            //Посчитаем итоговую рекомендацию для офлайн
            $sql = "UPDATE recomend_users_groups as r SET recommend = 
                                  ( age_gender * " . $k_const['k_age_gender'] . " 
                                       + interes_u*" . $k_const['k_interes_user'] . " 
                                     + interests_f*" . $k_const['k_interes_friends'] . "
                                     )*online_ofline/100/(distance+5/100)*(1+distance_bonus*".$k_const['k_distance'].")

                                 WHERE user_id = ".$user_id ." and online_id=0";
 
            $upd = db_query($sql,"u");
            //Посчитаем итоговую рекомендацию для онлайн
            $sql = "UPDATE recomend_users_groups as r SET recommend = 
            ( age_gender * " . $k_const['k_age_gender'] . " 
                + interes_u*" . $k_const['k_interes_user'] . " 
              + interests_f*" . $k_const['k_interes_friends'] . "
              )*(1+distance_bonus*".$k_const['k_distance'].")/60
          WHERE user_id = ".$user_id ." and online_id=1";

          $upd = db_query($sql,"u");


      

          $sql = "UPDATE recomend_users_groups SET friends=(SELECT COUNT(*) from attend_stat as a JOIN friends ON a.user_id=friends.friend_user_id                                              
                                                            WHERE a.group_id=recomend_users_groups.group_id AND friends.user_id=recomend_users_groups.user_id)
                                                            WHERE user_id=".$user_id.";";
          $upd = db_query($sql,"u");


          $sql = "INSERT INTO recomend_users_groups2(user_id, group_index, recommend, friends) SELECT user_id, group_index, max(recommend), max(friends) FROM recomend_users_groups WHERE user_id=".$user_id."  GROUP BY user_id, group_index ORDER BY recommend  DESC";
          
          $upd = db_query($sql,"u");




 }
}