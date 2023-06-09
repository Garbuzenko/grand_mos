<!-- Jquery Js -->
<script src="<?=DOMAIN;?>/template/assets/js/vendor/jquery-3.6.0.min.js"></script>
<!-- Style -->
   

<script src="<?=DOMAIN;?>/template/assets/js/vendor/bootstrap.min.js"></script>
 

<script src="<?=DOMAIN;?>/template/assets/js/vendor/isotope.pkgd.min.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/imagesloaded.pkgd.min.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/waypoints.min.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/counterup.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/slick.min.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/sal.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/jquery.magnific-popup.min.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/js.cookie.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/jquery.style.switcher.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/jquery.countdown.min.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/tilt.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/green-audio-player.min.js"></script>
<script src="<?=DOMAIN;?>/template/assets/js/vendor/jquery.nav.js"></script>

<!-- Site Scripts -->


<script src="<?=DOMAIN;?>/template/assets/js/app3.js"></script>

<script>var mobile = <?=$xc['mobile'];?>;</script>
<script src="<?=DOMAIN;?>/js/<?=$xc['scripts'];?>"></script>

<?if(empty($_COOKIE['user_id']) && !isset($_COOKIE['popup']) && $xc['telegram']==false && $xc['vk']==false && empty($vk_id)):?>
<script>
$(document).ready(function(){
 setTimeout(function () {
      $('#jsFormTmp').val('popupHello');
      $('#getPopup').click();
   }, 10000);
 });
</script>
<?endif;?>


<?if(!empty($_COOKIE['fontSize']) && $_COOKIE['fontSize']=='big'):?>
<script>
$(document).ready(function(){
    $("body").css({"zoom":"115%"}); 
    $('#jsHeaderLogo').addClass('hidden');
    $('#jsCabinet').css({"width":"25px","height":"25px","font-size":"15px","line-height":"25px"}); 
    $('#jsFontSizeNormal').removeClass('active');
    $('#jsFontSizeBig').addClass('active');
});
</script>
<?endif;?>