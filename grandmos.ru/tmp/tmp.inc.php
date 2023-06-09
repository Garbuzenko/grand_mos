<!DOCTYPE html>
<html class="no-js" lang="ru">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$xc['title'];?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?if(!empty($xc['canonical'])):?>
    <link rel="canonical" href="<?=$xc['canonical'];?>"/>
    <?endif;?>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?=DOMAIN;?>/template/assets/media/favicon.png">
    
   <link rel="stylesheet" href="<?=DOMAIN;?>/template/assets/css/vendor/bootstrap.min.css">
   
   <link rel="stylesheet" href="<?=DOMAIN;?>/template/assets/css/vendor/font-awesome.css">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="<?=DOMAIN;?>/template/assets/css/app.css">
    
    <?=$xc['head'];?>
    
    <link rel="stylesheet" href="<?=DOMAIN;?>/css/<?=$xc['style'];?>" />
    
    <?if($xc['ya_map']==true):?>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?=YANDEX_API_KEY;?>&lang=ru_RU"></script>
    <?endif;?>

</head>


<body class="sticky-header">
    
<?if($xc['noMainTmp'] == false):?>

<!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  	<![endif]-->
    <?if(empty($_COOKIE['user_id']) && empty($xc['url']['user'])):?>
    <div data-id="jsPopupStatus" data-value="1" data-btn="jsGetQuiz" class="jsClickBtn quiz-fixed-btn show">
        <img src="<?=DOMAIN;?>/img/main/survey.svg" /> опрос
    </div>
    <?endif;?>

    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

    <div class="my_switcher d-none d-lg-block">
        <ul>
            <li title="Светлая тема">
                <a href="javascript:void(0)" class="setColor light" data-theme="light">
                    <i class="fal fa-lightbulb-on"></i>
                </a>
            </li>
            <li title="Темная тема">
                <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                    <i class="fas fa-moon"></i>
                </a>
            </li>
        </ul>

        <ul>
            <li title="Обычное зрение">
                <a href="#"class="jsChangeFontSize active" id="jsFontSizeNormal" data-id="normal">
                <i class="fas fa-eye-slash"></i>
                </a>
            </li>
            <li title="Для слабовидящих">
                <a href="#" class="jsChangeFontSize" id="jsFontSizeBig" data-id="big">
                <i class="fas fa-eye"></i>
                </a>
            </li>
        </ul>

    </div>

   <div id="main-wrapper" class="main-wrapper">
   <?=$xc['header'];?>
   <?=$xc['content']?>
   <?=$xc['footer'];?>
   </div>

<?else:?>
   
   <?=$xc['content']?>
   
<?endif;?>

<?require_once $_SERVER['DOCUMENT_ROOT'].'/modules/forms/tmp.inc.php';?>

<?=$xc['popup'];?>

<?=$xc['js'];?>
<?=$xc['body'];?>

</body>
</html>