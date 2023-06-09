<?php 


if (str_contains($text, 'жен') or str_contains($text, 'девуш') or str_contains($text, 'бабуш')) {
      
       $title = "Прекрасно! ";
       $description  = " Перечислите, пожалуйста, любые занятия, которые вам интересны.";
       $description .= " Например: «пение», «йога», «гимнастика», «творчество».";

       set_field_log($protocol, $data, "gender", "Женщина", 0); 
       set_field_log($protocol, $data, "gender_id", 2, 0); 

       set_field_log($protocol, $data, "state", 'quest5', 1);
       $tts = $title .". ". $description;
   
       $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false); 
   }else if(str_contains($text, 'муж') or str_contains($text, 'дед') or str_contains($text, 'мал')){
        set_field_log($protocol, $data, "gender", "Мужчина", 0); 
        set_field_log($protocol, $data, "gender_id", 1, 0); 

        $title = "Отлично! ";
        $description  = " Перечислите, пожалуйста, любые занятия, которые вам интересны.";
        $description .= " Например: «футбол», «тренажеры», «настольный теннис».";
 
        set_field_log($protocol, $data, "state", 'quest5', 1);
        $tts = $title .". ". $description;
   
        $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false); 
   }

 

//         $interes =  $text;
//         $account =  new_user($protocol, $data);
//         $sql= "SELECT DISTINCT level3 FROM groups  as g WHERE MATCH (level1,level2,level3, address_full, district) AGAINST ('" . $text  . "') ";
//         $q = db_query($sql);
//         if ($q != false) {
//           foreach( $q  as $l) {
//                 $level3 = $l['level3'];
//                 if (!empty($level3))
//                 {
//                         if (str_contains($level3, 'ОНЛАЙН')){
//                                 $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$account .", 1, 'level3', '".$level3."', 30)";
//                                 db_query($sql, "i");
//                         }
//                         if (!str_contains($level3, 'ОНЛАЙН')){
//                                 $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$account .", 0, 'level3', '".$level3."', 30)";
//                                 db_query($sql, "i");
//                         }
//                 }
//         }

//         $sql= "SELECT DISTINCT level2 FROM groups  as g WHERE MATCH (level1,level2,level3, address_full, district) AGAINST ('" . $text  . "') ";
//         $q = db_query($sql);
//         if ($q != false) {
//           foreach( $q  as $l) {
//                 $level2 = $l['level2'];
//                 if (!empty($level2))
//                 {
                   
//                                 $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$account .", 1, 'level2', '".$level2."', 10)";
//                                 db_query($sql, "i");
                  
//                                 $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$account .", 0, 'level2', '".$level2."', 10)";
//                                 db_query($sql, "i");
                     
//                 }
//         }
//         }

//         $sql= "SELECT DISTINCT level1 FROM groups  as g WHERE MATCH (level1,level2,level3, address_full, district) AGAINST ('" . $text  . "') ";
//         $q = db_query($sql);
//         if ($q != false) {
//           foreach( $q  as $l) {
//                 $level1 = $l['level1'];
//                 if (!empty($level1))
//                 {
                 
//                                 $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$account .", 1, 'level1', '".$level1."', 10)";
//                                 db_query($sql, "i");
                   
//                                 $sql = "INSERT INTO `interests`(`user_id`, `online`, `field_name`, `field_value`, `count_lessons`) VALUES (".$account .", 0, 'level1', '".$level1."', 10)";
//                                 db_query($sql, "i");
                    
//                 }
//         }
// }


//           $url = "https://grandmos.ru/cron/recomend_users_groups.php?user=" .  $account;
//           $ch = curl_init( $url );
//           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//           curl_setopt($ch, CURLOPT_HEADER, false);
//           curl_setopt($ch,CURLOPT_TIMEOUT,1);
//           $res = curl_exec($ch);
//           curl_close($ch);

//           $title = 'Вы успешно зарегистрированы!';
//           $description = "Скажите «рекомендации» и я сформирую мероприятия для Вас!";
//         }else{
//             $title = 'Скажите пожалуйста ваши интересы';
//             $description = "Например: шахматы, скандинавская ходьба, образование...";
//         }

//         $tts = $title .". ". $description;
        
//         $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);    




    