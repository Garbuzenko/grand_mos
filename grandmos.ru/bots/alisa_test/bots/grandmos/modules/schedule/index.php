<?php

        $group_index_chose = get_field_log($protocol, $data, "group_index_chose" ,  1);
        if (empty($group_index_chose)){

                //Пользователь не выбрал группу
                $title = "Сначала необходимо выбрать конкртеную группу!";
                $description = "";
                $tts = $title ." ". $description;
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);

        }else{

                $sql= "SELECT DISTINCT text  FROM shedule WHERE group_index='" . $group_index_chose . "' and (endda > '2023-03-01') LIMIT 5";
                // echo $sql;
                $q = db_query($sql);
                $title = "Расписание:"."\n";
                $description = "";
                $tts = "Расписание: "; 
                $i = 0;
                foreach($q as $b) {
                        $i++;
                         $description .= $b['text'] . "\n";;
                         $tts         .= $b['text']. " . ";
                }
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);

        }



    