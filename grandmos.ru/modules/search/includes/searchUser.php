<?php defined('DOMAIN') or exit(header('Location: /'));

    $address = array();
    $groups = array();
    
    $list = geoSearch($userInfo[0]['lng'],$userInfo[0]['lat'],$limit=20000,$user_id,$userInfo[0]['age'],$userInfo[0]['gender_id']);
    
    if ($list != false) {
        
        foreach($list as $b) {
            // сгруппируем курсы, которые находятся по одному и тому же адресу
            // это если совпадают расстояния
            // и группируем по названиям курсов
            $distance = round($b['distance']);
            $address[ $distance ] = $b['address'];
            $groups[$distance][ $b['level3_id'] ][] = $b['group_id'];
            $objects[ $distance ][ $b['level3_id'] ] = array(
              'name' => $b['level3']
            );
            
        }
        
        ksort($objects);
        $searchResultArr = array_chunk($objects, 9, true);
        
        //print_r($groups);
        //exit( print_r($objects) );
        
        if (empty($searchResultArr[$page-1])) {
            exit('');
        }
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/includes/userSearchResult.inc.php';
        $searchResult = ob_get_clean();
        
    }