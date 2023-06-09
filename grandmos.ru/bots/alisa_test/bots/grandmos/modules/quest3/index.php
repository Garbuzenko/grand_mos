<?php 
        // определяем адрес по геокодеру
        $address = $data['request']['command'];
        
        $result = geocoder($address);
        
        if ($result != false) {
            $lng = $result[0];
            $lat = $result[1];
            $address =  $result[2];

            set_field_log($protocol, $data, "lat", $lat, 0);
            set_field_log($protocol, $data, "lng",  $lng, 0); 
            set_field_log($protocol, $data, "address", $address, 0);

            $title = $address . ". Отлично! ";
            $description  = "\nСкажите пожалуйста ваш пол. \nВы «женщина» или «мужчина»?";

            set_field_log($protocol, $data, "state", 'quest4', 1);
        }else{
                $title = 'Не удалось определить адрес, повторите ещё раз пожалуйста';
                $description = "";
        }

        $tts = $title .". ". $description;
        
        $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);    




    