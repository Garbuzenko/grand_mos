<?php

$xc['modules'] = array(
   '/start' => 'start/index.php'
);

if (empty($xc['module'])) {
    
    $typeMessage = typeMessage($arr);
    
    if ($typeMessage == 'bot_command') {
        
        if ( !empty($xc['modules'][ $arr['message']['text'] ]) ) {
            $xc['module'] = $xc['modules'][ $arr['message']['text'] ];
        } 
    
    }
    
    if (empty($xc['module'])) {
        $xc['module'] = $xc['modules']['/start'];
    }
}