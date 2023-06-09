 <!--=====================================-->
        <!--=        Service Area Start         =-->
        <!--=====================================-->
            
            <!-- Данные -->
            <div class="section" id="section1">
                <div class="container">
                    <div class="section-heading heading-left row">
                    
                        <div class="col-md-6">
                        <h5 class="title mt-4">Данные</h5>

                        <form method="POST" action="" id="form_jsEditUserInfo" class="axil-contact-form accountSettingsForm">
                                    <div class="form-group">
                                        <label>День рождения</label>
                                        <input type="text" class="form-control quizFormBorder dateMask" name="birthday@" value="<?=$birthday;?>" placeholder="например 17.12.1970">
                                    </div>
                                    <div class="form-group">
                                        <label>Пол</label>
                                          <select class="form-control quizFormBorder" name="gender@">
                                          <option value="">Не выбран</option>
                                          <option value="1"<?if($xc['userInfo'][0]['gender_id']==1):?> selected=""<?endif;?>>Мужской</option>
                                          <option value="2"<?if($xc['userInfo'][0]['gender_id']==2):?> selected=""<?endif;?>>Женский</option>
                                    </select>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Адрес</label>
                                        <input type="text" class="form-control quizFormBorder" name="address@" value="<?=$xc['userInfo'][0]['address'];?>" placeholder="Например: Москва, ул. Нагатинская, д. 9">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Телефон</label>
                                        <input type="text" class="form-control quizFormBorder phoneMask" name="phone" value="<?=$phone;?>" placeholder="+7 (___) ___-____">
                                    </div>
                                    
                                    <!--
                                    <div class="form-group">
                                        <label>Фото</label>
                                        <input type="file" class="form-control quizFormBorder" name="avatar" placeholder="Загрузить аватар">
                                    </div>
                                    -->
                                    
                                    <input type="hidden" name="module" value="account" />
                                    <input type="hidden" name="component" value="settings" />
                                    <input type="hidden" name="ok" value="Ваши данные сохранены" />
                                    <input type="hidden" name="alert" value="" />
                                    
                                    <button id="jsEditUserInfo" class="send_form axil-btn btn-fill-primary quizBtn">Сохранить</button>
                                </form>
                         </div>
                         
                         <div class="col-md-6">
                           <h5 class="title mt-4">Уведомления</h5>
                           
                           <form method="POST" action="" id="form_jsEditNotify" class="axil-contact-form accountSettingsForm">
                           <div class="form-group">
                             <label>Присылать подборки мероприятий</label>
                             <select class="form-control quizFormBorder" name="notify" id="jsNotifySelect">
                             <option value="">Выбрать</option>
                             <option value="1"<?if( $xc['userInfo'][0]['notify']==1):?> selected=""<?endif;?>>1 раз в неделю</option>
                             <option value="2"<?if( $xc['userInfo'][0]['notify']==2):?> selected=""<?endif;?>>2 раза в неделю</option>
                           </select>
                           </div>
                           
                           <input type="hidden" name="module" value="account" />
                           <input type="hidden" name="component" value="settings" />
                           <input type="hidden" name="alert" value="" />
                           <button class="send_form hidden" id="jsEditNotify"></button>
                           </form>
                           
                           <div class="row">
                             <div class="col-md-12 mt-2">
                               <h6 class="title" style="margin-bottom: 10px;">Телеграм</h6>
                               
                               <a href="https://t.me/grandmos_bot?start=<?=$_COOKIE['user_id'];?>" target="_blank">
                                 <div class="axil-btn btn-fill-primary quizBtn accountSettingsSocBtn accountSettingsSizeBtn">
                                 <i class="fa fa-paper-plane"></i> Получать уведомления
                                 </div>
                               </a>
                             </div>
                             
                             <div class="col-md-12 mt-2">
                                
                                <h6 class="title" style="margin-bottom: 10px;">Вконтакте</h6>
                                
                                <a href="https://vk.com/app51666613#<?=$_COOKIE['user_id'];?>" target="_blank">
                                 <div class="axil-btn btn-fill-primary quizBtn accountSettingsSocBtn accountSettingsSizeBtn">
                                 <i class="fab fa-vk"></i> Получать уведомления
                                 </div>
                               </a>
                             
                             </div>
                             
                             <div class="col-md-12 mt-3">
                                <h6 class="title" style="margin-bottom: 10px;">Голосовой навык</h6>
                                <a href="https://dialogs.yandex.ru/store/skills/71feb33f-pensionery-moskvy" target="_blank"><img alt="Алиса это умеет" src="https://dialogs.s3.yandex.net/badges/v1-term1.svg"></a>                 
                             </div>
                           
                           </div>
                         
                         </div>
                    </div>  
                </div>
            </div>
          
            <div class="section" id="section3">
                <div class="container">
                    <div class="section-heading heading-left">
                        <h5 class="title">Мои группы</h5>
                        <h6 class="title">Здесь нужно добавить карту с пешими маршрутами до текущих групп</h6>
                    </div>  
                </div>
            </div>


