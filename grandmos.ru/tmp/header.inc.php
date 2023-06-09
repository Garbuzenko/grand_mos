    <!--=====================================-->
        <!--=        Header Area Start       	=-->
        <!--=====================================-->
        <header class="header axil-header header-style-2">
            <div id="axil-sticky-placeholder"></div>
            <div class="axil-mainmenu">
                <div class="container-fluid">
                    <div class="header-navbar">
                    
                        <?if(MOBILE==true):?>
                          <div class="header-logo" style="margin-right: 40px;" id="jsHeaderLogo">
                            <a href="<?=DOMAIN;?>"><img class="light-version-logo" src="<?=DOMAIN;?>/template/assets/media/logo.svg" alt="logo"></a>
                            <a href="<?=DOMAIN;?>"><img class="dark-version-logo" src="<?=DOMAIN;?>/template/assets/media/logo-3.svg" alt="logo"></a>
                            <a href="<?=DOMAIN;?>"><img class="sticky-logo" src="<?=DOMAIN;?>/template/assets/media/logo-2.svg" alt="logo"></a>
                          </div>
                        <?endif;?>
                        
                        <div class="header-main-nav">
                            
                            <!-- Start Mainmanu Nav -->
                            <nav class="mainmenu-nav" id="mobilemenu-popup" style="z-index: 5000;">
                                
                                <div class="d-block d-lg-none">
                                    <div class="mobile-nav-header">
                                        <div class="mobile-nav-logo">
                                            <a href="index-1.html">
                                                <img class="light-mode" src="/template/assets/media/logo-2.svg" alt="Site Logo">
                                                <img class="dark-mode" src="/template/assets/media/logo-3.svg" alt="Site Logo">
                                            </a>
                                        </div>
                                        <button class="mobile-menu-close" data-bs-dismiss="offcanvas"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <ul class="mainmenu">
                                    <?if(MOBILE==true):?>
                                    <?if(!empty($_COOKIE['user_id'])):?>
                                    <li class="menu-item-has-children">
                                        <a href="javascript:void(0);">Личный кабинет</a>
                                        <ul class="axil-submenu">
                                            <li><a href="https://datalens.yandex/1mrl27a0i32er?user=<?=$_COOKIE['user_id'];?>&g=<?=$xc['userInfo'][0]['gender_id'];?>&a=<?=$xc['userInfo'][0]['age'];?>&tab=w1" target="_blank">Аналитика</a></li>
                                            <li><a href="<?=DOMAIN;?>/account/settings">Настройки</a></li>
                                            <li><a href="<?=DOMAIN;?>/account/my-groups">Мои группы</a></li>
                                            <li><a href="<?=DOMAIN.$_SERVER['PHP_SELF'];?>?exit=1">Выйти</a></li>
                                        </ul>
                                    </li>
                                    <?else:?>
                                    <li>
                                      <a href="#" class="jsClickBtn" data-id="jsFormTmp" data-value="isUserForm" data-btn="getPopup">Личный кабинет</a>
                                    </li>
                                    <?endif;?>
                                    <?endif;?>
                                     
                                     <?if(MOBILE==false):?>
                                     <div class="header-logo" style="margin-right: 40px;" id="jsHeaderLogo">
                                       <a href="<?=DOMAIN;?>"><img class="light-version-logo" src="<?=DOMAIN;?>/template/assets/media/logo.svg" alt="logo"></a>
                                       <a href="<?=DOMAIN;?>"><img class="dark-version-logo" src="<?=DOMAIN;?>/template/assets/media/logo-3.svg" alt="logo"></a>
                                       <a href="<?=DOMAIN;?>"><img class="sticky-logo" src="<?=DOMAIN;?>/template/assets/media/logo-2.svg" alt="logo"></a>
                                     </div>
                                     <?endif;?>
                                    
                                    <li class="menu-item-has-children">
                                        <a href="javascript:void(0);">Сервисы</a>
                                        <ul class="axil-submenu">
                                           <li><a href="https://dialogs.yandex.ru/store/skills/71feb33f-pensionery-moskvy" target="_blank">Алиса</a></li>
                                           <li><a href="https://t.me/grandmos_bot<?if(!empty($_COOKIE['user_id'])):?>?start=<?=$_COOKIE['user_id'];?><?endif;?>" target="_blank">Bot telegram</a></li>
                                           <li><a href="https://vk.com/app51666613<?if(!empty($_COOKIE['user_id'])):?>#<?=$_COOKIE['user_id']?><?endif;?>" target="_blank">Приложение VK</a></li>
                                           <li><a href="<?if(!empty($_COOKIE['user_id'])):?>https://datalens.yandex/1mrl27a0i32er?user=<?=$_COOKIE['user_id'];?>&g=<?=$xc['userInfo'][0]['gender_id'];?>&a=<?=$xc['userInfo'][0]['age'];?>&tab=w1<?else:?>https://datalens.yandex/1mrl27a0i32er?user=101412457&g=2&a=65&tab=w1<?endif;?>" target="_blank">Аналитика</a></li>
                                        </ul>
                                    </li>


                                    <?$level2 = db_query("SELECT distinct id_level2, level2 FROM dict WHERE id_level1=631 and group_count > 10 and online='Нет' ORDER BY group_count DESC");?>

                                    <li class="menu-item-has-children">
                                        <a href="javascript:void(0);">Образование</a>
                                        <ul class="axil-submenu">
                                        <?foreach($level2 as $val):?>
                                            <li><a href=<?="/search?id_level2=".$val['id_level2'];?>><?=$val['level2'];?></a></li>
                                        <?endforeach;?>
                                        </ul>
                                    </li>


                                    <?$level2 = db_query("SELECT distinct id_level2, level2 FROM dict WHERE id_level1=589 and group_count > 10 and online='Нет' ORDER BY group_count DESC");?>

                                <li class="menu-item-has-children">
                                    <a href="javascript:void(0);">Спорт</a>
                                    <ul class="axil-submenu">
                                    <?foreach($level2 as $val):?>
                                        <li><a href=<?="/search?id_level2=".$val['id_level2'];?>><?=$val['level2'];?></a></li>
                                    <?endforeach;?>
                                    </ul>
                                </li>
                                                                    
                                                                

                                                                

                                <?$level2 = db_query("SELECT distinct id_level2, level2 FROM dict WHERE (id_level1=608 or id_level1=627 or id_level1=629) and group_count > 10 and online='Нет' ORDER BY group_count DESC");?>

                                <li class="menu-item-has-children">
                                    <a href="javascript:void(0);">Творчество</a>
                                    <ul class="axil-submenu">
                                    <?foreach($level2 as $val):?>
                                        <li><a href=<?="/search?id_level2=".$val['id_level2'];?>><?=$val['level2'];?></a></li>
                                    <?endforeach;?>
                                    </ul>
                                </li>




                                <?$level3 = db_query("SELECT distinct dict_id, level3 FROM dict WHERE id_level1=625 and group_count > 10 and online='Нет' ORDER BY group_count DESC");?>

                                <li class="menu-item-has-children">
                                    <a href="javascript:void(0);">Танцы</a>
                                    <ul class="axil-submenu">
                                    <?foreach($level3 as $val):?>
                                        <li><a href=<?="/search?dict_id=".$val['dict_id'];?>><?=$val['level3'];?></a></li>
                                    <?endforeach;?>
                                    </ul>
                                </li>



                                <?//$level2 = db_query("SELECT distinct id_level2, level2 FROM dict WHERE id_level1=649 and group_count > 10 and online='Нет' ORDER BY group_count DESC");?>
                                <!--
                                <li class="menu-item-has-children">
                                    <a href="javascript:void(0);">Игры</a>
                                    <ul class="axil-submenu">
                                    <?foreach($level2 as $val):?>
                                        <li><a href=<?="/search?id_level2=".$val['id_level2'];?>><?=$val['level2'];?></a></li>
                                    <?endforeach;?>
                                    </ul>
                                </li>
                                -->
                                    <li class="menu-item-has-children">
                                        <a href="javascript:void(0);">Спецпроекты</a>
                                        <ul class="axil-submenu">
                                            <li><a href="/search?id_level1=701">Серебряный университет</a></li>
                                            <li><a href="/search?id_level1=1476">Интеллектуальный клуб</a></li>
                                            <li><a href="/search?id_level1=1478">Московский театрал</a></li>
                                            <li><a href="/search?id_level1=1731">Тренировки долголетия</a></li>
                                        </ul>
                                    </li>
                                    
                                    <?if (MOBILE==true):?>
                                    <li class="mt-2 mb-2" style="border-bottom: none;">
                                    <a href="https://dialogs.yandex.ru/store/skills/70e5886c-babushki-moskv?utm_source=site&utm_medium=badge&utm_campaign=v1&utm_term=d1" target="_blank"><img alt="Алиса это умеет" src="https://dialogs.s3.yandex.net/badges/v1-term1.svg"/></a>
                                    </li>
                                    <?endif;?>
                                    
                                    <?if(MOBILE==false):?>
                                    <?if(empty($_COOKIE['user_id'])):?>
                                    <li class="mainProfileLi jsClickBtn" title="Войти" data-id="jsFormTmp" data-value="isUserForm" data-btn="getPopup">
                                      <div id="jsCabinet" class="mainProfileRoundIconDiv"><i class="fa fa-user"></i></div>
                                    </li>
                                    <?else:?>
                                    
                                    <li class="menu-item-has-children">
                                        <div class="mainUserAvatar" style="margin-bottom: 3px;">
                                        <img src="<?=DOMAIN;?>/img/main/grandma.jpg" alt="" />
                                        </div>
                                        <ul class="axil-submenu">
                                            <li><a href="https://datalens.yandex/1mrl27a0i32er?user=<?=$_COOKIE['user_id'];?>&g=<?=$xc['userInfo'][0]['gender_id'];?>&a=<?=$xc['userInfo'][0]['age'];?>&tab=w1">Аналитика</a></li>
                                            <li><a href="<?=DOMAIN;?>/account/settings">Настройки</a></li>
                                            <li><a href="<?=DOMAIN;?>/account/my-groups">Мои группы</a></li>
                                            <li><a href="<?=DOMAIN.$_SERVER['PHP_SELF'];?>?exit=1">Выйти</a></li>
                                        </ul>
                                    </li>
                                    
                                    <?endif;?>
                                    <?endif;?>
                                    
                                </ul>
                            </nav>
                            <!-- End Mainmanu Nav -->
                        </div>
                        <div class="header-action">
                            <ul class="list-unstyled">
                                <?if(MOBILE==true):?>
                                <li class="sidemenu-btn d-lg-block d-none">
                                    <button class="btn-wrap btn-dark" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenuRight">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </li>
                                <li class="mobile-menu-btn sidemenu-btn d-lg-none d-block">
                                    <button class="btn-wrap btn-dark" data-bs-toggle="offcanvas" data-bs-target="#mobilemenu-popup">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </li>
                                <?endif;?>
                                <li class="my_switcher d-block d-lg-none">
                                    
                                    <ul>
                                        <li title="Светлый режем">
                                            <a href="javascript:void(0)" class="setColor light" data-theme="light">
                                                <i class="fal fa-lightbulb-on"></i>
                                            </a>
                                        </li>
                                        <li title="Темный режим">
                                            <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                                                <i class="fas fa-moon"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--
                                    <ul>
                                        <li title="Обычное зрение">
                                            <a href="javascript:void(0)" class="setColor light" data-theme="light">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </li>
                                        <li title="Для слабовидящих">
                                            <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                                                <i class="fas fa-eye-slash"></i>
                                            </a>
                                        </li>
                                    </ul> -->
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>