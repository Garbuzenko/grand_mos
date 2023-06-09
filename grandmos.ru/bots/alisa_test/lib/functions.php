<?php 

function get_protocol($data) {
    if ($data['session'] != null ){
        $protocol = 'alisa';
    }elseif ($data['uuid'] != null){
        $protocol = 'sber';
    }else{
        $protocol = 'alisa';
    }
    return $protocol;
}

function get_buttons($array_buttons) {
    
    if (empty($array_buttons)) {
        return false;
    }
    
    $init_buttons = array();
    
    foreach($array_buttons as $v) {
        if (empty($v['url'])){
            array_unshift($init_buttons, array('title'=>$v['name'],'name'=>$v['name'],'hide'=>$v['hide']));
        }else{
            array_unshift($init_buttons, array('title'=>$v['name'],'name'=>$v['name'], 'url'=>$v['url'], 'hide'=>$v['hide']));
        }
      
    }
    
    return $init_buttons;
}

function set_field_log($protocol, $data, $field , $value, $session=1)
{
   
    //Обновим поле
    if ($session == 1){
        //В рамках сессии
        $session_id =  SessionId($protocol, $data);
    }else{
         //В рамках пользователя
        $session_id = '';
    }

    $sql =  "INSERT INTO alisa_log2(dialog_id, protocol, user_id, session_id, field, value) VALUES (4,'" . $protocol . "', '" . UserId($protocol, $data) . "', '".$session_id."','" . $field . "','" . $value . "') ON DUPLICATE KEY UPDATE alisa_log2.value = '" . $value . "'";
    // echo $sql;
    db_query($sql, "i");
    return $sql;  
}

function get_field_log($protocol, $data, $field, $session=1)
{
    if ($session == 1){
        //В рамках сессии
        $session_id =  SessionId($protocol, $data);
    }else{
         //В рамках пользователя
        $session_id = '';
    }
    $sql = "SELECT value FROM alisa_log2 WHERE dialog_id='4' AND protocol='" . $protocol . "' AND user_id ='" . UserId($protocol, $data) . "' AND session_id ='" . $session_id . "' AND field='" . $field . "' LIMIT 1";
    $q = db_query($sql);

    if ($q == false){
        return NULL;
    }
    else{
        return $q[0]['value'];
    }
}

function get_log($protocol, $data) {
    
    global $xc;
    
    $qr = db_query("SELECT * 
    FROM alisa_log2 
    WHERE protocol='" . $protocol . "' 
    AND dialog_id='".$xc['bot_id']."' 
    AND user_id ='" . UserId($protocol, $data) . "' 
    AND session_id ='" . SessionId($protocol, $data) .  "' 
    LIMIT 1");

    if ($qr == false){
        
        $add = db_query("INSERT INTO alisa_log2 (
        dialog_id, 
        protocol, 
        user_id, 
        session_id) 
        VALUES (
        '".$xc['bot_id']."',
        '".$protocol."',
        '".UserId($protocol, $data)."',
        '".SessionId($protocol, $data)."')",
        "i");

        $qr = db_query("SELECT * 
        FROM alisa_log2
        WHERE protocol='" . $protocol . "' 
        AND dialog_id='".$xc['bot_id']."' 
        AND user_id ='" . UserId($protocol, $data) . "' 
        AND session_id ='" . SessionId($protocol, $data) . "' 
        LIMIT 1");
    }
    
    return $qr[0];
}


function menu($protocol, $data, $account, $age,$gender)
{   
    $group_index_chose = get_field_log($protocol, $data, "group_index_chose" ,  1);
    $state   = get_field_log($protocol, $data, 'state'  , 1);

    $sql= "SELECT lng, lat FROM groups WHERE group_index='" . $group_index_chose . "' LIMIT 1";
    if (empty($account)){
        //Если нет аккаунта
        if (empty($group_index_chose)){
                $buttons = array(
                array('name' => 'Сайт', 'url' =>"https://grandmos.ru",'hide' => true),
                array('name' => 'Войти', 'hide' => true),
                array('name' => 'Танцы', 'hide' => true),
                array('name' => 'Пение', 'hide' => true),
                array('name' => 'Йога', 'hide' => true)
                );
        }else{
            $q = db_query($sql)[0];
            $buttons = array(
                array('name' => 'Telegram', 'url' =>"https://t.me/grandmos_bot?start=".$account,'hide' => true),
                array('name' => 'Аналитика', 'url' =>"https://datalens.yandex/1mrl27a0i32er?user=".$account."&g=".$gender."&a=".$age,'hide' => true),
                array('name' => 'Сайт', 'url' =>"https://grandmos.ru",'hide' => true),
                array('name' => 'Группы', 'hide' => true),
                array('name' => 'Рекомендации', 'hide' => true),
                array('name' => 'Карта', 'url' =>'https://yandex.ru/maps/?pt='.$q['lng'].','.$q['lat'].'&z=17&l=map','hide' => true),
                array('name' => 'Расписание', 'hide' => true)
            );
       }
        }else{
      
           //Если есть аккаунт
           if (empty($group_index_chose)){
            $buttons = array(
                array('name' => 'Telegram', 'url' =>"https://t.me/grandmos_bot?start=".$account,'hide' => true),
                array('name' => 'Аналитика', 'url' =>"https://datalens.yandex/1mrl27a0i32er?user=".$account."&g=".$gender."&a=".$age,'hide' => true),
                array('name' => 'Сайт', 'url' =>"https://grandmos.ru",'hide' => true),
                array('name' => 'Группы', 'hide' => true),
                array('name' => 'Рекомендации', 'hide' => true)
             );
           }else{
            $q = db_query($sql)[0];
            $buttons = array(
                array('name' => 'Сайт', 'url' =>"https://grandmos.ru",'hide' => true),
                // array('name' => 'Аккаунт', 'hide' => true),
                array('name' => 'Группы', 'hide' => true),
                array('name' => 'Рекомендации', 'hide' => true),
                array('name' => 'Карта', 'url' =>'https://yandex.ru/maps/?pt='.$q['lng'].','.$q['lat'].'&z=17&l=map','hide' => true),
                array('name' => 'Расписание', 'hide' => true),
                array('name' => 'Регистрация', 'hide' => true)
             );

           }
        }
       
        return $buttons;

} 

function main($protocol, $botDir, $data)
{   
    
    global $xc;
    $account = get_field_log($protocol, $data, 'account', 0);
    $age  = "";
    $gender ="";
    if (!empty($account)){
        $u = db_query("SELECT * FROM users  WHERE user_id = '".$account."' LIMIT 1");
        if (!empty($u)){
         $age = $u[0]['age'];
         $gender = $u[0]['gender_id'];
        }
    }
    $state   = get_field_log($protocol, $data, 'state'  , 1);


    $buttons = get_buttons(menu($protocol, $data, $account, $age, $gender));
    $text = get_text( $protocol,  $data);
    $content = null;

    if (empty($text)) {
        // подключаем главный модуль (что видит пользователь, когда заходит в навык)
        //Скидываем статус на начальный
        $state   = set_field_log($protocol, $data, 'state',''  , 1);
        if (file_exists($botDir.'/modules/main/index.php')) {
            include $botDir.'/modules/main/index.php';
        }
    }
    
    if (file_exists($botDir.'/modules/clear/index.php')) {
        include $botDir.'/modules/clear/index.php';
    }

    //Полнотекстовый поиск
    if (empty($content)){
        $q = db_query("SELECT `script`, `type` 
        FROM alisa_requests  
        WHERE MATCH (text) AGAINST ('" . $text  . "' IN BOOLEAN MODE) 
        AND dialog_id=".$xc['bot_id']." 
        LIMIT 1");
        
        if ($q != false && file_exists($botDir.'/modules/'.$q[0]['script'])) {
            $responseType = $q[0]['type'];
            include $botDir.'/modules/'.$q[0]['script'];
        }
    }

    //Статусная модель
    if (empty($content)){
        if (!empty($state)) {
            $sql = "SELECT `script`, `type` 
            FROM alisa_requests  
            WHERE state = '".$state."' AND dialog_id=".$xc['bot_id']." 
            LIMIT 1";
            $q = db_query($sql);
            
            if ($q != false && file_exists($botDir.'/modules/'.$q[0]['script'])) {
                include $botDir.'/modules/'.$q[0]['script'];
            }
        }
    }

    if (empty($content)){
        include $botDir.'/modules/search/index.php'; 
    }
    //Статусная модель + тип
    if (empty($content)){
        if ((!empty($state)) and (!empty($data['request']['nlu']['entities'][0]['type'])))  {
            $sql = "SELECT `script`, `type` 
            FROM alisa_requests  
            WHERE request_type='".$data['request']['nlu']['entities'][0]['type']."' 
            AND state = '".$state."' AND dialog_id=".$xc['bot_id']." 
            LIMIT 1";
    
            $q = db_query($sql);
            
            if ($q != false && file_exists($botDir.'/modules/'.$q[0]['script'])) {
                include $botDir.'/modules/'.$q[0]['script'];
            }
        }
    }



   
    if (empty($content)) {
        $responseType = 'help';
        include $botDir.'/modules/help/index.php';
    }
    
    return $content;
}

function get_response( $protocol,  $data, $content ) {
    //Итоговый ответ
    switch ($protocol) {
        case 'alisa':
            $response = json_encode( array( 'version' => '1.0',
                    'session'    => array( 'session_id' => $data['session']['session_id'],
                    'message_id' => $data['session']['message_id'],
                    'user_id'    => $data['session']['user_id'] ),
                    'response'   => $content
            ));

            break;
        case 'sber':
            $response = json_encode( array(  'messageName' =>  'ANSWER_TO_USER',
                'sessionId'   =>  $data['sessionId'],
                'messageId'   =>  $data['messageId'],
                'uuid'        =>  $data['uuid'],
                'payload'     =>  $content
            ));

            break;
    }
    return $response;
}

function get_content_text($protocol, $answer_text, $buttons, $data, $tts)
{
    switch ($protocol) {
        case 'alisa':
            $content =  array( 'text' => $answer_text,
                'tts' => $answer_text . " " . $tts,
                'buttons' => $buttons,
                'end_session' => false);
            break;

        case 'sber':
            $content  =  array(  'pronounceText' => $answer_text,
                'emotion' => array( 'emotionId' => 'oups' ),
                'items' =>  array(
                    array( 'bubble' => array( 'text' => $answer_text,
                        'markdown' => true,
                        'expand_policy' => 'auto_expand' ) )
                ),
                'suggestions'  =>  array( 'buttons' => $buttons  ),
                'intent' => 'hi',
                'projectName' => 'Афиша',
                'device' =>  $data['payload']['device'] );
            break;
    }
    return $content;
}


function get_text_card($protocol, $data, $buttons, $title, $description, $tts, $session)
{

    if ( $tts == ''){
        $tts = $title . ". " .  $description;
    }
    
    switch ($protocol) {
        case 'alisa':
            $content = array(
                'text' => $title.' '.$description,
                'tts' =>  $tts   ,
                'buttons' => $buttons,
                'end_session' => $session);
            break;

        case 'sber':
            break;
    }
    return $content;
}

function get_any_card($protocol, $data, $buttons, $title, $description, $img, $tts )
{

    // if ( $tts == ''){
    //     $tts = $title . ". " .  $description;
    // }else{
    //     $tts = $title . ". " .  $tts;
    // }
    switch ($protocol) {
        case 'alisa':
            $content = array(
                'text' => $title,
                'tts' =>  $tts   ,
                'card' => array(
                    'type' => 'BigImage',
                    'image_id' => $img,
                    'title' => $title,
                    'description' => $description ),
                'buttons' => $buttons,
                'end_session' => false);
            break;

        case 'sber':
            break;
    }
    return $content;
}


function get_card($protocol, $data, $buttons, $title)
{
    switch ($protocol) {
        case 'alisa':

            $content = array(
                'text' => $title,
                'tts' =>   $title,
                'card' => array(
                    'type' => 'BigImage',
                    'image_id' => '937455/cb76ddcbb8698c5f1b1f',
                    'title' => $title ),
                'buttons' => $buttons,
                'end_session' => false);
            break;

        case 'sber':
            break;
    }
    return $content;
}


function get_help_card($protocol, $data, $buttons, $title)
{
    switch ($protocol) {
        case 'alisa':

            $content = array(
                'text' => $title,
                'tts' =>   $title,
                'card' => array(
                    'type' => 'BigImage',
                    'image_id' => '965417/6aa08e079892f89d2477',
                    'title' => $title ),
                'buttons' => $buttons,
                'end_session' => false);
            break;

        case 'sber':
            break;
    }
    return $content;
}

function get_text( $protocol,  $data ) {

    //Текст пользователя
    switch ($protocol) {
        case 'alisa':
            $text = mb_strtolower( $data['request']['command'] );
            break;
        case 'sber':
            $text = mb_strtolower( $data['payload']['message']['original_text'] );
            $text = remove_emoji($text);
            $text = trim($text);
            break;
    }
    return $text;
}

function SessionId($protocol, $data ) {

    switch ($protocol) {
        case 'alisa':
            $result = $data['session']['session_id'];
            break;
        case 'sber':
            $result = $data['sessionId'];
            break;
    }
    return   $result;
}

function UserId( $protocol, $data ) {

    switch ($protocol) {
        case 'alisa':
            $result = $data['session']['user_id'] ;
            break;
        case 'sber':
            $result = $data['uuid']['userId'];
            break;
    }
    return  $result;
}

function get_date_json($protocol, $data){

    switch ($protocol) {
        case 'alisa':
            $month = $data['request']['nlu']['entities'][1]['value']['month'];
            $day   = $data['request']['nlu']['entities'][1]['value']['day'];
            $year  = $data['request']['nlu']['entities'][1]['value']['year'];

            if ($year == null){
                $year = date('Y');
            }

            if ($day != null) {
                $result = strtotime("{$year}-{$month}-{$day}");
                $result = date('d.m.Y', $result);
            }else{
                $result = null;
            }
            break;
        case 'sber':
            break;
    }
    return  $result;
}


function  get_offset($protocol){
    switch ($protocol) {
        case 'alisa':
            $result = 5;
            break;
        case 'sber':
            $result = 7;
            break;
    }
    return  $result;
}

// function get_state( $log ) {
//     //Итоговый ответ
//     $state = $log['state'];

//     //По умолчанию Главная
//     if ($state == ''){
//         $state = 'главная';
//     }
//     return $state;
// }


function my_new_distance($lat_1, $lon_1, $lat_2, $lon_2) {

    $radius_earth = 6371; // Радиус Земли

    $lat_1 = deg2rad($lat_1);
    $lon_1 = deg2rad($lon_1);
    $lat_2 = deg2rad($lat_2);
    $lon_2 = deg2rad($lon_2);

    $d = 2 * $radius_earth * asin(sqrt(sin(($lat_2 - $lat_1) / 2) ** 2 + cos($lat_1) * cos($lat_2) * sin(($lon_2 - $lon_1) / 2) ** 2));
    $d = round( $d*100)*10;
    return $d;
}


function save_img_new($img_url)
{
    $url = "https://dialogs.yandex.net/api/v1/skills/d1e2cc04-6b7c-4fbc-8d42-18d84c8a7b90/images";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "Authorization: Bearer код авторизации",
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $data = '{ "url": "' . $img_url . '" }';
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $resp = curl_exec($curl) ;

    $res =  json_decode($resp, true);

    curl_close($curl);

    return  $res['image']['id'];
}


function set_img_alisa()
{
    $query = db_query("SELECT * FROM img WHERE img_alisa=''" );

        foreach ($query as $q) {
            if ($q['img_alisa'] == ''){
            $url_img = "https://grandmos.ru/img/".$q['img'];
            $img_alisa = save_img_new($url_img );
            db_query("UPDATE img SET img_alisa='" . $img_alisa . "' WHERE img='" . $q['img'] . "'", "u");
            }
        }

}

function send_tg_message($word,$tg_id){
    $ch = curl_init('https://grandmos.ru/bots/telegram/bots/grandmos/message.php?m=' . urlencode($word) . "&id=".$tg_id);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_HEADER, false);
     $res = curl_exec($ch);
     curl_close($ch);
}

function send_sms($word,$phone){
    $url = "https://smsc.ru/sys/send.php?login=mike.garbuzenko@gmail.com&psw=917908mikeMIKE&phones=+".$phone."&mes=".$word."";
    // echo $url;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);
}

function new_user($protocol, $data){
    $age     = get_field_log($protocol, $data, "age", 0);
    $lat     = get_field_log($protocol, $data, "lat", 0);
    $lng     = get_field_log($protocol, $data, "lng", 0); 
    $address = get_field_log($protocol, $data, "address", 0);

    $gender     =  get_field_log($protocol, $data, "gender", 0); 
    $gender_id  =  get_field_log($protocol, $data, "gender_id", 0); 

    $date = strtotime("-".$age." years");
    $birthday = date('Y-m-d', $date);
    $distance = 15000;
    $count_online = 1;
    $count_offline = 3;
    $procent_online = 10;
    $procent_offline = 90;

    //Если пользователя не существует 
    $sql = "INSERT INTO users(alisa_id,gender,gender_id,birthday,address,lng,lat,age,distance,count_online,count_offline,procent_online,procent_offline)".
    " VALUES ('". 
    UserId($protocol, $data) ."','". 
    $gender ."','". 
    $gender_id ."','". 
    $birthday ."','". 
    $address ."','".
    $lng ."','".
    $lat ."','". 
    $age ."','". 
    $distance  ."','". 
    $count_online  ."','". 
    $count_offline  ."','". 
    $procent_online  ."','". 
    $procent_offline  ."')";

    $account =  db_query($sql, "i");

    set_field_log($protocol, $data, "account" , $account, 0);
    set_field_log($protocol, $data, "state", '', 1);

    return $account;

}