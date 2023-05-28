<?php

// функция для рассчёта вхождения точки в полигон
function contains($point, $polygon) {
    
    if($polygon[0] != $polygon[count($polygon)-1])
        $polygon[count($polygon)] = $polygon[0];
    
    //exit(print_r($polygon));
    
    
    $j = 0;
    $oddNodes = false;
    $x = $point[1];
    $y = $point[0];
    $n = count($polygon);
    for ($i = 0; $i < $n; $i++)
    {
        $j++;
        if ($j == $n)
        {
            $j = 0;
        }
        if ((($polygon[$i][0] < $y) && ($polygon[$j][0] >= $y)) || (($polygon[$j][0] < $y) && ($polygon[$i][0] >=
            $y)))
        {
            if ($polygon[$i][1] + ($y - $polygon[$i][0]) / ($polygon[$j][0] - $polygon[$i][0]) * ($polygon[$j][1] -
                $polygon[$i][1]) < $x)
            {
                $oddNodes = !$oddNodes;
            }
        }
    }
    return $oddNodes;
}

/*
function distance($lat_1, $lon_1, $lat_2, $lon_2) {

    $radius_earth = 6371; // Радиус Земли

    $lat_1 = deg2rad($lat_1);
    $lon_1 = deg2rad($lon_1);
    $lat_2 = deg2rad($lat_2);
    $lon_2 = deg2rad($lon_2);

    $d = 2 * $radius_earth * asin(sqrt(sin(($lat_2 - $lat_1) / 2) ** 2 + cos($lat_1) * cos($lat_2) * sin(($lon_2 - $lon_1) / 2) ** 2));

    return $d;
}
*/

function str_replace_once($search, $replace, $text){ 
   $pos = strpos($text, $search); 
   return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text; 
}

function randomDate($start_date, $end_date) {
    // Convert to timetamps
    $min = strtotime($start_date);
    $max = strtotime($end_date);

    // Generate random number using above bounds
    $val = rand($min, $max);

    // Convert back to desired date format
    return date('Y-m-d', $val);
}

function delSimbolsInStaples($text) {
    $str = preg_replace("/\(.+\)/m","",$text);
    return trim($str);
}

function videoIframe($title,$url) {
    
    $result = null;
    
    if (preg_match('/youtu/is',$url)) {
        
        $u = explode('/',$url);
        $code = array_pop($u);
        $code = trim(str_replace('watch?v=','',$code));
        
        $height = 400;
        
        if (MOBILE == true) {
            $height = 280;
        }
        
        $result = '<iframe width="100%" height="'.$height.'" src="https://www.youtube.com/embed/'.$code.'" title="'.$title.'" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }
    
    return $result;
}

// высчитывание центральной точки среди нескольких точек
function centerCoor($coordArr) {
    
    $result = array();
    $lng = null;
    $lat = null;
    
    foreach($coordArr as $key=>$val) {
        $lng += $val['lng'];
        $lat += $val['lat'];
    }
    
    $lng = $lng / count($coordArr);
    $lat = $lat / count($coordArr);
    
    $result = array($lng,$lat);
    return $result;
} 


function ceilingHeightStr($ceilingHeightArr) {
    
    $result = null;
    
    $min = min($ceilingHeightArr);
    $max = max($ceilingHeightArr);
    
    $min = rtrim(rtrim($min, '0'), '.');
    $max = rtrim(rtrim($max, '0'), '.');
    
    $result = 'от '.$min.' до '.$max.' м';
    
    if ($min == $max) {
        $result = $min.' м';
    }
    
    
    //$result = str_replace('.',',',$result);
    
    return $result;
    
}

function levelsStr($levelsArr) {
    
    $result = null;
    
    $min_levels = min($levelsArr);
    $max_levels = max($levelsArr);
    
    $result = $min_levels.' - '.$max_levels;
    
    if ($min_levels == $max_levels) {
        $result = $min_levels;
    }
    
    return $result;
}

function deadlineStr($deadlineArr) {
    
    $result = null;
    
    if (!empty($deadlineArr)) {
      
      ksort($deadlineArr);
    
      $firstDeadline = array_shift($deadlineArr);
      $lastDeadline = array_pop($deadlineArr);
      
      $result = $firstDeadline.' - '.$lastDeadline;
      
      if (empty($lastDeadline)) {
        $result = $firstDeadline;
      }
      
     }
     
     return $result;
}

function transformDeadline($date,$short=true) {
    
    $result = null;
    
    $v = explode('-',$date);
    $dm = $v[1].'-'.$v['2'];
    $year = $v[0];
    
    $deadlineArr = array(
      '03-31' => 1,
      '06-30' => 2,
      '09-30' => 3,
      '12-31' => 4
    );
    
    if (!empty($deadlineArr[ $dm ])) {
        if ($short == true) {
            $result = $deadlineArr[ $dm ].' кв. '.$year.' г.';
        }
    }
    
    else {
        $result = 'сдан';
    }
    
    return $result;
    
}

function deadlineArr() {
    
    $today = date('Y-m-d');
    $year = date("Y");

    $deadlineArr = array(
      1 => '03-31',
      2 => '06-30',
      3 => '09-30',
      4 => '12-31'
    );
    
    $arr[] = array('name' => 'Сдан', 'date' => '0000-00-00');

    foreach ($deadlineArr as $k => $v) {
        
        if ( $today <= $year . '-' . $v) {

            //$k++;

            if ($k == 5) {
                $year++;
                $kv = '1 квартал ' . $year;
                $k = 1;
            } 
            
            else {
                $kv = $k . ' квартал ' . $year;
            }
            
            $arr[] = array( 'name' => $kv, 'date' => $year . '-' . $deadlineArr[$k] );
            break;
        }

    }
    
    for ($i = 1; $i <= 12; $i++) {
        
        $k++;

        if ($k == 5) {
            $year++;
            $kv = '1 квартал ' . $year;
            $k = 1;
        } else
            $kv = $k . ' квартал ' . $year;

        $arr[] = array( 'name' => $kv, 'date' => $year . '-' . $deadlineArr[$k]);
    }

    return $arr;
    
}

function activity_btn_color($date) {
    
    $btn = null;
    $today = date('Y-m-d');
    
    $btnColor = array(
     'green' => 'success',
     'orange' => 'warning',
     'red' => 'danger'
    );
    
    if ($date > $today) {
      $btn = $btnColor['green'];
    }
            
    if ($date == $today) {
      $btn = $btnColor['orange'];
    }
            
    if ($date < $today) {
      $btn = $btnColor['red'];
    }
    
    return $btn;
}

function transformDateTime($time, $time_zone) {
    
    //setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');  
    
    $time += $time_zone * 3600;
    $day = date('d',$time);
    $year = date('Y',$time);
    $month = monthFormatPrint(date('m',$time), 2);
    
    $date = $day.' '.$month.' '.$year;
    //$date = strftime("%d %B %Y", $time);
    $date .= ' в '.date("H:i",$time);
    return $date;
}

function userName($first_name,$middle_name,$last_name) {
    
    $name = null;
    
    $name = $last_name;
    
    if (!empty($first_name)) {
        $name .= ' '.mb_substr($first_name,0,1).'.';
    }
    
    if (!empty($middle_name)) {
        $name .= ' '.mb_substr($middle_name,0,1).'.';
    }
    
    return $name;
}

function paginationPlanAjax($ajaxLoad, $scroll, $start, $num, $col, $page, $filter=null) {
    
    $nav = null;
    $total = (($col - 1) / $num) + 1;
    $total = intval($total);
    
    $finish = $start + $num;
    
    if ($finish > $col) {
        $finish = $col;
    }
    
    if ($page > $total) {
        $page = $total;
    }
     
    $thisPage = '<li class="active"><a href="#" data-page="">'.$page.'</a></li>';

    if ($page > 2) {
       $pervpage = "<li class='pager'><a href='#' class='jsShowPage' data-filter='".$filter."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".($page - 1)."'>‹</a> <li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='1'>1</a></li>";
    }
        
    else if ($page == 2) {
        $pervpage = "<li class='pager'><a href='#' class='jsShowPage' data-filter='".$filter."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='1'>‹</a> <li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='1'>1</a></li>";
    }
              
    else {
      $pervpage = '<li class="active"><a href="#" data-page="">1</a></li>';
      $thisPage = '';
    }

    if ($page != $total) {
      $nextpage = "<li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".$total."'>".$total."</a></li> <li class='pager'><a href='#' class='jsShowPage' data-filter='".$filter."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".($page + 1)."'>›</a></li>";      
    }
            
    else {
      $nextpage = '<li class="active"><a href="#" data-page="">'.$total.'</a></li>';
      $thisPage = '';
    }

    for ($i = 1; $i <= 3; $i++) {
            
      if ($page - $i > 1) {
        $pageNav[$i] = "<li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".($page-$i)."'>".($page-$i)."</a></li>";    
      }
                
      if ($page + $i < $total) {
        $pageNav2[$i] = "<li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".($page+$i)."'>".($page+$i)."</a></li>";
      }
                
    }

    if ($total > 1) {
        Error_Reporting(E_ALL & ~ E_NOTICE);
        $nav .= '<nav class="dataTable-pagination"><ul class="dataTable-pagination-list">';
        $nav .= $pervpage . $pageNav[3] . $pageNav[2] . $pageNav[1] . $thisPage . $pageNav2[1] . $pageNav2[2] . $pageNav2[3] . $nextpage;
        $nav .= '</ul></nav>';
    }

    return $nav;
}

function paginationAdminAjax($mod, $com, $ajaxLoad, $scroll, $start, $num, $col, $page, $filter=null) {
    
    $nav = null;
    $total = (($col - 1) / $num) + 1;
    $total = intval($total);
    
    $finish = $start + $num;
    
    if ($finish > $col) {
        $finish = $col;
    }
    
    if ($page > $total) {
        $page = $total;
    }
     
    $thisPage = '<li class="active"><a href="#" data-page="">'.$page.'</a></li>';

    if ($page > 2) {
       $pervpage = "<li class='pager'><a href='#' class='jsShowPage' data-filter='".$filter."' data-mod='".$mod."' data-com='".$com."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".($page - 1)."'>‹</a> <li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-mod='".$mod."' data-com='".$com."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='1'>1</a></li>";
    }
        
    else if ($page == 2) {
        $pervpage = "<li class='pager'><a href='#' class='jsShowPage' data-filter='".$filter."' data-mod='".$mod."' data-com='".$com."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='1'>‹</a> <li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-mod='".$mod."' data-com='".$com."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='1'>1</a></li>";
    }
              
    else {
      $pervpage = '<li class="active"><a href="#" data-page="">1</a></li>';
      $thisPage = '';
    }

    if ($page != $total) {
      $nextpage = "<li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-mod='".$mod."' data-com='".$com."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".$total."'>".$total."</a></li> <li class='pager'><a href='#' class='jsShowPage' data-filter='".$filter."' data-mod='".$mod."' data-com='".$com."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".($page + 1)."'>›</a></li>";      
    }
            
    else {
      $nextpage = '<li class="active"><a href="#" data-page="">'.$total.'</a></li>';
      $thisPage = '';
    }

    for ($i = 1; $i <= 3; $i++) {
            
      if ($page - $i > 1) {
        $pageNav[$i] = "<li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-mod='".$mod."' data-com='".$com."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".($page-$i)."'>".($page-$i)."</a></li>";    
      }
                
      if ($page + $i < $total) {
        $pageNav2[$i] = "<li class=''><a href='#' class='jsShowPage' data-filter='".$filter."' data-mod='".$mod."' data-com='".$com."' data-ajax-load='".$ajaxLoad."' data-scroll='".$scroll."' data-page='".($page+$i)."'>".($page+$i)."</a></li>";
      }
                
    }

    if ($total > 1) {
        Error_Reporting(E_ALL & ~ E_NOTICE);
        $nav .= '<div class="dataTable-bottom">';
        
        if (MOBILE == false) {
           $start++;
           $nav .= '<div class="dataTable-info">Показаны с '.$start.' по '.$finish.' из '.$col.'</div>';
        }
        
        $nav .= '<nav class="dataTable-pagination"><ul class="dataTable-pagination-list">';
        $nav .= $pervpage . $pageNav[3] . $pageNav[2] . $pageNav[1] . $thisPage . $pageNav2[1] . $pageNav2[2] . $pageNav2[3] . $nextpage;
        $nav .= '</ul></nav>';
        $nav .= '</div>';
    }

    return $nav;
}

function transformUtcDate($date,$time_zone) {
    
    $a = strtotime($date);
    $hours = $time_zone * 3600;
    $time = $a + $hours;
    
    return date('d.m.Y в H:i',$time); 
}

function mb_ucfirst($str, $encoding='UTF-8') {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
}

function rus2translit($string) {

    $converter = array(

        'а' => 'a',   'б' => 'b',   'в' => 'v',

        'г' => 'g',   'д' => 'd',   'е' => 'e',

        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',

        'и' => 'i',   'й' => 'y',   'к' => 'k',

        'л' => 'l',   'м' => 'm',   'н' => 'n',

        'о' => 'o',   'п' => 'p',   'р' => 'r',

        'с' => 's',   'т' => 't',   'у' => 'u',

        'ф' => 'f',   'х' => 'h',   'ц' => 'c',

        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',

        'ь' => '',    'ы' => 'y',   'ъ' => '',

        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        
        'А' => 'a',   'Б' => 'b',   'В' => 'v',

        'Г' => 'g',   'Д' => 'd',   'Е' => 'e',

        'Ё' => 'e',   'Ж' => 'zh',  'З' => 'z',

        'И' => 'i',   'Й' => 'y',   'К' => 'k',

        'Л' => 'l',   'М' => 'm',   'Н' => 'n',

        'О' => 'o',   'П' => 'p',   'Р' => 'r',

        'С' => 's',   'Т' => 't',   'У' => 'u',

        'Ф' => 'f',   'Х' => 'h',   'Ц' => 'c',

        'Ч' => 'ch',  'Ш' => 'sh',  'Щ' => 'sch',

        'Ь' => '',    'Ы' => 'y',   'Ъ' => '',

        'Э' => 'e',   'Ю' => 'yu',  'Я' => 'ya'

    );

    return strtr($string, $converter);

}

function save_document($filename, $tmpname, $name, $uploaddir) {
    $blacklist = array(
        ".php",
        ".phtml",
        ".php3",
        ".php4",
        ".html",
        ".htm",
        ".js",
        ".inc",
        ".sql",
        ".exe");
    foreach ($blacklist as $item) {
        if (preg_match("/$item\$/i", $filename))
            return 'Недопустимый формат документа';
    }

    $uploadfile = $_SERVER['DOCUMENT_ROOT'] . "/" . $uploaddir . $name;
    move_uploaded_file($tmpname, $uploadfile);

    if (!file_exists($uploadfile))
        return 'Не удалось загрузить файл на сервер';

    return true;
}

function translit($value)
{
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
 
		'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
		'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
		'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
		'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
		'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
		'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
		'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
	);
 
	$value = strtr($value, $converter);
	return $value;
}

function get_filename($address) {
    $filename = $address;
    $filename = mb_strtolower($filename);  
    $filename = delSimbolsInStaples($filename);
    $filename = translit($filename);
    $filename = preg_replace("/\,/","-",$filename);
    $filename = preg_replace("/[^А-Яа-яA-Za-zЁё0-9\s]/"," ",$filename);
    $filename = preg_replace('/\s+/',' ',$filename);
    //$filename = rus2translit($filename);
    //$filename = strtr($filename, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
    $filename = str_replace(" ","-",trim( $filename ) );
    $filename = preg_replace('#(-|-\s){2,}#','\1', $filename); 
    
    return $filename;    
}

function geocoder($address)
{    
    $addr = urlencode($address);
    
    $res = file_get_contents('https://geocode-maps.yandex.ru/1.x/?geocode=' . $addr.'&apikey='.YANDEX_API_KEY);
    $parse = simplexml_load_string($res);
    $pos = $parse->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
    if (!empty($pos)) {
        $lt = explode(' ', $pos);
        $lng = $lt[0];
        $lat = $lt[1];
        return array($lng, $lat);
    }

    return false;
}

function clearData($data, $type = 'str')
{
    
    global $xc;

    switch ($type) {

        case 'str':
            return mysqli_real_escape_string( $xc['db'], trim(stripslashes(strip_tags($data))));
            break;
        
        case 'str2':
            return mysqli_real_escape_string( $xc['db'], trim(stripslashes($data)));
            break;
           
        case 'redactor':
            return stripslashes($data);
            break;

        case 'int':
            return preg_replace('/[^0-9]/', '', $data);
            break;

        case 'get':
            return preg_replace('/[^a-zA-Z0-9-_]/', '', $data);
            break;

        case 'guid':
            return preg_replace('/[^a-z0-9-]/', '', $data);
            break;

        case 'area':
            return preg_replace('/[^0-9\.]/', '', str_replace(',', '.', $data));
            break;

        case 'date':
            return preg_replace('/[^0-9-]/', '', $data);
            break;

        case 'domain':
            return preg_replace('/[^a-z0-9-\.]/', '', $data);
            break;
    }
}

function compress($buffer)
{
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    $buffer = preg_replace('/\/\/.*\r\n/', '', $buffer);
    $buffer = str_replace(array(
        "\r\n",
        "\r",
        "\n",
        "\t",
        '  ',
        '    ',
        '    '), '', $buffer);
    return $buffer;
}

function combine($format, $ver, $name, $adm, $domain) {   
    
    $s = null;
    $j = null;
    
    //if ($format == 'js')
       //$j = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $format . '/jquery.' .$format);
    
    $s = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $domain . $adm . '/' . $format .'/main.' . $format);
    
    $path = $_SERVER['DOCUMENT_ROOT'] . $domain . $adm . '/modules';
    $files = @scandir($path);
    
    if ($files != false) {
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                
                $f = $_SERVER['DOCUMENT_ROOT'] . $domain . $adm . '/modules/' . $file . '/' . $format . '/' . $name . '.' . $format;
                
                if (file_exists($f) && @filesize($f) > 0) {
                    $s .= file_get_contents($f);
                }
                     
                $pathCom = $_SERVER['DOCUMENT_ROOT'] . $domain . $adm . '/modules/' . $file . '/components';
                $com = @scandir($pathCom);

                if ($com != false) {
                    foreach ($com as $b) {
                        if ($b != '.' && $b != '..') {
                            $y = $_SERVER['DOCUMENT_ROOT'] . $domain . $adm . '/modules/' . $file . '/components/' . $b . '/' . $format . '/' . $name . '.' . $format;
                            
                            if (file_exists($y) && @filesize($y) > 0) {
                                $s .= file_get_contents($y);
                            }    
                        }
                    }
                }
            }
        } 
    }
    
    if (!empty($s)) {
        
        $s = compress($s);
    
        if ($format == 'js') {
            $s = $j . '$(document).ready(function(){' . $s . '});';
        }
        
    }
    
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . $domain . $adm . '/' . $format .'/' . $name . $ver . '.' . $format, $s);
        
    return $name . $ver . '.' . $format;
}

function get_file($format, $update, $admin = false, $domain = null)
{   
    $name = 'scripts';
    
    if ($format == 'css')
        $name = 'style';
    
    // для алминки
    $adm = null;
    
    if ($admin == true)
        $adm = '/admin';
    // ----------------------------------------------
    
    $version = current_version($format, $adm, $domain);
    
    if ($version == false)
      $version = 0;
    
    // если нужно обнвлять css стили и js скрипты при каждой перезагрузке страницы
    if ($update == true) {
        
        $ver = $version + 1;
        
        $s = combine($format, $ver, $name, $adm, $domain);
        
        if ($s !== false) {
           @unlink($_SERVER['DOCUMENT_ROOT'] . $domain . $adm . '/' . $format . '/' . $name . $version . '.' . $format);
           return $s;
        }

    }
    
    return $name . $version . '.' . $format;
}

// узнать текущую версию css или js файла
function current_version($format, $adm, $domain) {
    
    $file = 'style';
    $arr = array();
    
    if ($format == 'js')
      $file = 'scripts';
    
    $path = $_SERVER['DOCUMENT_ROOT'] . $domain . $adm . '/' . $format;
    
    $files = @scandir($path);
    
    if ($files != false) {
        foreach($files as $f) {
            if ($f != '.' && $f != '..') {
                if (preg_match('/'.$file.'/is',$f)) {
                    $ver = intval( clearData($f,'int') );
                    $arr[] = $ver;
                }
                
            }
        }
        
        if (empty($arr))
          return false;
        
        $version = max($arr);
        
        // если найдено больше одного файла нужного формата
        if (count($arr) > 1) {
            foreach($arr as $key=>$val) {
              if ($val!=$version) {
                // удаляем лишине файлы
                unlink($_SERVER['DOCUMENT_ROOT']. $domain . $adm . '/' . $format . '/' . $file . $val . '.' . $format);
              }
            }
        }
        
        return $version;
        
    }
    
    return false;
}

function is_mobile($agent) {
    $result = false;
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',
        $agent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
        substr($agent, 0, 4)))
        $result = true;

    return $result;
}

function encrypt_pass($pass) {
    if ($pass != '') {
        $pass = sha1(md5(trim($pass)));
        $pass = md5($pass . PASS_STR);
        return $pass;
    }
    
    return false;
}

function get_hash($login) {
    $a = sha1(md5(time() . $login . mt_rand(1, 100000)));
    return $a;
}

function check_email($email) {

    $email = clearData($email);
    $email = mb_strtolower($email, 'utf-8');
    $result = $email;

    if (!preg_match("/^[a-z0-9\.\-_]+@[a-z0-9\-]{2,20}\.([a-z0-9\-]+\.)*?[a-z]{2,25}$/is",$email))
        $result = false;

    return $result;
}

function format_phone($phone = '', $convert = false, $trim = true) {
    // If we have not entered a phone number just return empty
    if (empty($phone)) {
        return '';
    }

    // Strip out any extra characters that we do not need only keep letters and numbers
    $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);

    // Do we want to convert phone numbers with letters to their number equivalent?
    // Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
    if ($convert == true) {
        $replace = array(
            '2' => array(
                'a',
                'b',
                'c'),
            '3' => array(
                'd',
                'e',
                'f'),
            '4' => array(
                'g',
                'h',
                'i'),
            '5' => array(
                'j',
                'k',
                'l'),
            '6' => array(
                'm',
                'n',
                'o'),
            '7' => array(
                'p',
                'q',
                'r',
                's'),
            '8' => array(
                't',
                'u',
                'v'),
            '9' => array(
                'w',
                'x',
                'y',
                'z'));

        // Replace each letter with a number
        // Notice this is case insensitive with the str_ireplace instead of str_replace
        foreach ($replace as $digit => $letters) {
            $phone = str_ireplace($letters, $digit, $phone);
        }
    }

    // If we have a number longer than 11 digits cut the string down to only 11
    // This is also only ran if we want to limit only to 11 characters
    if ($trim == true && strlen($phone) > 11) {
        $phone = substr($phone, 0, 11);
    }

    // Perform phone number formatting here
    if (strlen($phone) == 7) {
        return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
    } elseif (strlen($phone) == 10) {
        return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3",
            $phone);
    } elseif (strlen($phone) == 11) {
        return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/",
            "$1 ($2) $3-$4", $phone);
    }

    // Return original phone if not 7, 10 or 11 digits long
    return $phone;
}

function generatePass($login, $col) {
    $login = $login . mt_rand(1, 1000000) . time();
    $pass = sha1(md5(md5($login)));
    $pass = substr($pass, 0, 10);
    $pass = md5($pass);
    $pass = substr($pass, 3, $col);
    return $pass;
}

function send_email($email, $subject, $message) {
    
    require_once($_SERVER['DOCUMENT_ROOT'].'/lib/php/phpmailer/PHPMailerAutoload.php');
    
    $name_from = 'tStartup.ru';
	$email_from = 'mail@tstartup.ru';                          
	$name_to = $email;

	$html = TRUE;
	$mail = new PHPMailer;
    $mail->isSMTP(); 
	$mail->Host = 'smtp.yandex.ru';
	$mail->SMTPAuth = true;
	$mail->SMTPAutoTLS = false;                                          
    $mail->Username = 'mail@tstartup.ru';
	$mail->Password = 'txrnvjtnvt'; 
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;
	$mail->SMTPDebug = 3;  
	$mail->From = $email_from;
	$mail->FromName = $name_from;
	$mail->addAddress($email, $name_to);
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $body;        

    if($mail->send()) {
     
	} else {
        $headers = null;
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . $name_from . " <" . $email_from . ">\r\n";
        $headers .= "Reply-To: <" . $email . ">\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    
        mail($email, $subject, $message, $headers);	   
	}
 
}

function monthFormatPrint($month, $return = 1) {
    $month_a = array(
        "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12");
    $month_names_sh_a = array(
        "янв",
        "фев",
        "мар",
        "апр",
        "май",
        "июн",
        "июл",
        "авг",
        "сен",
        "окт",
        "ноя",
        "дек");
    $month_names_full_a = array(
        "января",
        "февраля",
        "марта",
        "апреля",
        "мая",
        "июня",
        "июля",
        "августа",
        "сентября",
        "октября",
        "ноября",
        "декабря");
    if ($return == 1)
        return $month_names_sh_a[array_search($month, $month_a)];
    elseif ($return == 2)
        return $month_names_full_a[array_search($month, $month_a)];
}

function save_img($oldname, $tmpname, $name, $format, $uploaddir, $width, $preview = null) {
    
    $status = false;
    
    if (!preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)|(webp)|(WEBP)$/', $oldname))
        return 'Допускаются только файлы формата jpg, gif и png';

    $filename = $oldname;
    $uploadfile = $_SERVER['DOCUMENT_ROOT'] . "/img/time-pictures/" . $filename;

    move_uploaded_file($tmpname, $uploadfile);

    if (!file_exists($uploadfile))
        return 'Не удалось загрузить файл на сервер';

    $size = getimagesize($uploadfile);
    $new_name = $name . "." . $format;

    if ($size['mime'] == 'image/png')
        $im = imagecreatefrompng($uploadfile);

    if ($size['mime'] == 'image/jpeg')
        $im = imagecreatefromjpeg($uploadfile);

    if ($size['mime'] == 'image/gif')
        $im = imagecreatefromgif($uploadfile);
    
    if ($size['mime'] == 'image/webp')
        $im = imagecreatefromwebp($uploadfile);   

    if ($size[0] > $width)
        $height = floor($size[1] * ($width / $size[0]));

    else {
        $width = $size[0];
        $height = $size[1];
    }

    $new_image = imagecreatetruecolor($width, $height);
    imagealphablending($new_image, false);
    imagesavealpha($new_image, true);
    imagecopyresampled($new_image, $im, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);

    if ($format == 'jpg')
        imagejpeg($new_image, $_SERVER['DOCUMENT_ROOT'] . "/" . $uploaddir . $new_name);

    else
        imagepng($new_image, $_SERVER['DOCUMENT_ROOT'] . "/" . $uploaddir . $new_name);
     
     
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $uploaddir . $new_name)) {
       $status = true;
    }
    
    // создание preview картинки
    if (!empty($preview)) {
        $width = intval($preview);
        $height = floor($size[1] * ($width / $size[0]));

        $new_image = imagecreatetruecolor($width, $height);
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
        imagecopyresampled($new_image, $im, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        imagejpeg($new_image, $_SERVER['DOCUMENT_ROOT'] . "/" . $uploaddir . 'preview-' . $name . '.jpg');

    }
    // --------------------------------------------------------------------------------
    unlink($uploadfile);
    
    return $status;
}

function callbackFunction($arr) {
    $arr = json_encode($arr);
    return $arr;
}

function lang_function($num, $word, $result = 1) {
    $num_1_a = array(1);
    $num_2_a = array(
        2,
        3,
        4);
    $words_a = array(
        'метр' => array(
            'метр',
            'метра',
            'метров'),
        'дом' => array(
            'дом',
            'дома',
            'домов'),
        'адрес' => array(
            'адрес',
            'адреса',
            'адресов'),
        'очередь' => array(
            'очередь',
            'очереди',
            'очередей'),
        'секция' => array(
            'секция',
            'секции',
            'секций'),
        'каналу' => array(
            'каналу',
            'каналам',
            'каналам'),
        'доллар' => array(
            'доллар',
            'доллара',
            'долларов'),
        'цент' => array(
            'цент',
            'цента',
            'центов'),
        'рубль' => array(
            'рубль',
            'рубля',
            'рублей'),
        'копейка' => array(
            'копейка',
            'копейки',
            'копеек'),
        'балл' => array(
            'балл',
            'балла',
            'баллов'),
        'участник' => array(
            'участник',
            'участника',
            'участников'),
        'клиент' => array(
            'клиент',
            'клиента',
            'клиентов'),
        'сотрудник' => array(
            'сотрудник',
            'сотрудника',
            'сотрудников'),
        'день' => array(
            'день',
            'дня',
            'дней'),
        'найден' => array(
            'найден',
            'найдено',
            'найдено'),
        'год' => array(
            'год',
            'года',
            'лет'));
    if ($result == 1) {
        if (substr($num, -2, 2) > 10 and substr($num, -2, 2) < 20) {
            return $num . ' ' . $words_a[$word][2];
        } else {
            if (in_array(substr($num, -1), $num_1_a))
                return $num . ' ' . $words_a[$word][0];
            elseif (in_array(substr($num, -1), $num_2_a))
                return $num . ' ' . $words_a[$word][1];
            else
                return $num . ' ' . $words_a[$word][2];
        }
    } elseif ($result == 2) {
        if (substr($num, -2, 2) > 10 and substr($num, -2, 2) < 20) {
            return $words_a[$word][2];
        } else {
            if (in_array(substr($num, -1), $num_1_a))
                return $words_a[$word][0];
            elseif (in_array(substr($num, -1), $num_2_a))
                return $words_a[$word][1];
            else
                return $words_a[$word][2];
        }
    }
}

// постраничная навигация
function pagination($num, $col, $page, $form)
{   
    $nav = null;
    $total = (($col - 1) / $num) + 1;
    $total = intval($total);
    
    if ($page > $total)
      $page = $total;

    $thisPage = '<li class="paginate_button page-item active">
    <a href="#" aria-controls="datatable-buttons" data-page="'.$page.'" tabindex="0" class="page-link">'.$page.'</a>
    </li>';

    if ($page >= 2) {
        
        $pervpage = '<li class="paginate_button page-item previous" id="datatable-buttons_previous">
        <a href="#" aria-controls="datatable-buttons" data-page="'.($page - 1).'" data-form="'.$form.'" tabindex="0" class="page-link jsAjaxNav">Назад</a>
        </li>
        <li class="paginate_button page-item">
        <a href="#" aria-controls="datatable-buttons" data-page="1" data-form="'.$form.'" tabindex="0" class="page-link jsAjaxNav">1</a>
        </li>
        ';
        
    } else {
        $pervpage = '<li class="paginate_button page-item previous disabled" id="datatable-buttons_previous">
        <a href="#" aria-controls="datatable-buttons" data-page="1" tabindex="0" class="page-link">Назад</a>
        </li>
        <li class="paginate_button page-item active">
        <a href="#" aria-controls="datatable-buttons" data-page="1" tabindex="0" class="page-link">1</a>
        </li>';
        $thisPage = '';
    }
        
        
    if ($page != $total) {
        
        $nextpage = '<li class="paginate_button page-item">
        <a href="#" aria-controls="datatable-buttons" data-page="'.$total.'" data-form="'.$form.'" tabindex="0" class="page-link jsAjaxNav">'.$total.'</a>
        </li>
        <li class="paginate_button page-item next" id="datatable-buttons_next">
        <a href="#" aria-controls="datatable-buttons" data-page="'.($page + 1).'" data-form="'.$form.'" tabindex="0" class="page-link jsAjaxNav">Далее</a>
        </li>';
        
    }
            
    else {
        
      $nextpage = '<li class="paginate_button page-item active">
      <a href="#" aria-controls="datatable-buttons" data-page="'.$total.'" tabindex="0" class="page-link">'.$total.'</a>
      </li>
      <li class="paginate_button page-item next disabled" id="datatable-buttons_next">
      <a href="#" aria-controls="datatable-buttons" data-page="'.($page + 1).'" tabindex="0" class="page-link">Далее</a>
      </li>';  
        
      $thisPage = '';
    }

    for ($i = 1; $i <= 3; $i++) {
      if ($page - $i > 1) {
        $pageNav[$i] = '<li class="paginate_button page-item">
        <a href="#" aria-controls="datatable-buttons" data-page="'.($page - $i).'" data-form="'.$form.'" tabindex="0" class="page-link jsAjaxNav">'.($page - $i).'</a>
        </li>';
      }
      
      if ($page + $i < $total) {
        $pageNav2[$i] = '<li class="paginate_button page-item ">
        <a href="#" aria-controls="datatable-buttons" data-page="'.($page + $i).'" data-form="'.$form.'" tabindex="0" class="page-link jsAjaxNav">'.($page + $i).'</a>
        </li>';
      }
                
    }

    if ($total > 1) {
        Error_Reporting(E_ALL & ~ E_NOTICE);
        $list = $pervpage . $pageNav[3] . $pageNav[2] . $pageNav[1] . $thisPage . $pageNav2[1] .$pageNav2[2] . $pageNav2[3] . $nextpage;
        
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'].'/admin/modules/data/components/component/includes/pagination.inc.php';
        $nav = ob_get_clean();
    }

    return $nav;
}