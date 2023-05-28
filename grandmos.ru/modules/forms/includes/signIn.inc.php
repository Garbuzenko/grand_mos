<section class="section">
  <div class="container" style="padding: 35px 20px 0 20px; height: 610px; overflow-y: auto;">
  
   <div class="contact-form-box shadow-box mb--30">
                            <h3 class="title" style="font-size: 20px;">Авторизация</h3>
                            <form method="POST" action="" id="form_jsGetSing" class="axil-contact-form">
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
                                
                                <input type="hidden" name="module" value="login" />
                                <input type="hidden" name="component" value="" />
                                <input type="hidden" name="url" value="<?=$_SERVER['REQUEST_URI'];?>" />
                                
                                <div class="form-group">
                                    <button id="jsGetSing" type="submit" class="send_form axil-btn btn-fill-primary btn-fluid btn-primary" name="submit-btn">
                                    Войти
                                    </button>
                                </div>
                            </form>
                        </div>
  
  </div>
</section>