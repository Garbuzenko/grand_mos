<?if($notify==0):?>
<div class="accountSettingsNotifyMainDivEmpty">
Уведомления отключены
</div>
<?endif;?>

<?if($notify>0):?>
<div class="accountSettingsNotifyMainDiv">
Для того что бы получать уведомления зайдите в наши приложения кликнув по кнопкам. Именно туда и будут приходить уведомления о 
новых курсах.

<div class="row">
  <div class="col-md-12 mt-4">
    <h6 class="title" style="margin-bottom: 10px;">Телеграм</h6>
                               
    <a href="https://t.me/grandmos_bot?start=<?=$_COOKIE['user_id'];?>" target="_blank">
    <div class="axil-btn btn-fill-primary quizBtn accountSettingsSocBtn accountSettingsSizeBtn">
    <i class="fa fa-paper-plane"></i> Получать уведомления
    </div>
    </a>
  </div>
                             
  <div class="col-md-12 mt-2">
    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?169"></script>
    <h6 class="title" style="margin-bottom: 10px;">Вконтакте</h6>
    <!-- VK Widget -->
    <div id="vk_allow_messages_from_community2"></div>
    <script type="text/javascript">
    VK.Widgets.AllowMessagesFromCommunity("vk_allow_messages_from_community2", {height: 30}, 218871488);
    </script>
                             
  </div>
                             
  <div class="col-md-12 mt-3">
  <h6 class="title" style="margin-bottom: 10px;">Голосовой навык</h6>
  <a href="https://dialogs.yandex.ru/store/skills/70e5886c-babushki-moskv?utm_source=site&amp;utm_medium=badge&amp;utm_campaign=v1&amp;utm_term=d1" target="_blank"><img alt="Алиса это умеет" src="https://dialogs.s3.yandex.net/badges/v1-term1.svg"></a>                 
  </div>
                           
  </div>
</div>
<?endif;?>