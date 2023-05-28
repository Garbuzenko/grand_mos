<?php

$xc['topMenu'] = null;

$menu = db_query("SELECT * 
        FROM shop_category 
        WHERE shop_id=".SHOP_ID." 
        AND hidden=0");
        
if ($menu != false) {
    foreach($menu as $b) {
        $xc['topMenu'][ $b['parent_id'] ][ $b['id'] ] = $b['name']; 
    }
}