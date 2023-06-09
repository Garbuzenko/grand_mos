<?php
        
        if (str_contains($text, 'да')) {
                set_field_log($protocol, $data, "state", '', 1);
                $title = "Отлично! Для входа в акаунт, скажите, ваш номер телефона. ";
                $description = "\nОтправка доступна только для операторов Билайн и Теле2. ";  
                $description .= "\nВажно, чтобы ваш номер телефона был указан в настройках в личном кабинете на сайте grandmos.ru";

                // $description = "И я пришлю вам смс с кодовым словом";
                $tts = $title .". ". $description;
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
                set_field_log($protocol, $data, "state", 'phone', 1);

        }else if (str_contains($text, 'нет')){
                set_field_log($protocol, $data, "state", '', 1);
                $title = "Для настройки поиска, я задам 4 простых вопроса. ";
                $description = "\nСкажите, пожалуйста, сколько Вам лет?";
                $tts = $title .". ". $description;
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
                set_field_log($protocol, $data, "state", 'quest2', 1);
        }
  





    