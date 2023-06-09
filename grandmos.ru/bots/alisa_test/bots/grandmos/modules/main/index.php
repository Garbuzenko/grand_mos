<?php
        $tts = "";
       
      
        if (empty($account)){
                //Новый пользователь
                $title = "Здравствуйте! Подскажите, зарегистрированы ли вы в программе московское долголетие?";
                $description = "Просто скажите «да» или «нет»";
                set_field_log($protocol, $data, "state"       , 'quest1', 1);
                array_unshift($buttons, array('title' => 'Нет', 'name' => 'нет','hide' => true));
                array_unshift($buttons, array('title' => 'Да', 'name' => 'да','hide' => true));
        }else{
                //Старый пользователь
                $title = "Привет! Я помогу найти занятия Вам по душе. ";
                $description = "Скажите, например: «Пение», «Скандинавская ходьба» или «Гимнастика район Хамовники». ";
                set_field_log($protocol, $data, "state"       , '', 1);
        }
        $img = "213044/9295afda1d4853f19266";
        $tts = $title ." ". $description;
        $content = get_any_card($protocol, $data, $buttons, $title, $description,$img,  $tts, false);
    