<?php defined('DOMAIN') or exit(header('Location: /'));?>

<div id="jsAjaxLoadVkMainBlock"></div>

<form method="post" action="" id="form_jsGetContent" class="hidden">
<input type="hidden" name="module" value="vk" />
<input type="hidden" name="component" value="" />
<input type="hidden" name="user_id" id="jsVkUserId" value="" />
<input type="hidden" name="vk_id" value="<?=$query_params['vk_user_id'];?>" />
<input type="hidden" name="callbackFunc" value="jsVkLoadContent" />
<input type="hidden" name="alert" value="" />
<button class="send_form" id="jsGetContent"></button>
</form>

<form method="post" action="" id="form_jsGetMessagePopup" class="hidden">
<input type="hidden" name="module" value="vk" />
<input type="hidden" name="component" value="popup" />
<input type="hidden" name="form" id="jsVkPopupWindow" value="helloMessage" />
<input type="hidden" name="vk_id" value="<?=$query_params['vk_user_id'];?>" />
<button class="send_form" id="jsGetMessagePopup"></button>
</form>