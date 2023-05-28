    <!--=====================================-->
        <!--=        Header Area Start       	=-->
        <!--=====================================-->
        <header class="header axil-header header-style-2">
            <div id="axil-sticky-placeholder"></div>
            <div class="axil-mainmenu">
                <div class="container-fluid">
                    <div class="header-navbar">
                        <div class="header-logo">
                           <a href="<?=DOMAIN;?>"><img class="light-version-logo" src="<?=DOMAIN;?>/template/assets/media/logo.svg" alt="logo"></a>
                            <a href="<?=DOMAIN;?>"><img class="dark-version-logo" src="<?=DOMAIN;?>/template/assets/media/logo-3.svg" alt="logo"></a>
                            <a href="<?=DOMAIN;?>"><img class="sticky-logo" src="<?=DOMAIN;?>/template/assets/media/logo-2.svg" alt="logo"></a>
                        </div>
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
                                    <!-- <li><a href="https://grandmos.ru">О проекте</a></li> -->
                                    <li>
                                        <a href="/search?online=1">Онлайн</a>
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
                                    
                                    <?if(empty($_COOKIE['user_id'])):?>
                                    <li class="mainProfileLi jsClickBtn" title="Войти" data-id="jsFormTmp" data-value="signIn" data-btn="getPopup">
                                      <div class="mainProfileRoundIconDiv"><i class="fa fa-user"></i></div>
                                    </li>
                                    <?else:?>
                                    
                                    <li class="menu-item-has-children">
                                        <div class="mainUserAvatar" style="margin-bottom: 3px;">
                                        <img src="<?=DOMAIN;?>/img/main/grandma.jpg" alt="" />
                                        </div>
                                        <ul class="axil-submenu">
                                            <li><a href="https://datalens.yandex/1mrl27a0i32er?user=<?=$_COOKIE['user_id'];?>">Аналитика</a></li>
                                            <li><a href="https://public.oprosso.sberbank.ru/p/cxidi4c8" target="_blank">Опрос</a></li>
                                            <li><a href="<?=DOMAIN.$_SERVER['PHP_SELF'];?>?exit=1">Выйти</a></li>
                                        </ul>
                                    </li>
                                    
                                    <?endif;?>
                                    <!-- <li><a href="/news">Новости</a></li> -->
                                    
                                    <!--
                                        <a href="https://login.mos.ru/sps/login/methods/password?bo=%2Fsps%2Foauth%2Fae%3Fscope%3Dprofile%2Bopenid%2Bcontacts%2Busr_grps%26response_type%3Dcode%26redirect_uri%3Dhttps%3A%2F%2Fwww.mos.ru%2Fapi%2Facs%2Fv1%2Flogin%2Fsatisfy%26client_id%3Dmos.ru">
                                            Личный кабинет
                                        </span>
                                        </a>
                                    </li> -->


                                </ul>
                            </nav>
                            <!-- End Mainmanu Nav -->
                        </div>
                        <div class="header-action">
                            <ul class="list-unstyled">
                                <?if(MOBILE==true):?>
                                <?if (empty($_COOKIE['user_id'])):?>
                                <li class="jsClickBtn d-lg-none d-block mainProfileIconMob" data-id="jsFormTmp" data-value="signIn" data-btn="getPopup" style="margin: 5px 7px 0 0; border-bottom: none;">
                                   <i class="fa fa-user"></i>
                                </li>&nbsp;&nbsp;
                                <?else:?>
                                <li style="margin: 6px 15px 0 0;">
                                  <a href="<?=DOMAIN.$_SERVER['PHP_SELF'];?>?exit=1">
                                  <div class="mainUserAvatar">
                                    <img src="<?=DOMAIN;?>/img/main/grandma.jpg" alt="" />
                                  </div>
                                  </a>
                                </li>
                                <?endif;?>
                                
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
                                        <li title="Light Mode">
                                            <a href="javascript:void(0)" class="setColor light" data-theme="light">
                                                <i class="fal fa-lightbulb-on"></i>
                                            </a>
                                        </li>
                                        <li title="Dark Mode">
                                            <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                                                <i class="fas fa-moon"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>