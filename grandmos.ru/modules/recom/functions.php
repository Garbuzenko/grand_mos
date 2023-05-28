<?php

function geoSearch($lng,$lat,$user_id=0,$age=0,$gender=0,$filters="",$limit="") {
    

    if (empty($user_id)) {
    }else{
        //Подставить максимальный радиус, в который сейчас ходит + 1 километр
        $list_user = db_query("SELECT * FROM `users` WHERE user_id=".$user_id." LIMIT 1")[0];
        $radius = 1000 + $list_user['distance'];
    }

    if ($radius < 1001){
        //Исходный радиус для поиска груп 5 км
        $radius = 5000;
    }


    $lng_r = $radius / 62600;
    $lat_r = $radius / 111200;
    $lng_min = $lng - $lng_r;
    $lng_max = $lng + $lng_r;
    $lat_min = $lat - $lat_r;
    $lat_max = $lat + $lat_r;
    $limit = null;
    
    /*
    if (!empty($page) && !empty($num)) {
        $start = $page * $num - $num;
        $limit = " LIMIT $start, $num";
    }
    */
    
    if (empty($user_id) && empty($age) && empty($gender)) {
        
        $list = db_query("SELECT DISTINCT
        group_id, 
       (ABS(lng - ".$lng.")*62600 + ABS(lat - ".$lat.")*111200) AS distance,
        groups.level1,
        groups.level2,
        groups.level3,
        groups.address,
        groups.level3_id,
        FROM groups
        WHERE lng BETWEEN ".$lng_min." AND ".$lng_max." 
          AND lat BETWEEN ".$lat_min." AND ".$lat_max." 
        AND groups.online_id = 0 
        GROUP by group_id
        ORDER by distance 
        LIMIT ".$limit);
        
        return $list;
    }
    

    $test = 1;
    //Для прогноза по тестовой выборке
    if ($test == 1){
        $condition =  "AND groups.test =". $test." ";
    }
    //Рекомендовать занятия из адреса, в который человек уже ходит или ходил ранее


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

        //Добавим адреса мест, в который человек уже ходит AND online=Нет 
        
        $list_group_geo = db_query("SELECT g_lng, g_lat, sum(count) FROM attend_stat WHERE user_id=".$user_id." AND online='Нет' GROUP by g_lng, g_lat");   
        if ($list_group_geo != false) {
            foreach($list_group_geo as $k=>$v) {
                $condition_group_geo .= " OR ( lng = '".$v['g_lng']."' AND lat = '".$v['g_lat']."' ) ";
            }
        }

        // echo $condition_group_geo;

}


 $sql = "SELECT DISTINCT
    group_id, 
    (ABS(lng - ".$lng.")*62600 + ABS(lat - ".$lat.")*111200) AS distance,
    recommend_stat.present_users_lessons AS age_gender,
    groups.level3,
    groups.district,
    groups.address,
    groups.level3_id,
    groups.img,
    groups.lng,
    groups.lat,
    groups.group_index,
    groups.online_id,
    SUM(interests.count_lessons) AS user_interests,
    (CASE WHEN groups.online='Нет' THEN " . $list_user['procent_offline']. " ELSE ". $list_user['procent_online'] . " END) as online_offline
    FROM groups
    JOIN recommend_stat ON recommend_stat.dict_id = groups.dict_id 
    lEFT JOIN interests ON interests.user_id = ".$user_id." AND (interests.field_value = groups.level1 OR interests.field_value = groups.level2 OR interests.field_value = groups.level3)
    WHERE
        ( ( lng BETWEEN ".$lng_min." AND ".$lng_max." AND lat BETWEEN ".$lat_min." AND ".$lat_max." ) ".$condition_group_geo." )
    AND recommend_stat.gender=".$gender." 
    AND recommend_stat.age=".$age." 
    AND groups.online_id = 0 " . $condition . " " . $filters . "
    
    GROUP BY group_id
    ORDER BY user_interests DESC, ((age_gender + 0.1) / (distance + 500)) * online_offline  DESC " .$limit ;

//    echo $sql;


    $list = db_query($sql);
    
    return $list;
}