<?php defined('DOMAIN') or exit(header('Location: /'));?>
<div class="container">

<div class="axil-isotope-wrapper" >
<div class="row row-35 isotope-list" >
                      <?foreach($searchResultArr[$page-1] as $k=>$v):?>
                        <div class="col-md-4 project">
                            <div class="project-grid">
                                <div class="thumbnail searchItemImgDiv">
                                    <a href="<?=DOMAIN;?>/class?g=<?=$v['group_index'];?><?if(!empty($user_id)):?>&user=<?=$user_id;?><?endif;?>">
                                        <img src="<?=$v['img'];?>" alt="">
                                    </a>
                                    
                                    <div class="jsLikeGroup searchFavoriteDiv <?if(!empty($_COOKIE['user_id']) && !empty($userLikes[ $_COOKIE['user_id'] ][ $v['group_index'] ])):?>searchActiveClass<?else:?>searchNotLike<?endif;?>" data-id="<?=$v['group_index'];?>">
                                      <svg preserveAspectRatio="xMidYMid meet" width="26" height="23" viewBox="0 -1 26 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.9476 21.4473C6.65888 16.5508 2.96701 13.0385 1.87193 10.9102C0.318814 7.89182 1.06246 4.89043 2.37464 3.24923C3.71899 1.5678 5.30995 1.00388 7.02621 1.00388C9.39648 1.00388 11.3873 2.27103 12.9988 4.80533C14.6106 2.26844 16.6023 1 18.9738 1C20.69 1 22.281 1.56392 23.6254 3.24535C24.9375 4.88655 25.6812 7.88794 24.1281 10.9063C23.033 13.0346 19.3062 16.5482 12.9476 21.4473Z" stroke="" fill="" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"></path></svg>
                                    </div>
                                    <div class="searchOnline"><?if($v['online_id']==1):?>Online<?else:?><?=lang_function($v['distance'],'метр');?> от вас<?endif;?></div>
                                </div>
                                <div class="content">
                                    <?if(!empty($v['district']) && $v['online_id']==0):?>
                                    <span class="subtitle mb-2 searchDistrictDiv"><?=$v['district'];?></span>
                                    <?endif;?>
                                    <h4 class="title searchNameDiv"><a href="<?=DOMAIN;?>/class?g=<?=$v['group_index'];?><?if(!empty($user_id)):?>&user=<?=$user_id;?><?endif;?>"><?=$v['name'];?></a></h4>
                                    <?if(!empty($v['address']) && $v['online_id']==0):?>
                                    <span class="subtitle mb-2 searchAddressDiv"><i class="fas fa-map-marker-alt"></i> <?=str_replace_once('город ','г. ',$v['address']);?></span>
                                    <?endif?>
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