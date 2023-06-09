<?php
        
        $word    = get_field_log($protocol, $data, 'word', 1);
        $text    = $data['request']['command'];

        if ((($word==$text) or str_contains($text, $word)) and (!empty($word))) {
                $account = get_field_log($protocol, $data, "user_no_autority", 0);
                // $account = '101394298';
                $sql =  set_field_log($protocol, $data, "account" , $account, 0);
                set_field_log($protocol, $data, "state", '', 1);
                //Обновим меню, так как пользователь зашел в аккаунт
                $buttons = get_buttons(menu($protocol, $data, $account,$age,$gender));
                $title = "Спасибо, Вы успешно вошли в аккаунт #".$account."!";
                $description = "Теперь вы можете записаться в группу. Скажите слово «рекомендации» и я расскажу о лучших мероприятиях для Вас.";
                $tts = $title ." ". $description;
                $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);

        }else{

                $numder = preg_replace( '/[^0-9]/', '', $data['request']['command']);
        
                $sql = "SELECT * FROM `users` WHERE user_id='".$numder."' LIMIT 1";
                $q = db_query($sql);

                if ($q == false){
                        //Обновим меню, так как пользователь зашел в аккаунт
                        $title = "К сожалению, кодовое слово не подходит";
                        $description = "Подсказка - кодовое слово ". $word;
                        $tts = $title ." ". $description;
                        $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);

                }else{
                        $account = $numder;
                        set_field_log($protocol, $data, "account" , $account, 0);
                        set_field_log($protocol, $data, "state", '', 1);
                        //Обновим меню, так как пользователь зашел в аккаунт
                        $buttons = get_buttons(menu($protocol, $data, $account));
                        $title = "Спасибо, Вы успешно вошли в аккаунт #".$numder."!";
                        $description = "Теперь вы можете записаться в группу. Скажите слово «рекомендации» и я расскажу о лучших мероприятиях для Вас.";
                        $tts = $title ." ". $description;
                        $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
                }
        }
  





    