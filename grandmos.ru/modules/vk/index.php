<?php

define('CLIENT_SECRET', ''); // Защитный ключ приложения, для проверки подписи

$url = $_SERVER['REQUEST_URI'];
$query_params = [];
parse_str(parse_url($url, PHP_URL_QUERY), $query_params); // Получаем query-параметры из URL

$sign_params = [];
foreach ($query_params as $name => $value) {
    if (strpos($name, 'vk_') !== 0) { // Получаем только vk параметры из query
      continue;
    }

    $sign_params[$name] = $value;
}

ksort($sign_params); // Сортируем массив по ключам 
$sign_params_query = http_build_query($sign_params); // Формируем строку вида "param_name1=value&param_name2=value"
$sign = rtrim(strtr(base64_encode(hash_hmac('sha256', $sign_params_query, CLIENT_SECRET, true)), '+/', '-_'), '='); // Получаем хеш-код от строки, используя защищеный ключ приложения. Генерация на основе метода HMAC. 

$status = $sign === $query_params['sign']; // Сравниваем полученную подпись со значением параметра 'sign'

//echo ($status ? 'ok' : 'fail')."\n";

$search = null;

if ($status == true) {
    
    $xc['vk'] = true;
    
    $add = db_query("INSERT INTO vk_app_users (
    app_id,
    is_app_user,
    is_favorite,
    platform,
    ref,
    user_id,
    date,
    datetime) VALUES (
    '".$query_params['vk_app_id']."',
    '".$query_params['vk_is_app_user']."',
    '".$query_params['vk_is_favorite']."',
    '".$query_params['vk_platform']."',
    '".$query_params['vk_ref']."',
    '".$query_params['vk_user_id']."',
    '".date('Y-m-d')."',
    '".time()."'
    )","i");
    
    $vk_id = $query_params['vk_user_id'];
}
?>

