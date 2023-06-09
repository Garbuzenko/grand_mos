<?php

        $group_index_chose = get_field_log($protocol, $data, "group_index_chose" ,  1);
        if (empty($account)){
                $title = "Вам необходимо зарегистрироваться, для регистрации скажите войти";
                $description = "";
                $tts = $title ." ". $description;
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
        
        }else if (empty($group_index_chose)){

                        //Пользователь не выбрал группу
                        $title = "Сначала необходимо выбрать конкртеную группу!";
                        $description = "";
                        $tts = $title ." ". $description;
                        $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);

        }else{

                $sql= "SELECT  address, level3, district, lng, lat, group_index, img_alisa, group_id, online_id
                FROM groups   
                WHERE group_index='" . $group_index_chose . "' LIMIT 1";
        
                $q = db_query($sql);
                $title = "Вы успешно записались в группу: " . $q[0]['level3'];
                if ($q[0]['online_id'] == 0){
                        $title .= ". Адрес " . $q[0]['address'];
                }
               

                $sql= "INSERT INTO groups_signed(user_id, group_id, date) VALUES (".$account.",".$q[0]['group_id'].",'2023-06-12')";
                // echo $sql;
                $ins = db_query($sql, "i");

                $description = "Первое занятие пройдёт в понедельник в 16:00";
                $tts = $title ." ". $description;
                $img = $q[0]['img_alisa'];

                $content = get_any_card($protocol, $data, $buttons, $title, $description,$img,  $tts, false);

        }



    