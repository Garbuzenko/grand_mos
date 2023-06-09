<?php
        
        set_field_log($protocol, $data, "state", 'phone', 1);
        if (empty($account)){
                $title = "Для входа в аккаунт, скажите свой номер телефона";  
                $description .= " Отправка доступна только для операторов Билайн и Теле2 ";  
                $description .= " Важно, чтобы ваш номер телефона был указан в настройках в личном кабинете на сайте grandmos.ru";
        }else{
                $title = "Ваш аккаунт уже привязан. ";
                $description = " Если хотите выйте, скажите «очистить аккаунт»";
        }
       
        $tts = $title . " ". $description;
        $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
    