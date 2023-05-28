<!--=====================================-->
        <!--=        Footer Area Start          =-->
        <!--=====================================-->
        <footer class="footer-area splash-footer">
            <div class="container">
                <div class="footer-bottom" data-sal="slide-up" data-sal-duration="500" data-sal-delay="100">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="footer-copyright">
                                <span class="copyright-text">© 2023 Хакатон Лидеры цифровой трансформации команда Old School</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <ul class="footer-social list-unstyled">
                                <li><a href="https://vk.com/mosdolgoletie"><i class="fab fa-vk"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UC2UoGhVb9VnALaBebns03oQ"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="https://t.me/s/mosdolgoletie"><i class="fab fa-telegram"></i></a></li>
                                <li><a href="https://t.me/s/mosdolgoletie"><i class="fab fa-whatsapp"></i></a></li>
                            </ul>
                        </div>
                        
                        <?if(MOBILE==false):?>
                        <div class="col-lg-3">
                          <a href="https://dialogs.yandex.ru/store/skills/70e5886c-babushki-moskv?utm_source=site&utm_medium=badge&utm_campaign=v1&utm_term=d1" target="_blank"><img alt="Алиса это умеет" src="https://dialogs.s3.yandex.net/badges/v1-term1.svg"/></a>
                        </div>
                        <?endif;?>
                    </div>
                </div>
            </div>
        </footer>


        <!--=====================================-->
        <!--=       Offcanvas Menu Area       	=-->
        <!--=====================================-->
        <div class="offcanvas offcanvas-end header-offcanvasmenu" tabindex="-1" id="offcanvasMenuRight">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="#" class="side-nav-search-form">
                    <div class="form-group">
                        <input type="text" class="search-field" name="search-field" placeholder="Search...">
                        <button class="side-nav-search-btn"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <div class="row ">
                    <div class="col-lg-5 col-xl-6">
                        <ul class="main-navigation list-unstyled">
                            <li><a href="index-1.html">Расписание</a></li>
                            <!-- <li><a href="index-2.html">Creative Agency</a></li>
                            <li><a href="index-3.html">Personal Portfolio</a></li>
                            <li><a href="index-4.html">Home Startup</a></li>
                            <li><a href="index-5.html">Corporate Agency</a></li> -->
                        </ul>
                    </div>
                    <div class="col-lg-7 col-xl-6">
                        <div class="contact-info-wrap">
                            <div class="contact-inner">
                                <!-- <address class="address">
                                    <span class="title">Contact Information</span>
                                    <p>Theodore Lowe, Ap #867-859 <br> Sit Rd, Azusa New York</p>
                                </address>
                                <address class="address">
                                    <span class="title">We're Available 24/7. Call Now.</span>
                                    <a class="tel" href="tel:8884562790"><i class="fas fa-phone"></i>(888)
                                        456-2790</a>
                                    <a class="tel" href="tel:12125553333"><i class="fas fa-fax"></i>(121)
                                        255-53333</a>
                                </address> -->
                            </div>
                            <div class="contact-inner">
                                <h5 class="title">Find us here</h5>
                                <div class="contact-social-share">
                                    <ul class="social-share list-unstyled">

                                    
                                <li><a href="https://vk.com/mosdolgoletie"><i class="fab fa-vk"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UC2UoGhVb9VnALaBebns03oQ"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="https://t.me/s/mosdolgoletie"><i class="fab fa-telegram"></i></a></li>
                                <li><a href="https://t.me/s/mosdolgoletie"><i class="fab fa-whatsapp"></i></a></li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <form method="post" action="" id="form_jsGetSearchText" class="hidden">
          <input type="hidden" name="module" value="search" />
          <input type="hidden" name="component" value="" />
          <input type="hidden" name="search" id="jsSearchStrText" value='' />
          <input type="hidden" name="noBlackout" value="1" />
          <input type="hidden" name="ajaxLoadNotEmpty" value="jsAjaxLoadSearchResult" />
          <input type="hidden" name="preloader" value="preloader" />
          <input type="hidden" name="page" value="1" />
          <input type="hidden" name="user_id" value="<?if(!empty($user_id)):?><?=$user_id;?><?endif;?>" />
          <input type="hidden" name="alert" value="" />
          <button id="jsGetSearchText" class="send_form"></button>
        </form>
        
        <form method="post" action="" id="form_getPopup" class="hidden">
          <input type="hidden" name="module" value="forms" />
          <input type="hidden" name="component" value="" />
          <input type="hidden" name="form" id="jsFormTmp" value="" />
          <input type="hidden" name="alert" value="" />
          <button id="getPopup" class="send_form"></button>
        </form>
        
        <form method="post" action="" id="form_getLike" class="hidden">
          <input type="hidden" name="module" value="like" />
          <input type="hidden" name="component" value="" />
          <input type="hidden" name="group_index" id="jsGroupIndex" value="" />
          <input type="hidden" name="status" id="jsGroupStatus" value="" />
          <input type="hidden" name="component" value="" />
          <input type="hidden" name="noBlackout" value="1" />
          <input type="hidden" name="alert" value="" />
          <button id="getLike" class="send_form"></button>
        </form>