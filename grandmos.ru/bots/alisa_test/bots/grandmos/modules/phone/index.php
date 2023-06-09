<?php
       //Проверим наличие телефона в базе
       $phone = preg_replace( '/[^0-9]/', '', $data['request']['command']); 
       //Последние 10 символов
       $phone = "7".substr($phone, -10);

       $q = db_query("SELECT * FROM `users` WHERE phone ='".$phone."' AND phone<>0 LIMIT 1;");
       if ($q == false) {
             //Телефон не найден в базе
             $title = "Ваш телефон не найден в базе, повторите пожалуйста номер.";
             $description="Также вы можете сказать команду «новый пользователь» для быстрой регистрации";
       }else{
             //Телефон найден в базе
             $word = db_query("SELECT word FROM words ORDER BY rand() LIMIT 1")[0]['word'];
        //      $word = mt_rand(100, 999);
             set_field_log($protocol, $data, 'word', $word, 1);
             $msg = $word;
             if (empty($q[0]['tg_id'])){
                send_sms($msg,$phone);
                
                  $title = "Я отправила sms сообщение на Ваш телефон.";
                  // $title = "Подсказка, кодовое слово "  . $word;
             }else{
                send_tg_message($msg, $q[0]['tg_id']);
                $title = "Я отправила сообщение Вам в телеграм.";
             }
             set_field_log($protocol, $data, "user_no_autority", $q[0]['user_id'], 0);
             set_field_log($protocol, $data, "phone", $phone, 1);
             set_field_log($protocol, $data, "state", 'code', 1);
           
             $description =" Cкажите кодовое слово для входа в аккаунт.";
             $description.= "\nПодсказка, кодовое слово «"  . $word ."»";
   
       }
       $tts = $title . " " . $description;
       $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
        	

       
