<!--------------------------------------------------- Затемнение экрана --------------------------------------------------------->
<div id="opaco" class="hidden"></div>
<!------------------------------------------------------------------------------------------------------------------------------->

<!---------------------------------------------------- Всплывающее окно --------------------------------------------------------->
<div class="md-modal hidden" id="jsPopupWindow">
  <div class="md-content">
     <div class="popupCloseDiv jsClosePopupWindow">&times;</div>
     <div id="jsPopupWindowSubDiv">
     </div>
  </div>
</div>
<!------------------------------------------------------------------------------------------------------------------------------->

<!------------------------------------------------- Нижнее всплывающее окно ----------------------------------------------------->
<form method="post" action="" id="form_jsPopupBottomWindow" class="hidden">
  <input type="hidden" name="module" value="popup" />
  <input type="hidden" name="component" value="" />
  <input type="hidden" name="noBlackout" value="1" />
  <button name="showBottomWindow" class="send_form" id="jsPopupBottomWindow"></button>
</form>
<!------------------------------------------------------------------------------------------------------------------------------->