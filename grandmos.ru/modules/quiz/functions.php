<?php

function getQuizQuestion($quiz_id,$numberDb) {
    
    $column = 12;
    $questArr = array();
    
    // узнаём общее количество вопросов
    $col = db_query("SELECT COUNT(id) AS cnt FROM questions WHERE archive=0");
    $total = $col[0]['cnt'];
    
    // достаём из базы вопрос
    $q = db_query("SELECT * 
    FROM questions 
    WHERE number=".$numberDb." 
    AND archive=0");
    
    if ($q != false) {
        
        // по уровням курсов ответы нужно подтягивать динамически
        if (preg_match('/level/',$q[0]['name'])) {
            
            $q[0]['answers'] = null;
            
            // смотрим что пользователь ответил по поводу онлайн и офлайн меропритий
            $prevAnswerDb = db_query("SELECT answer  
            FROM users_quiz_answers 
            WHERE quiz_id='".$quiz_id."' 
            AND name='online'
            LIMIT 1");
            
            if ($prevAnswerDb != false) {
                $answersIdOnline = trim($prevAnswerDb[0]['answer'],'|');
                $answersIdOnline = str_replace('|',',',$answersIdOnline);
            }
            
            else {
                $answersIdOnline = '0,1';
            }
        
            // вытаскиваем варианты для level1
            if ($q[0]['name'] == 'level1') {
                
                $list = db_query("SELECT id_level1, level1 
                FROM dict  
                WHERE online_id IN (".$answersIdOnline.") 
                GROUP BY id_level1");
                
                if ($list != false) {
                    foreach($list as $ls) {
                        if (!preg_match('/Спецпроект/is',$ls['level1'])) {
                            $q[0]['answers'] .= $ls['level1'].'='.$ls['id_level1'].'|';
                        }
                    }
                    
                    $q[0]['answers'] = trim($q[0]['answers'],'|'); 
                }
                
            }
            // ----------------------------------------------------------------
            
            // вытаскиваем варианты для level2, в зависимости от того, что пользователь выбрал на предыдущем шаге
            if ($q[0]['name'] == 'level2') {
                
                $del = db_query("DELETE FROM users_quiz_answers 
                WHERE quiz_id='".$quiz_id."' 
                AND name='level3'","d");
                
                $answersTextLevel1 = array();
                $arrLevel2 = array();
                $arrLevel2Answers = array();
                
                // достаём предыдущий ответ
                $prevAnswerDb = db_query("SELECT answer, answer_text  
                FROM users_quiz_answers 
                WHERE quiz_id='".$quiz_id."' 
                AND name='level1'
                LIMIT 1");
                
                $answersId = trim($prevAnswerDb[0]['answer'],'|');
                $answersId = str_replace('|',',',$answersId);
                
                $answersText = trim($prevAnswerDb[0]['answer_text'],'|');
                $r = explode('|',$answersText);
                
                foreach($r as $rb) {
                    $answersTextLevel1[ $rb ] = 1;
                }
                
                $list = db_query("SELECT id_level2, level2 
                FROM dict 
                WHERE id_level1 IN (".$answersId.") 
                AND online_id IN (".$answersIdOnline.") 
                GROUP BY id_level2");
                
                if ($list != false) {
                    foreach($list as $ls) {
                       
                       // убираем слово Онлайн из названия
                       $level2 = trim( str_replace(array('онлайн','ОНЛАЙН','Онлайн'),'',$ls['level2']) );
                       
                       if (empty($arrLevel2Answers[ $level2 ])) {
                          $arrLevel2Answers[ $level2 ] = $ls['id_level2'];
                       }
                       
                       else {
                          $arrLevel2Answers[ $level2 ] .= ';'.$ls['id_level2'];
                       }
                       
                       // группируем по одинаковым названиям и исключаем те названия, которые были на предыдущем шаге
                       if (empty($answersTextLevel1[ $level2 ])) {
                         $arrLevel2[ $level2 ] = $level2;
                       }
                    }
                    
                    if (!empty($arrLevel2)) {
                        foreach($arrLevel2 as $key=>$val) {
                            $q[0]['answers'] .= $key.'='.$arrLevel2Answers[$key].'|';
                        }
                    }
                    
                    // если нет вариантов ответов, так как те что есть совпадают с теми, что были на предыдущем шаге
                    else {
                        return 'next';
                    }
                    
                    $q[0]['answers'] = trim($q[0]['answers'],'|'); 
                }
                
            }
            // ----------------------------------------------------------------
            
            // вытаскиваем варианты для level3, в зависимости от того, что пользователь выбрал на предыдущем шаге
            
            if ($q[0]['name'] == 'level3') {
                
                $answersTextLevel1 = array();
                $arrLevel2 = array();
                $arrLevel2Answers = array();
                
                // достаём предыдущий ответ
                $prevAnswerDb = db_query("SELECT answer, answer_text  
                FROM users_quiz_answers 
                WHERE quiz_id='".$quiz_id."' 
                AND name='level2'
                LIMIT 1");
                
                if ($prevAnswerDb != false) {
                  
                   $answersId = trim($prevAnswerDb[0]['answer'],'|');
                   $answersId = str_replace(';','|',$answersId);
                   $answersId = str_replace('|',',',$answersId);
                   
                   $where = " id_level2 IN (".$answersId.") ";
                   
                   
                   $prevAnswerDb2 = db_query("SELECT answer, answer_text  
                   FROM users_quiz_answers 
                   WHERE quiz_id='".$quiz_id."' 
                   AND name='level1'
                   LIMIT 1");
                   
                   if ($prevAnswerDb2 != false) {
                      $answersId2 = trim($prevAnswerDb2[0]['answer'],'|');
                      $answersId2 = str_replace('|',',',$answersId2);
                      
                      $where = " id_level2 IN (".$answersId.") OR id_level1 IN (".$answersId2.") ";
                   }
                   
                   $answersText = trim($prevAnswerDb[0]['answer_text'],'|');
                   $r = explode('|',$answersText);
                
                   foreach($r as $rb) {
                      $answersTextLevel1[ $rb ] = 1;
                   }
                   
                   $list = db_query("SELECT DISTINCT level3_id, level3 
                   FROM dict 
                   WHERE ( id_level2 IN (".$answersId.") 
                   OR id_level1 IN (".$answersId2.") )
                   AND online_id IN (".$answersIdOnline.") 
                   ORDER BY group_count DESC 
                   LIMIT 16");
                   
                }
                
                else {
                   // достаём предыдущий ответ
                   $prevAnswerDb = db_query("SELECT answer, answer_text  
                   FROM users_quiz_answers 
                   WHERE quiz_id='".$quiz_id."' 
                   AND name='level1'
                   LIMIT 1");
                
                   $answersId = trim($prevAnswerDb[0]['answer'],'|');
                   $answersId = str_replace('|',',',$answersId);
                
                   $answersText = trim($prevAnswerDb[0]['answer_text'],'|');
                   $r = explode('|',$answersText);
                
                   foreach($r as $rb) {
                      $answersTextLevel1[ $rb ] = 1;
                   }
                
                   $list = db_query("SELECT level3_id, level3 
                   FROM dict 
                   WHERE id_level1 IN (".$answersId.") 
                   AND online_id IN (".$answersIdOnline.") 
                   GROUP BY level3_id");
                }
                
                if ($list != false) {
                     foreach($list as $ls) {   
                    
                       // убираем слово Онлайн из названия
                       $level3 = trim( str_replace(array('онлайн','ОНЛАЙН','Онлайн'),'',$ls['level3']) );
                       
                       if (empty($arrLevel2Answers[ $level3 ])) {
                          $arrLevel2Answers[ $level3 ] = $ls['level3_id'];
                       }
                       
                       else {
                          $arrLevel2Answers[ $level3 ] .= ';'.$ls['level3_id'];
                       }
                       
                       // группируем по одинаковым названиям и исключаем те названия, которые были на предыдущем шаге
                       if (empty($answersTextLevel1[ $level3 ])) {
                         $arrLevel2[ $level3 ] = $level3;
                       }
                    }
                    
                    if (!empty($arrLevel2)) {
                        foreach($arrLevel2 as $key=>$val) {
                            $q[0]['answers'] .= $key.'='.$arrLevel2Answers[$key].'|';
                        }
                    }
                    
                    
                    // если нет вариантов ответов, так как те что есть совпадают с теми, что были на предыдущем шаге
                    else {
                       return 'next';
                    }
                    
                    
                    $q[0]['answers'] = trim($q[0]['answers'],'|'); 
                }
                
            }
            // ----------------------------------------------------------------
        }
        
        if (!empty($q[0]['answers'])) {
            $v = explode('|',$q[0]['answers']);
            
            if (count($v) > 4) {
                $column = 6;
            }
            
            foreach($v as $val) {
                $value = explode('=',$val);
                $questArr[ $value[1] ] = $value[0];
            }   
        }
        
       
        
        $percentNum = $q[0]['number'] - 1;
        
        $percent = ($percentNum / $total) * 100;
        $percent = round($percent);
        
        $result = array(
          'type' => $q[0]['type'],
          'question' => $q[0]['question'],
          'description' => $q[0]['description'],
          'arr' => $questArr,
          'answers' => $q[0]['answers'],
          'column' => $column,
          'number' => $q[0]['number'],
          'name' => $q[0]['name'],
          'total' => $total,
          'percent' => $percent
        );
        
        return  $result;
    }
    
   return false;
}