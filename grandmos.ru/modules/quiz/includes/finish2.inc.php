<section class="section main-wrapper" style="padding: 25% 0;<?if(MOBILE==true):?>height: 100vh;<?endif;?>">
  <div class="container">
   <div class="text-center mt-3">
     <form method="post" action="" id="form_jsShowSelection">
       <input type="hidden" name="module" value="tg" />
       <input type="hidden" name="component" value="quiz" />
       <input type="hidden" name="user_id" value="<?=$time_user_id;?>" />
       <input type="hidden" name="closeWindow" value="1" />
       <input type="hidden" name="opaco" value="1" />
       <input type="hidden" name="ajaxLoad" value="jsSelectionLoad" />
       <input type="hidden" name="alert" value="" />
       <button id="jsShowSelection" class="send_form axil-btn btn-fill-primary quizBtn">
         Посмотреть подборку
       </button>
     </form>
   </div>
  </div>
</section>