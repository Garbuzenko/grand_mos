<section class="section main-wrapper" style="height: 100vh;">
  <div class="container">
  
   <div class="contact-form-box shadow-box mb--30" style="margin-top: 30%;">
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
                                
                                <input type="hidden" name="module" value="tg" />
                                <input type="hidden" name="component" value="login" />
                                <input type="hidden" name="tg_id" value="<?=$tg_id;?>" />
                                <input type="hidden" name="ajaxLoad" value="jsTgLoginContent" />
                                <input type="hidden" name="opaco" value="1" />
                                
                                <div class="form-group">
                                    <button id="jsGetSing" type="submit" class="send_form axil-btn btn-fill-primary btn-fluid btn-primary" name="submit-btn">
                                    Войти
                                    </button>
                                </div>
                                
                            </form>
                            
                        </div>
  
  </div>
</section>