<?php

$xc['modules'] = array();

$a = db_query("SELECT * 
     FROM alisa_modules 
     WHERE dialog_id='".$xc['bot_id']."' 
     ORDER BY sort");
     
if ($a != false) {
    foreach($a as $b) {
        $xc['modules'][] = $b['module'];
    }
}