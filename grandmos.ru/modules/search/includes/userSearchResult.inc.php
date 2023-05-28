<?php defined('DOMAIN') or exit(header('Location: /'));?>
<div class="container">
<div class="axil-isotope-wrapper" >
<div class="row row-35 isotope-list" >
  <?foreach($searchResultArr[$page-1] as $distance=>$value):?>
  <div class="col-md-4 project">
    <div class="project-grid">
      <div class="thumbnail">
        <img src="<?=DOMAIN;?>/template/assets/media/project/project-1.png" alt="project">
      </div>
      <div class="content">
          <span class="subtitle mb-2" style="font-size: 16px;">
          <i class="fas fa-map-marker-alt"></i> <?=$address[ $distance ];?>
          </span>
          <span class="subtitle mb-2" style="font-size: 16px;">
          <?=$distance;?> м. от вас
          </span>
          <?if(MOBILE==false):?><div class="searchListLinkDiv"><?endif;?>
          <?foreach($value as $level_id=>$val):?>
          <div class="searchLinkDiv mb-2 jsClickBtn" data-btn="jsShowGroupsList" data-id="jsGroupsArr" data-value='<?=json_encode($groups[$distance][$level_id],true)?>'><?=$val['name'];?></div>
          <?endforeach;?> 
          <?if(MOBILE==false):?></div><?endif;?>                     
      </div>
    </div>
  </div>
  <?endforeach;?>
</div>
</div>
</div>
<ul class="shape-group-7 list-unstyled">
 <li class="shape shape-1"><img src="<?=DOMAIN;?>/template/assets/media/others/circle-2.png" alt="circle"></li>
 <li class="shape shape-2"><img src="<?=DOMAIN;?>/template/assets/media/others/bubble-2.png" alt="Line"></li>
 <li class="shape shape-3"><img src="<?=DOMAIN;?>/template/assets/media/others/bubble-1.png" alt="Line"></li>
</ul>

<form method="post" action="" id="form_jsAjaxAutoLoadUser" class="hidden">
  <input type="hidden" name="module" value="search" />
  <input type="hidden" name="component" value="" />
  <input type="hidden" name="page" value="<?=$page;?>" />
  <input type="hidden" name="user_id" value="<?=$user_id;?>" />
  <input type="hidden" name="noBlackout" value="1" />
  <input type="hidden" name="ajaxLoadAppend" value="jsAjaxLoadSearchResult" />
  <input type="hidden" name="removeElement" value="form_jsAjaxAutoLoadUser" />
  <button class="send_form" id="jsAjaxAutoLoadUser"></button>
</form>