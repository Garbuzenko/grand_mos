<?php
   $q = false;
   $numder = preg_replace( '/[^0-9]/', '', $data['request']['command']);
//    echo $numder;
   if (empty($numder) or $numder < 1 or $numder > 9 ) {
       
   }else{
   $group_index = get_field_log($protocol, $data, "group_index" , 1);
   $group_index_array =  explode('|', $group_index, 11);

   if (count( $group_index_array ) > 1 and  count( $group_index_array ) >  $numder){
        $sql= "SELECT  address, level3, district, lng, lat, group_index, img_alisa, online_id
        FROM groups   
        WHERE group_index='" . $group_index_array[ $numder] . "' LIMIT 1";
        // echo  $sql;
        $q = db_query($sql);
        set_field_log($protocol, $data, "group_index_chose" , $q[0]['group_index'], 1);
      }

   if ($q != false) {
        $buttons = get_buttons(menu($protocol, $data, $account, $age, $gender));
        $title = $q[0]['level3'];
        $description = "";
        if ( $q[0]['online_id'] == 0){
         $description  = "\n📌Адрес: ".$q[0]['address'];
         $description .= "\n Район: ".$q[0]['district'];
        }
        $next =  " Для записи на мероприятияе, скажите регистрация";
        $tts = $title." ". $description. " " . $next;

        $img= $q[0]['img_alisa'];
        $content = get_any_card($protocol, $data, $buttons, $title, $description,$img,  $tts, false);
   }else{
        $title = "Для выбора мероприятия из списка, скажите номер от 1 до ".count( $group_index_array ) - 1 .".";
        $description ="Для нового поиска мероприятий, скажите любое направление, например гимнастика, пение, рисование или танцы";
        $tts = $title ;
        // $description ="";
        $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
   }
}

  
  
    