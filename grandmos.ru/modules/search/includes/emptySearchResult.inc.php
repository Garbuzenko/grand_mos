<?php defined('DOMAIN') or exit(header('Location: /'));?>
<div class="container" id="jsIsSearchResultBlock">
<div class="axil-isotope-wrapper" >
<div class="row row-35 isotope-list" >
       <div class="col-md-4 project">
         <div class="project-grid">
                                <div class="thumbnail searchItemImgDiv">
                                   <img src="https://grandmos.ru/img/0_3_640_N(2).webp" alt="">
                                   <div class="searchFormTitleDiv" style="margin-top: 5%;">Не нашли курс?</div>
                                   <div class="searchFormSubTitleDiv" style="margin-top: <?if(MOBILE==true):?>15<?else:?>8<?endif;?>%;">Напишите нам какие курсы добавить</div>
                                </div>
                                <div class="content" style="<?if(MOBILE==false):?>height: 250px;<?endif;?>">
                                    
                                    <form method="POST" action="" class="axil-contact-form" id="form_jsEmptySearch" style="margin-top: -10px;">
                                      <div class="form-group mb--20">
                                       <textarea name="contact-message@" class="form-control textarea quizFormBorder" cols="40" rows="3"></textarea>
                                      </div>
                                      <div class="form-group">
                                      
                                        <input type="hidden" name="module" value="forms" />
                                        <input type="hidden" name="component" value="" />
                                        <input type="hidden" name="clearForm" value="1" />
                                        <input type="hidden" name="ok" value="Спасибо! Мы учтём ваши пожелания" />
                                        <button type="button" id="jsEmptySearch" class="send_form axil-btn btn-fill-primary btn-fluid btn-primary" name="submit-btn">
                                          Отправить
                                        </button>
                                      </div>
                                    </form>
                                    
                                </div>
         </div>
       </div>               
                      
</div>
</div>
</div>
<ul class="shape-group-7 list-unstyled">
 <li class="shape shape-1"><img src="<?=DOMAIN;?>/template/assets/media/others/circle-2.png" alt="circle"></li>
 <li class="shape shape-2"><img src="<?=DOMAIN;?>/template/assets/media/others/bubble-2.png" alt="Line"></li>
 <li class="shape shape-3"><img src="<?=DOMAIN;?>/template/assets/media/others/bubble-1.png" alt="Line"></li>
</ul>
