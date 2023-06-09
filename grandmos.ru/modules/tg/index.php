<?php defined('DOMAIN') or exit(header('Location: /'));
$xc['telegram'] = true;
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/index.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/modules/search/tmp.inc.php';
$search = ob_get_clean();