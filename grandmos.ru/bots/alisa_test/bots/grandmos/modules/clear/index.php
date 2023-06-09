<?php
        
        if (str_contains($text, "очистить аккаунт")){
                $title = "Ваш аккаунт успешно удалён!";    
                $description = " Для повторной регистрации, скажите «новый пользователь»";
                $tts = $title." ".$description  ;
                set_field_log($protocol, $data, "account" , "", 0);
                set_field_log($protocol, $data, "state" , "main", 1);
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
        }
       

    