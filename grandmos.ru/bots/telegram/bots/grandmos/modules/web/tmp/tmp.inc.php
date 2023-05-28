<!DOCTYPE HTML>
<head>
    <meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- Core Style CSS -->
    <link rel="stylesheet" href="<?=WEBDIR;?>css/core-style.css">
    <link rel="stylesheet" href="<?=WEBDIR;?>style.css">
    <link rel="stylesheet" href="<?=DOMAIN;?><?=WEB_BOT?>/css/<?=$xc['style']?>">
    
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script src="<?=DOMAIN;?>/lib/js/jquery/jquery.min.js"></script>

    <script>
    
     $.get('/bots/telegram/bots/shop/modules/web/modules/main/index.php?'+window.Telegram.WebApp.initData+'&'+window.Telegram.WebApp.colorScheme, function(data) {
         if (data != '') {
           $('#content').html(data);
       }
     });    
      
    </script>
    
</head>

<body>
<?=$xc['popup'];?>
   
   <?=$xc['header'];?>
   
   <div id="content">
   </div>


<?=$xc['js'];?>

<!-- My scripts -->

<script>var shop_id = <?=SHOP_ID;?>;</script>
<script src="<?=DOMAIN;?><?=WEB_BOT?>/js/<?=$xc['scripts']?>"></script>

<?=$xc['body'];?>
</body>
</html>