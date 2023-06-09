<?php

$answer = 'Не получилось определить координаты адреса';
$description = null;
$objects = array();
$address1 = array();
$names = array();

// определяем адрес по геокодеру
$address = $data['request']['command'];

$result = geocoder($address);

if ($result != false) {
    $lng = $result[0];
    $lat = $result[1];
    
    // получаем объекты в радиусе 5 км
    $radius = 1000;
    $lng_r = $radius / 62600;
    $lat_r = $radius / 111200;
    $lng_min = $lng - $lng_r;
    $lng_max = $lng + $lng_r;
    $lat_min = $lat - $lat_r;
    $lat_max = $lat + $lat_r;
    $limit = null;
    
    $list = db_query("SELECT DISTINCT
        group_id, 
       (ABS(lng - ".$lng.")*62600 + ABS(lat - ".$lat.")*111200) AS distance,
        groups.level1,
        groups.level2,
        groups.level3,
        groups.address,
        groups.level3_id
        FROM groups
        WHERE lng BETWEEN '".$lng_min."' AND '".$lng_max."' 
          AND lat BETWEEN '".$lat_min."' AND '".$lat_max."' 
        AND groups.online_id = 0 
        GROUP by group_id
        ORDER by distance LIMIT 5");
        
        
    
    if ($list != false) {
        $answer = 'Список подходящих курсов в районе 2 км. от вас'."\n\n";
        
        foreach($list as $b) {
            // сгруппируем курсы, которые находятся по одному и тому же адресу
            // это если совпадают расстояния
            // и группируем по названиям курсов
            $distance = round($b['distance']);
            $address1[ $distance ] = $b['address'];
            $objects[ $distance ][ $b['level3'] ] = $b['level3'];
        }
        
        foreach($objects as $distance=>$val) {
            
            $description .= "\n".$address1[ $distance ].' ('.$distance.' м. от вас)'."\n"; 
            
            foreach($val as $v) {
                $description .= $v."\n";
            }
        }
       
    }
    
}


$title = $answer;
$tts = $description;

$content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);    