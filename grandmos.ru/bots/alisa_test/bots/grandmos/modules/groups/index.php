<?php

$description = "";
if (empty($account)){
        $title = "Вам необходимо зарегистрироваться, для регистрации скажите войти";
      
}
else{

        $sql = "SELECT g.level3, s.date FROM groups_signed as s INNER JOIN groups as g on g.group_id = s.group_id WHERE s.user_id=" . $account . " LIMIT 5";
        // echo  $sql;
        $q = db_query($sql);
        
        $i = 0;

        if ($q != false) {
                foreach($q as $b) {
                        $mdate = date("d.m.Y", strtotime($b['date']));
                        $add = $b['level3'].", дата ".$mdate."\n";

                        $i++;
                        $description .= $i.'. '.$add;
                }
        }

        $sql = "SELECT DISTINCT level3, date_last FROM attend_stat WHERE user_id=" . $account . " and date_last >= '2023-01-01' LIMIT 5";
        $q = db_query($sql);

        if ($q != false) {
                foreach($q as $b) {
                        $mdate = date("d.m.Y", strtotime($b['date_last']));
                        $add = $b['level3'].", дата ".$mdate."\n";

                        $i++;
                        $description .= $i.'. '.$add;
                }
        }

        $title = "Ваши группы:\n";


}
$tts = $title ." ". $description;
$content = get_text_card($protocol, $data, $buttons, $title, $description, $tts, false);