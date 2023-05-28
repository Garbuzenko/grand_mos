<?php

$description = "";

$q = db_query("SELECT *  
        FROM groups   
        WHERE MATCH (level1,level2,level3, address_full, district) AGAINST ('" . $text  . "')  and online='Нет' and (last_date > '2023-01-01' or test = 1)
        LIMIT 10");
   // GROUP BY level3, address

        // SELECT * FROM `groups` WHERE MATCH (level1,level2,level3, address_full, district) AGAINST ("Пение Коньково") and online='Нет'    GROUP BY level3, address  LIMIT 10

$i = 1;
if ($q != false) {
    foreach($q as $b) {
        $address = $b['address'];
        $address = str_ireplace("город Москва, ","", $address);
        $address = str_ireplace("г. Москва, ","", $address);
        $description .= $i.'. '.$b['level3'].', '. $b['district']. "\n📌".$address."\n\n";
        $i++;
    }
}

$title = 'Удалось найти:\n';
$tts = 'Я нашла: '." ".$description;

$content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);