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
        array_unshift($init_buttons, array('title'=>$v['name'],'name'=>$v['name'],'hide'=>$v['hide']));
    }
    
    return $init_buttons;
}

function get_log($protocol, $data) {
    
    global $xc;
    
    $qr = db_query("SELECT * 
    FROM alisa_log 
    WHERE protocol='" . $protocol . "' 
    AND dialog_id='".$xc['bot_id']."' 
    AND user_id ='" . UserId($protocol, $data) . "' 
    AND session_id ='" . SessionId($protocol, $data) .  "' 
    LIMIT 1");

    if ($qr == false && UserId($protocol, $data) != 'D227248A9B4196FB7CA9242CACA30D4A8810049E44913253C8690E671DB971C6'){
        
        $add = db_query("INSERT INTO alisa_log (
        dialog_id, 
        protocol, 
        user_id, 
        session_id,
        datetime) 
        VALUES (
        '".$xc['bot_id']."',
        '".$protocol."',
        '".UserId($protocol, $data)."',
        '".SessionId($protocol, $data)."',
        '".time()."')", 
        "i");

        $qr = db_query("SELECT * 
        FROM alisa_log 
        WHERE protocol='" . $protocol . "' 
        AND dialog_id='".$xc['bot_id']."' 
        AND user_id ='" . UserId($protocol, $data) . "' 
        AND session_id ='" . SessionId($protocol, $data) . "' 
        LIMIT 1");
    }
    
    return $qr[0];
}

function main($protocol, $botDir, $data)
{   
    
    global $xc;
    
    $log = get_log($protocol, $data);
    $buttons = get_buttons($xc['buttons']);
    $text = get_text( $protocol,  $data);
    $content = null;
    
    if (empty($text)) {
        // подключаем главный модуль (что видит пользователь, когда заходит в навык)
        if (file_exists($botDir.'/modules/main/index.php')) {
            include $botDir.'/modules/main/index.php';
        }
    }
    //$month = $data['request']['nlu']['entities'][1]['value']['month'];
    else if (!empty($data['request']['nlu']['entities'][0]['type'])) {
        $q = db_query("SELECT `script`, `type` 
        FROM alisa_requests  
        WHERE request_type='".$data['request']['nlu']['entities'][0]['type']."' 
        AND dialog_id=".$xc['bot_id']." 
        LIMIT 1");
        
        if ($q != false && file_exists($botDir.'/modules/'.$q[0]['script'])) {
            include $botDir.'/modules/'.$q[0]['script'];
        }
    }
    
    else {
        $q = db_query("SELECT `script`, `type` 
        FROM alisa_requests  
        WHERE MATCH (text) AGAINST ('" . $text  . "' IN BOOLEAN MODE) 
        AND dialog_id=".$xc['bot_id']." 
        LIMIT 1");
        
        if ($q != false && file_exists($botDir.'/modules/'.$q[0]['script'])) {
            $responseType = $q[0]['type'];
            include $botDir.'/modules/'.$q[0]['script'];
        }
        
        else {
            include $botDir.'/modules/search/index.php';
        }
    }
    
    if (empty($content)) {
        $responseType = 'help';
        include $botDir.'/modules/main/answers.php';
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

    if ( $tts == ''){
        $tts = $title . ". " .  $description;
    }else{
        $tts = $title . ". " .  $tts;
    }
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

function get_state( $log ) {
    //Итоговый ответ
    $state = $log['state'];

    //По умолчанию Главная
    if ($state == ''){
        $state = 'главная';
    }
    return $state;
}