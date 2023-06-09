<?php

$a = db_query("SELECT answer, answer_tts 
     FROM alisa_answers 
     WHERE type='".$responseType."' 
     LIMIT 1");
     
if ($a != false) {
    $title = null;
    $description = $a[0]['answer'];
    $tts = null;
    
    if (!empty($a[0]['answer_tts'])) {
        $tts = $a[0]['answer_tts'];
    }

    $content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);
}