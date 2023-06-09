<?php defined('DOMAIN') or exit(header('Location: /'));?>
<div class="container" id="jsIsSearchResultBlock">
<div class="axil-isotope-wrapper" >
<div class="row row-35 isotope-list" >
                      <?foreach($groups as $k=>$v):?>
                        <div class="col-md-4 project">
                            <div class="project-grid">
                                <div class="thumbnail searchItemImgDiv <?if($xc['telegram'] == true):?>jsClickBtn<?endif;?>" data-id="jsGroupIndexTg" data-value="<?=$v['group_index'];?>" data-btn="jsShowMoreGroupInfo">
                                    <?if($xc['telegram'] == false):?>
                                    <a href="<?=DOMAIN;?>/class?g=<?=$v['group_index'];?><?if(!empty($user_id)):?>&user=<?=$user_id;?><?endif;?>">
                                        <img src="<?=DOMAIN;?>/img/<?=$v['img'];?>" alt="<?=$v['level3'];?>">
                                    </a>
                                    <?else:?>
                                        <img src="<?=DOMAIN;?>/img/<?=$v['img'];?>" alt="<?=$v['level3'];?>">
                                    <?endif;?>
                                    
                                    <div class="jsLikeGroup searchFavoriteDiv <?if(!empty($_COOKIE['user_id']) && !empty($userLikes[ $_COOKIE['user_id'] ][ $v['group_index'] ])):?>searchActiveClass<?else:?>searchNotLike<?endif;?>" data-id="<?=$v['group_index'];?>">
                                      <svg preserveAspectRatio="xMidYMid meet" width="26" height="23" viewBox="0 -1 26 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.9476 21.4473C6.65888 16.5508 2.96701 13.0385 1.87193 10.9102C0.318814 7.89182 1.06246 4.89043 2.37464 3.24923C3.71899 1.5678 5.30995 1.00388 7.02621 1.00388C9.39648 1.00388 11.3873 2.27103 12.9988 4.80533C14.6106 2.26844 16.6023 1 18.9738 1C20.69 1 22.281 1.56392 23.6254 3.24535C24.9375 4.88655 25.6812 7.88794 24.1281 10.9063C23.033 13.0346 19.3062 16.5482 12.9476 21.4473Z" stroke="" fill="" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"></path></svg>
                                    </div>
                                    <?if($v['online_id']==1):?>
                                    <div class="searchOnline">ОНЛАЙН</div>
                                    <?endif;?>
                                    <?if(!empty($user_id) && $v['online_id']==0):?>
                                    <?if (!empty($distance[ $v['group_index'] ])):?>
                                    <div class="searchOnline">
                                      <?=$distance[ $v['group_index'] ];?> от вас
                                    </div>
                                    <?endif;?>
                                    <?endif;?>
                                </div>
                                <div class="content" style="<?if(MOBILE==false):?>height: 250px;<?endif;?>">
                                    <?if(!empty($v['district']) && $v['online_id']==0):?>
                                    <span class="subtitle mb-2 searchDistrictDiv"><?=str_replace('муниципальное образование',' ',$v['district']);?></span>
                                    <?endif;?>
                                    <h4 class="title searchNameDiv <?if($xc['telegram'] == true):?>jsClickBtn<?endif;?>" data-id="jsGroupIndexTg" data-value="<?=$v['group_index'];?>" data-btn="jsShowMoreGroupInfo">
                                      <?if($xc['telegram'] == false):?>
                                      <a href="<?=DOMAIN;?>/class?g=<?=$v['group_index'];?><?if(!empty($user_id)):?>&user=<?=$user_id;?><?endif;?>"><?=str_replace(array('ОНЛАЙН','онлайн'),' ',$v['level3']);?></a>
                                      <?else:?>
                                      <?=str_replace(array('ОНЛАЙН','онлайн'),' ',$v['level3']);?>
                                      <?endif;?>
                                    </h4>
                                    <?if(!empty($v['address']) && $v['online_id']==0):?>
                                    <span class="subtitle mb-2 searchAddressDiv"><i class="fas fa-map-marker-alt"></i> <?=str_replace_once('город ','г. ',$v['address']);?></span>
                                    <?endif?>
                                    <?if($v['online_id']==0 && !empty($v['friends'])):?>
                                    <div class="subtitle mb-2 searchAddressDiv searchUserFriendDiv"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-heart" viewBox="0 0 16 16">
  <path d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/>
</svg> <?=lang_function($v['friends'], 'друг');?></div>
                                    <?endif;?>
                                    <?if($v['online_id']==1):?>
                                    <div class="subtitle mb-2 searchAddressDiv" <?if(MOBILE==false):?>style="height: 95px; overflow-y: hidden;"<?endif;?>><?=$v['d_level1']?></div>
                                    <?endif;?>
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

<form method="post" action="" id="form_jsAjaxAutoLoad" class="hidden">
  <input type="hidden" name="module" value="search" />
  <input type="hidden" name="component" value="" />
  <input type="hidden" name="page" value="<?=$page;?>" />
  <input type="hidden" name="filters" value='<?=$filters;?>' />
  <input type="hidden" name="user_id" value='<?if(!empty($user_id)):?><?=$user_id;?><?endif;?>' />
  <input type="hidden" name="ajax_app" value='<?if($xc['telegram']==true):?>1<?endif;?>' />
  <input type="hidden" name="noBlackout" value="1" />
  <input type="hidden" name="ajaxLoadAppend" value="jsAjaxLoadSearchResult" />
  <input type="hidden" name="removeElement" value="form_jsAjaxAutoLoad" />
  <input type="hidden" name="alert" value="" />
  <button class="send_form" id="jsAjaxAutoLoad"></button>
</form>