<section class="section">
  <div class="container" style="<?if($xc['module']!='login'):?>padding: 35px 20px 0 20px; height: 610px; overflow-y: auto;<?else:?>width: 50%; padding-top: 50px;<?endif;?>">
  
   <div class="contact-form-box shadow-box mb--30">
                            <h3 class="title text-center" style="font-size: 20px;">Регистрация</h3>
                            <form method="POST" action="" id="form_jsReg" class="axil-contact-form accountSettingsForm">
                                
                                <div class="form-group">
                                    <select class="form-control quizFormBorder" name="gender@">
                                    <option value="">Пол</option>
                                    <option value="1">Мужчина</option>
                                    <option value="2">Женщина</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                  <input type="text" class="form-control quizFormBorder dateMask" name="birthday@" value="" placeholder="День рождения">
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" placeholder="Адрес" class="form-control quizFormBorder" name="address@" value="">
                                </div>
                                
                                <div class="form-group">
                                   <input type="text" class="form-control quizFormBorder phoneMask" name="phone" value="" placeholder="+7 (___) ___-____">
                                </div>
                                
                                <input type="hidden" name="module" value="login" />
                                <input type="hidden" name="component" value="reg" />
                                <input type="hidden" name="alert" value="" />
                                <input type="hidden" name="url" value="<?=$_SERVER['REQUEST_URI'];?>" />
                                
                                <div class="form-group">
                                    <button id="jsReg" type="submit" class="send_form axil-btn btn-fill-primary btn-fluid btn-primary" name="submit-btn">
                                    Зарегистрироваться
                                    </button>
                                </div>
                                
                            </form>
                            
                        </div>
  
  </div>
</section>