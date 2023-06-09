<?php

$tg_id = 0;

if (!empty($xc['url']['tg_id'])) {
    $tg_id = clearData($xc['url']['tg_id'],'int');
}

