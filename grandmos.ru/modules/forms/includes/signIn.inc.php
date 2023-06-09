<section class="section main-wrapper" style="height:<?if(MOBILE==false):?>400px<?else:?>100vh<?endif;?>;">
  <div class="container" style="<?if($xc['module']!='login'):?>padding: 35px 20px 0 20px; height: 610px; overflow-y: auto;<?else:?>width: 50%; padding-top: 50px;<?endif;?>">
  
   <div class="contact-form-box shadow-box mb--30"<?if(MOBILE==true):?> style="margin-top: 25%;"<?endif;?>>
                            <h3 class="title text-center" style="font-size: 20px;">Авторизация</h3>
                            <form method="POST" action="" id="form_jsGetSing" class="axil-contact-form">
                                
                                <div class="form-group">
                                    <select class="form-control quizFormBorder" name="user_id@">
                                    <option value="">Пользователи</option>
                                    <option value="1">Тестовый пользователь</option>
                                    <?foreach($us as $k=>$v):?>
                                    <option value="<?=$v['user_id'];?>"><?=$v['gender'];?>, <?=lang_function($v['age'], 'год');?> (ID <?=$v['user_id']?>)</option>
                                    <?endforeach;?>
                                    </select>
                                </div>
                                
                                <!--
                                <div class="form-group">
                                    <input type="text" placeholder="Фамилия" class="form-control" name="last_name@" value="Блинова">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Имя" class="form-control" name="first_name@" value="Мария">
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" placeholder="Отчество" class="form-control" name="patronomic@" value="Ивановна">
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" placeholder="День рождения" value="10.09.1959" class="form-control dateMask" name="birthday@">
                                </div>
                                -->
                                
                                <input type="hidden" name="module" value="login" />
                                <input type="hidden" name="component" value="" />
                                <input type="hidden" name="url" value="<?=$url;?>" />
                                <?if(!empty($_COOKIE['vk_id']) || !empty($vk_id)):?>
                                <input type="hidden" name="opaco" value="1" />
                                <input type="hidden" name="vk_id" value="<?if(!empty($vk_id)):?><?=$vk_id;?><?endif;?>" />
                                <input type="hidden" name="ajaxLoad" value="jsAjaxLoadVkMainBlock" />
                                <input type="hidden" name="closeWindow" value="1" />
                                <?endif;?>
                                
                                <div class="form-group">
                                    <button id="jsGetSing" type="submit" class="send_form axil-btn btn-fill-primary btn-fluid btn-primary" name="submit-btn">
                                    Войти
                                    </button>
                                </div>
                                
                            </form>
                            
                                <div class="text-center mt-4 mainRegLink jsClickBtn" data-id="jsPopupStatus" data-value="1" data-btn="jsGetQuiz">Регистрация</div>
                        </div>
  
  </div>
</section>