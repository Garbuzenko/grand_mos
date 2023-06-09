<?php defined('DOMAIN') or exit(header('Location: /'));
$us = db_query("SELECT user_id, age, gender FROM users WHERE test=1");
$url = $_SERVER['REQUEST_URI'];
require_once $_SERVER['DOCUMENT_ROOT'].'/modules/forms/includes/signIn.inc.php';
?>