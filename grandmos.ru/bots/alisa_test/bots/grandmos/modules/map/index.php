<?php

        // $group_index_chose = get_field_log($protocol, $data, "group_index_chose" ,  1);
        // if (empty($group_index_chose)){

        //         //Пользователь не выбрал группу
        //         $title = "Сначала необходимо выбрать конкртеную группу!";
        //         $description = "";
        //         $tts = $title ." ". $description;
        //         $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);

        // }else{

        //         $sql= "SELECT DISTINCT CONCAT(schedule_1, schedule_2) as schedule FROM groups WHERE group_index='" . $group_index_chose . "' and (last_date > '2023-01-01' or test = 1) LIMIT 5";
        //         // echo $sql;
        //         $q = db_query($sql);
        //         $title = "Расписание: ";
        //         $description = "";
        //         $tts = $title ; 
        //         $i = 0;
        //         foreach($q as $b) {
        //                 $i++;
        //                  $description .= $i.'. '.$b['schedule'] . "\n\n";;
        //                  $tts         .= $i.'. '.$b['schedule'];
        //         }
        //         $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);

        // }



    