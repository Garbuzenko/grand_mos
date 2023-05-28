<?php

if (!empty($_POST['act']) && $_POST['act'] == 'show-category') {
    
    $category_id = intval($_POST['id']);
    $category = array();
    $shop_id = intval($_POST['shop_id']);
    
    if (empty($shop_id)) {
        exit('rrrrrrrrr');
    }
    
    // вытаскиваем все категории и подкатегории
    $cat = db_query("SELECT * 
        FROM shop_category 
        WHERE shop_id=".$shop_id." 
        AND hidden=0");
    
    
    if ($cat == false) {
        exit();
    }
    
    foreach($cat as $b) {
       $category[ $b['id'] ] = array('name' => $b['name'], 'parent_id' => $b['parent_id']);
    }
    
    $catTitle = $category[ $category_id ]['name'];
    $subCatTitle = null;
    
    if (!empty($category[ $category_id ]['parent_id'])) {
        
        $catTitle = $category[ $category[ $category_id ]['parent_id'] ]['name'];
        $subCatTitle = $category[ $category_id ]['name'];
    }
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].WEB_BOT.'/modules/category/tmp.inc.php';
    $html = ob_get_clean();
    
    exit($html);
}