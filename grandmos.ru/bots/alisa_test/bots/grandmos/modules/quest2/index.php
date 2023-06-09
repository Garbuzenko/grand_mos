<?php
         $age = preg_replace( '/[^0-9]/', '', $data['request']['command']);   
        if (($age > 20) AND ($age < 150)) {
                
                $title = "Отлично! ".$age." прекрасный возраст!";
                $description = "\nСкажите пожалуйста ваш адрес с указанием города.";
                $tts = $title .". ". $description;
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
                set_field_log($protocol, $data, "age", $age, 0);
                set_field_log($protocol, $data, "state", 'quest3', 1);

        }else{
                $title = "Скажите пожалуйста, сколько вам лет.";
                $description = "\nВозраст должен быть в интервале от 20 до 150 лет.";
                $tts = $title .". ". $description;
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
        }
  





    