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



if (!empty($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];
}else{
    exit;
}
// echo $quiz_id;

$tg_id = null;
$vk_id = null;

if (!empty($_GET['tg_id'])) {
    $tg_id = clearData($_GET['tg_id'],'int');
}

if (!empty($_GET['vk_id'])) {
    $vk_id = clearData($_GET['vk_id'],'int');
}

$sql = "SELECT * FROM users WHERE quiz_id = '".$quiz_id."' LIMIT 1";
$u =  db_query($sql);


// //Если пользователя не существует 
// if ($u == false) {
        $sql = "SELECT * FROM `users_quiz_answers` WHERE quiz_id = '".$quiz_id."'";
        // echo $sql;
        $q =  db_query($sql);

        $address = "Москва";
        $lat     = 55;
        $lng     = 37;

        $count_lessons = 0;

        if ($q != false) {

            $procent_online = 50;
            $procent_offline = 50;

            foreach($q as $answer) {
                if ($answer['name'] == 'birthday'){

                    $time = strtotime($answer['answer']);
                    $birthday = date('Y-m-d',$time);

                    $age = date_diff(date_create($birthday), date_create('now'))->y;
                }

                if ($answer['name'] == 'gender'){
                    $gender_id = $answer['answer'];
                    if  ($gender_id == 2){
                        $gender = 'Женщина';
                    }else{
                        $gender = 'Мужчина';
                    }
                }

                if ($answer['name'] == 'address'){
                    $address = $answer['answer'];
                }

                if ($answer['name'] == 'lng'){
                    $lng = $answer['answer'];
                }

                if ($answer['name'] == 'lat'){
                    $lat = $answer['answer'];
                }

                if ($answer['name'] == 'distance'){
                    $distance = $answer['answer']*1000;
                }  

                if ($answer['name'] == 'level1'){
                    $level1_array = explode('|', $answer['answer_text']);
                }  

                if ($answer['name'] == 'level2'){
                    $level2_array = explode('|', $answer['answer_text']);
                }  

                if ($answer['name'] == 'level3'){
                    $level3_array = explode('|', $answer['answer_text']);
                }  

                if ($answer['name'] == 'online'){
                    $online = $answer['answer'];
                    $array = explode('|', $online);
                    $count_offline = 0;
                    $count_online  = 0;
                    foreach($array as $a) {
                        if ($a == '0'){
                            $count_offline = 1;
                        }
                        if ($a == '1'){
                            $count_online = 1;
                        }
                    }

                    if (($count_online + $count_offline) == 0){
                       $count_offline = 1;
                        $count_online = 1;
                    }

                    $procent_online  = 100 * $count_online/($count_online + $count_offline);
                    $procent_offline = 100 * $count_offline/($count_online + $count_offline);
                }         
        }


    
        if ($u == false) {
        //Если пользователя не существует 
        $sql = "INSERT INTO users(quiz_id,
        gender,
        gender_id,
        birthday,
        address,
        lng,
        lat,
        age,
        tg_id,
        vk_id,
        distance,
        count_online,
        count_offline,
        procent_online,
        procent_offline)".
        " VALUES ('". 
        $quiz_id ."','". 
        $gender ."','". 
        $gender_id ."','". 
        $birthday ."','". 
        $address ."','".
        $lng ."','".
        $lat ."','". 
        $age ."','". 
        $tg_id."','".
        $vk_id."','".
        $distance  ."','". 
        $count_online  ."','". 
        $count_offline  ."','". 
        $procent_online  ."','". 
        $procent_offline  ."')";

        $user_id =  db_query($sql, "i");
        }else{
            $user_id =  $u[0]['user_id'];

            $sql = "UPDATE users SET gender='".$gender."',
                                     gender_id='".$gender_id."',
                                     birthday='".$birthday."',
                                     address='".$address."',
                                     lng='".$lng."',
                                     lat='".$lat."',
                                     age='".$age."',
                                     tg_id='".$tg_id."',
                                     vk_id='".$vk_id."',
                                     distance='".$distance."',
                                     count_offline='".$count_offline."',
                                     count_online='".$count_online."',                                    
                                     procent_online='".$procent_online."',
                                     procent_offline='".$procent_offline."',
                                     count_lessons='".$count_lessons."'
                                     WHERE user_id='".$user_id."'";
        db_query($sql, "u");
    }

    $sql = "DELETE FROM interests  WHERE user_id='".$user_id."'";
    db_query($sql, "d");

    if (!empty($level1_array)){
        foreach($level1_array as $level1) {
            if (!empty($level1))
            {
   
                if ($count_online > 0){
                    $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$user_id .", 1, 'level1', '".$level1."', 10)";
                    db_query($sql, "i");
                }
               
                if ($count_offline > 0){
                    $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$user_id .", 0, 'level1', '".$level1."', 10)";
                    db_query($sql, "i");
                }
            }
        }
    }

    if (!empty($level2_array)){
        foreach($level2_array as $level2) {
            if (!empty($level2))
            {
                if ($count_online > 0){
                $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$user_id .", 1, 'level2', '".$level2."', 20)";
                db_query($sql, "i");
            }
            if ($count_offline > 0){
                $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$user_id .", 0, 'level2', '".$level2."', 20)";
                db_query($sql, "i");
            }
        }
        }
    }

    if (!empty($level3_array)){
        foreach($level3_array as $level3) {
            if (!empty($level3))
            {
                if ($count_online > 0 AND str_contains($level3, 'ОНЛАЙН')){
                    $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$user_id .", 1, 'level3', '".$level3."', 30)";
                    db_query($sql, "i");
                }
                if ($count_offline > 0 AND !str_contains($level3, 'ОНЛАЙН')){
                    $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$user_id .", 0, 'level3', '".$level3."', 30)";
                    db_query($sql, "i");
                }
            }
        }
    }


    echo  $user_id;

    $ch = curl_init('https://grandmos.ru/cron/recomend_users_groups.php?user=' . $user_id );
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    
    // echo $res; 
    curl_close($ch);
       

    }
// }else{
//     $user_id =  $u[0]['user_id'];
//     echo  $user_id;

//     $ch = curl_init('https://grandmos.ru/cron/recomend_users_groups.php?user=' . $user_id );
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_HEADER, false);
//     $res = curl_exec($ch);
    
//     echo $res; 
//     curl_close($ch);
// }

      
