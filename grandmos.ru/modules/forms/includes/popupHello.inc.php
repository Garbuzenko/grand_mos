<?if(MOBILE==false):?>
<section class="section section-padding-equal main-wrapper" style="padding: 20px 0 50px 0;">
<div class="container" style="text-align: center;">
<p>Вы являетесь участником проекта<br />"Московское долголетие"?</p>
<div class="row">
  <div class="col-md-6">
    <div class="axil-btn btn-fill-primary classSignedBtn jsClickBtn" data-id="jsFormTmp" data-value="signIn" data-btn="getPopup">Да</div>
  </div>
  
  <div class="col-md-6">
    <div class="axil-btn btn-fill-primary classSignedBtn jsClickBtn" data-id="jsFormTmp" data-value="askQuestion" data-btn="getPopup">Нет</div>
  </div>
</div>
</div>
</section>
<?else:?>
<section class="section section-padding-equal main-wrapper" style="height: 100vh;">
<div class="container" style="text-align: center;">
<p>Вы являетесь участником проекта<br />"Московское долголетие"?</p>
  <div class="col-md-12">
    <div class="axil-btn btn-fill-primary classSignedBtn mb-3 w-100 jsClickBtn" data-id="jsFormTmp" data-value="signIn" data-btn="getPopup">Да</div>
  </div>
  
  <div class="col-md-12">
    <div class="axil-btn btn-fill-primary classSignedBtn w-100 jsClickBtn" data-id="jsFormTmp" data-value="askQuestion" data-btn="getPopup">Нет</div>
  </div>
</div>
</section>
<?endif?>
<?if($xc['vk']==true):?>
<script>
$(document).ready(function(){
   $('.popupCloseDiv').addClass('hidden');
});
</script>
<?endif;?>