<?php defined('DOMAIN') or exit(header('Location: /'));

$birthday = null;
$phone = null;

if (!empty($xc['userInfo'][0]['birthday']) && $xc['userInfo'][0]['birthday'] != '0000-00-00') {
    $birthday = date('d.m.Y', strtotime($xc['userInfo'][0]['birthday']));
}


if (!empty($xc['userInfo'][0]['phone'])) {
    $phone = clearData($xc['userInfo'][0]['phone'],'int');
    $phone = '+'.format_phone($phone);
}