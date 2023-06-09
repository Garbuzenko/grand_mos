<?php defined('DOMAIN') or exit(header('Location: /'));

require_once $_SERVER['DOCUMENT_ROOT'].'/modules/quiz/functions.php';

if (isset($_POST['form_id']) && ($_POST['form_id']=='form_jsGetQuiz' || $_POST['form_id']=='form_jsGetQuestion')) {
    
    $tg_id = null;
    $vk_id = null;
    
    if (!empty($_POST['tg_id'])) {
        $tg_id = clearData($_POST['tg_id'],'int');
    }
    
    if (!empty($_POST['vk_id'])) {
        $vk_id = clearData($_POST['vk_id'],'int');
    }
    
    if (!empty($_COOKIE['vk_id'])) {
        $vk_id = clearData($_COOKIE['vk_id'],'int');
    }
    
    $containerHeight = '470px';
    
    if (MOBILE == true) {
        $containerHeight = '66vh';
    }
    
    if (!empty($tg_id)) {
        $containerHeight = '78vh';
    }
    
    if (!empty($vk_id) && MOBILE==true) {
        $containerHeight = '79vh';
    }
    
    // если этот пользователь уже проходил опрос
    if (!empty($_COOKIE['quiz_id'])) {
        $quiz_id = clearData($_COOKIE['quiz_id'],'get');
    }
    
    else {
      // если не проходил, то присваиваем ему id опроса
      $quiz_id = md5( time().mt_rand(1000,1000000) );
      setcookie('quiz_id', $quiz_id, time() + 3600 * 24 * 30, '/');     
    }
    
    if (!empty($vk_id)) {
        
        if (!empty($_POST['quiz_id'])) {
            $quiz_id = $_POST['quiz_id'];
        }
        
        else {
            $quiz_id = md5( time().mt_rand(1000,1000000));
        }
    }
    
    $width = 1000;
    $height = 600;
    $zIndex = 6000;
    
    if (MOBILE == true) {
        $width = '100%';
        $height = '100%';
    }
    
    $answers = null;
    $answersArr = array();
    $quest_name = clearData($_POST['quest_name']);
    
    $number = intval($_POST['number']);
    $numberDb = $number;
    $nextNumber = $number + 1;
    $percent = 0;
    
    $questArr = array();
    
    
    
     if ($_POST['form_id']=='form_jsGetQuestion' && $_POST['but']=='next') {
        
        $levelsArr = array();
        $answer = trim($_POST['answer'],'|');
        $answer_text = null;
        $answer = clearData($_POST['answer']);
        $fieldsAdd = '';
        $fieldsUpd = false;
        $quest_number = $number - 1;
        
        if ($quest_name == 'address') {
            
           $result = geocoder($answer);
           
           if ($result!=false) {
              $lng = $result[0];
              $lat = $result[1];
              
              $fieldsUpd = true;
              $fieldsAdd = ",('".$quiz_id."','".$quest_number."','lng','".$lng."','".$answer_text."'),('".$quiz_id."','".$quest_number."','lat','".$lat."','".$answer_text."')";
           }    
        }
        
        if ($quest_name == 'level1') {
            
            // достаём названия level1
            $list = db_query("SELECT id_level1, level1 
            FROM dict 
            GROUP BY id_level1");
            
            foreach($list as $b) {
                $levelsArr[ $b['id_level1'] ] = $b['level1'];
            }
            
            $answer2 = null;
            $answer2Text = null;
            
            $an = explode('|',trim($answer,'|'));
            
            foreach($an as $ab) {
                $answer2 .= $ab."|";
                $answer2Text .= $levelsArr[$ab]."|";
            }
            
            $answer = $answer2;
            $answer_text = trim($answer2Text,'|');
        }
        
        if ($quest_name == 'level2') {
            
            // достаём названия level2
            $list = db_query("SELECT id_level2, level2 
            FROM dict 
            GROUP BY id_level2");
            
            foreach($list as $b) {
                $levelsArr[ $b['id_level2'] ] = $b['level2'];
            }
            
            $answerTime = $answer;
            $answerTime = str_replace(';','|',$answerTime);
            $answer2 = null;
            $answer2Text = null;
            
            $an = explode('|',trim($answerTime,'|'));
            
            foreach($an as $ab) {
                $answer2 .= $ab."|";
                $answer2Text .= $levelsArr[$ab]."|";
            }
            
            //$answer = $answer2;
            $answer_text = trim($answer2Text,'|');
        }
        
        if ($quest_name == 'level3') {
            
            // достаём названия level2
            $list = db_query("SELECT level3_id, level3 
            FROM dict 
            GROUP BY level3_id");
            
            foreach($list as $b) {
                $levelsArr[ $b['level3_id'] ] = $b['level3'];
            }
            
            $answerTime = $answer;
            $answerTime = str_replace(';','|',$answerTime);
            $answer2 = null;
            $answer2Text = null;
            
            $an = explode('|',trim($answerTime,'|'));
            
            foreach($an as $ab) {
                $answer2 .= $ab."|";
                $answer2Text .= $levelsArr[$ab]."|";
            }
            
            //$answer = $answer2;
            $answer_text = trim($answer2Text,'|');
        }
        
        // проверяем отвечал ли пользователь на текущий вопрос
        $is = db_query("SELECT id 
        FROM users_quiz_answers 
        WHERE quiz_id='".$quiz_id."' 
        AND name='".$quest_name."' 
        LIMIT 1");
        
        // если ещё не отвечал
        if ($is == false) {
           // до добавляем в базу его ответ 
           $add = db_query("INSERT INTO users_quiz_answers (
           quiz_id,
           question_number,
           name,
           answer,
           answer_text
           ) VALUES (
           '".$quiz_id."',
           '".$quest_number."',
           '".$quest_name."',
           '".$answer."',
           '".$answer_text."'
           )".$fieldsAdd,"i");          
        }
        
        else {
            // если пользователь уже отвечал на этот вопрос, то обновляем значение в базе
            $upd = db_query("UPDATE users_quiz_answers 
            SET answer='".$answer."',
            answer_text='".$answer_text."'
            WHERE id=".$is[0]['id']." 
            LIMIT 1","u");
            
            if ($fieldsUpd == true) {
                $upd = db_query("UPDATE users_quiz_answers 
                SET answer='".$lng."' 
                WHERE name='lng' 
                AND quiz_id='".$quiz_id."' 
                LIMIT 1","u");
                
                $upd = db_query("UPDATE users_quiz_answers 
                SET answer='".$lat."' 
                WHERE name='lat' 
                AND quiz_id='".$quiz_id."' 
                LIMIT 1","u");
            }
        }
     }
    
    if ($_POST['but'] == 'prev') {
        
        $numberDb = $numberDb - 2;
        $nextNumber = $numberDb + 1;
    }
    
    // если пользователь уже отвечал на текущий вопрос
    $answers = db_query("SELECT * 
    FROM users_quiz_answers 
    WHERE quiz_id='".$quiz_id."' 
    AND question_number='".$numberDb."' 
    LIMIT 1");
    
            
    if ($answers != false) {
      if (preg_match('/|/',$answers[0]['answer'])) {
       $qw = trim($answers[0]['answer'],'|');
       $r = explode('|',$qw);
                  
       foreach($r as $b) {
         $answersArr[ $b ] = 1;
       }
      }
    }
    
    else {
    
    if ($_POST['but'] == 'prev') {
        $numberDb = $numberDb - 1;
        $nextNumber = $numberDb + 1;
    }
        
    // если пользователь уже отвечал на текущий вопрос
    $answers = db_query("SELECT * 
    FROM users_quiz_answers 
    WHERE quiz_id='".$quiz_id."' 
    AND question_number='".$numberDb."' 
    LIMIT 1");
    
            
    if ($answers != false) {
      if (preg_match('/|/',$answers[0]['answer'])) {
       $qw = trim($answers[0]['answer'],'|');
       $r = explode('|',$qw);
                  
       foreach($r as $b) {
         $answersArr[ $b ] = 1;
       }
      }
    }
        
    }
    
    
    $quest = getQuizQuestion($quiz_id,$numberDb);
    
    if ($quest == 'next') {
        $numberDb++;
        $nextNumber++;
        $quest = getQuizQuestion($quiz_id,$numberDb);
        
        if ($quest == 'next') {

          $numberDb++;
          $nextNumber++;
          $quest = getQuizQuestion($quiz_id,$numberDb);
        }
    }
    
    // если вопросы закончились
    if ($quest == false) {
        
        $url = DOMAIN.'/cron/quiz_new_user.php?quiz_id='.$quiz_id;
        
        if (!empty($tg_id)) {
            $url .= '&tg_id='.$tg_id;
            
            // удаляем привязку к предыдущему аккаунту
            $upd = db_query("UPDATE users 
            SET tg_id='' 
            WHERE tg_id='".$tg_id."'","u");
        }
        
        if (!empty($vk_id)) {
            $url .= '&vk_id='.$vk_id;
            
            // удаляем привязку к предыдущему аккаунту
            $upd = db_query("UPDATE users 
            SET vk_id='' 
            WHERE vk_id='".$vk_id."'","u");
        }
        
        // отправляем данные на обработку
        $time_user_id = file_get_contents($url);
        
        $time_user_id = clearData($time_user_id,'int');
        
        if ($time_user_id > 0) {
            // авторизовываем пользователя
            setcookie('user_id', $time_user_id, time() + 3600 * 24 * 30, '/');
        }
        
        if (!empty($tg_id)) {
            // отправляем сообщение пользователю в телеграм
            $m = file_get_contents(DOMAIN.'/bots/telegram/bots/grandmos/notify.php?chat_id='.$tg_id.'&user_id='.$time_user_id.'&mes=quiz');
            
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'].'/modules/quiz/includes/finish2.inc.php';
            $html = ob_get_clean();
            
            exit($html);
        }
        
        if (!empty($vk_id)) {
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'].'/modules/quiz/includes/finish3.inc.php';
            $html = ob_get_clean();
            
            exit($html);
        }
        
        ob_start();
        require_once $_SERVER['DOCUMENT_ROOT'].'/modules/quiz/includes/finish.inc.php';
        $html = ob_get_clean();
        
        exit($html);
    }
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/quiz/includes/questions.inc.php';
    $html = ob_get_clean();
    
    if (!empty($_POST['popupStatus'])) {
         $form = popup_window($html,$width,$height,$zIndex);
         exit($form);
    }
         
    exit($html);
    
}