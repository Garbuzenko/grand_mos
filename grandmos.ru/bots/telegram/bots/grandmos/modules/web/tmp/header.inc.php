 <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between" style="border-top: 1px solid #ebebeb;">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav" style="height: 0; border: none;">
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <?if(!empty($xc['topMenu'])):?>
                    <div class="classynav">
                        <ul>
                        <?foreach($xc['topMenu'][0] as $category_id=>$category):?>
                            <li><a href="#"<?if(empty($xc['topMenu'][$category_id])):?> class="jsToggleModule" data-id="<?=$category_id;?>" data-module="category" data-action="show-category" data-menu="1"<?endif;?>><?=$category?></a>
                            <?if(!empty($xc['topMenu'][$category_id])):?>
                              <ul class="dropdown">
                              <?foreach($xc['topMenu'][$category_id] as $cat_id=>$cat):?>
                                <li><a href="#" class="jsToggleModule" data-id="<?=$cat_id;?>" data-module="category" data-action="show-category" data-menu="1"><?=$cat;?></a></li>
                              <?endforeach;?>
                              </ul>
                            <?endif;?>
                            </li>
                        <?endforeach;?>
                        </ul>
                    </div>
                    <?endif;?>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="d-flex clearfix justify-content-end" style="margin-top: -10px;">
                <!-- Search Area -->
                <div class="search-area" style="width: 190px;">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="#"><img src="<?=WEBDIR?>img/core-img/heart.svg" alt=""></a>
                </div>
                
                <!-- Cart Area -->
                <div class="cart-area">
                <!--
                  <div class="tmpEssenceCartBtnDiv">
                    <img src="<?=WEBDIR?>img/core-img/bag.svg" alt=""> <span>3</span>
                  </div>
                -->
                
                <a href="#" id="essenceCartBtn">
                    <img src="<?=WEBDIR?>img/core-img/bag.svg" alt=""> <span>3</span>
                </a>
                </div>
                
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler" style="border-left: 1px solid #EBEBEB; padding: 7px 0 0 15px;">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->