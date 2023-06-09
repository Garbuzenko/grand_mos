<?php

$description = "";

if (str_contains($text , 'рекомендации')){

    if (empty($account)){

        $sql= "SELECT DISTINCT address, level3, district, lng, lat, g.group_index, g.img_alisa, online_id
        FROM groups  as g   
        WHERE (last_date > '2023-01-01' or test = 1)
        group by group_index order by count DESC LIMIT 15";

    }else{
        $user = db_query("SELECT lng, lat from users WHERE user_id='".$account ."' LIMIT 1")[0];
        $sql= "SELECT  DISTINCT address, level3, district, lng, lat, g.group_index, g.img_alisa, r.friends , r.recommend , online_id
                FROM groups as g 
                left join recomend_users_groups2 as r on r.group_index  = g.group_index 
                WHERE  r.user_id = '".$account."' 
                group by group_index order by r.recommend DESC  LIMIT 15";
    }
}else{

if (empty($account)){

    $sql= "SELECT  address, level3, district, lng, lat, g.group_index, g.img_alisa, online_id
        FROM groups  as g   
        WHERE MATCH (level1,level2,level3, address_full, district) AGAINST ('" . $text  . "')  
        LIMIT 50";
}else{
    $user = db_query("SELECT lng, lat from users WHERE user_id='".$account ."' LIMIT 1")[0];
    $sql= "SELECT  address, level3, district, lng, lat, g.group_index, g.img_alisa, r.friends, online_id
            FROM groups as g 
            left join recomend_users_groups2 as r on r.group_index  = g.group_index 
            WHERE 
            r.user_id = '".$account."'
            AND MATCH (level1,level2,level3, address_full, district) AGAINST ('" . $text  . "')  
            ORDER by r.recommend DESC LIMIT 50";
}
}
// echo $sql;

$q = db_query($sql);
$i = 0;
$group_index = "";
$add = "";
$tts = "";
if ($q != false) {
    $old ="";
    foreach($q as $b) {
        if ($i > 8){
            break; 
        }
        // $address = $b['address'];
        $address = "";
        $img_alisa = $b['img_alisa'];
        // $address = str_ireplace("город Москва, ","", $address);
        // $address = str_ireplace("г. Москва, ","", $address);
        $friends ="";
        if (empty($account)){
            $address = "🎯".$address; 
        }else{
            $distance = my_new_distance($b['lat'], $b['lng'], $user['lat'],  $user['lng']);
            if ($b['online_id'] == 0){
                $address = "🎯 Расстояние: " .  $distance . " м." ;
        
            }
          
            if ($b['friends'] > 0){
                $friends = "\n😎 Ваши друзья в этой группе: " . $b['friends']. " человек";
            }
           
        }
        $level3 = $b['level3'];
        $add =  $level3. '\n' . $address . ' ' . $friends . "\n";
        if ($old != $add ){
            $i++;
            $description .= $i.'. '.$add ;
            $tts         .= $i.'. '.$level3. '. ' . $address . ' ' . $friends . ". ";
            $group_index .= "|" . $b['group_index'];
        }
        $old = $add;
    }
    //Сохраним запрос
    $group_index = str_ireplace("'","", $group_index);
    set_field_log($protocol, $data, "group_index" , $group_index, 1);
    set_field_log($protocol, $data, "state"       , 'search', 1);
    //Скинем статус выбора мероприятия, так как это новый поиск
    set_field_log($protocol, $data, "group_index_chose" , "", 1);
}

if ($i == 0){
    // $title = 'Я ничего не нашла, пожалуйста переформулируйте вопрос';
    // $tts = $title ;
    // $description ="";
    // $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
}
elseif ($i == 1){
    $title = $level3;
    $description = "\n📌".$address . $friends ;
    $tts = $title. ". ".$address . $friends ;
    $img = $img_alisa ;
    $content = get_any_card($protocol, $data, $buttons, $title, $description,$img,  $tts, false);
    set_field_log($protocol, $data, "group_index_chose" , $q[0]['group_index'], 1);

}
else{
    set_field_log($protocol, $data, "account" , $sql, 1);
    $title = 'Удалось найти:\n';
    $next= ". Скажите номер от 1 до ".$i." и я расскажу подробную информацию о мероприятии";
    $tts = ''." ".$tts ." ".$next;


    if (!empty($group_index)){
        $group_index_array =  explode('|', $group_index, 11);
        $i=count($group_index_array);
        foreach($group_index_array as $b) {
            $i--;
            if ($i > 0){
                array_unshift($buttons, array('title' => $i, 'name' => $i,'hide' => true));
            }
        }
    }

    $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
}

