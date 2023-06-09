<form method="post" action="" id="form_jsGetSearchText" class="hidden">
    <input type="hidden" name="module" value="search" />
    <input type="hidden" name="component" value="" />
    <input type="hidden" name="search" id="jsSearchStrText" value='' />
    <input type="hidden" name="noBlackout" value="1" />
    <input type="hidden" name="ajaxLoadNotEmpty" value="jsAjaxLoadSearchResult" />
    <input type="hidden" name="preloader" value="preloader" />
    <input type="hidden" name="page" value="1" />
    <input type="hidden" name="user_id" value="<?if(!empty($user_id)):?><?=$user_id;?><?endif;?>" />
    <input type="hidden" name="alert" value="" />
    <button id="jsGetSearchText" class="send_form"></button>
</form>
        
<form method="post" action="" id="form_getPopup" class="hidden">
    <input type="hidden" name="module" value="forms" />
    <input type="hidden" name="component" value="" />
    <input type="hidden" name="form" id="jsFormTmp" value="" />
    <input type="hidden" name="url" value="<?=$_SERVER['REQUEST_URI'];?>" />
    <input type="hidden" name="vk_id" value="<?if(!empty($vk_id)):?><?=$vk_id;?><?endif;?>" />
    <input type="hidden" name="alert" value="" />
    <button id="getPopup" class="send_form"></button>
</form>
        
<form method="post" action="" id="form_getLike" class="hidden">
    <input type="hidden" name="module" value="like" />
    <input type="hidden" name="component" value="" />
    <input type="hidden" name="group_index" id="jsGroupIndex" value="" />
    <input type="hidden" name="status" id="jsGroupStatus" value="" />
    <input type="hidden" name="component" value="" />
    <input type="hidden" name="noBlackout" value="1" />
    <input type="hidden" name="alert" value="" />
    <button id="getLike" class="send_form"></button>
</form>

<form method="post" action="" id="form_jsShowMoreGroupInfo" class="hidden">
  <input type="hidden" name="module" value="class" />
  <input type="hidden" name="component" value="" />
  <input type="hidden" name="group_index" id="jsGroupIndexTg" value="" />
  <input type="hidden" name="user_id" id="jsVkUserIdShowMore" value='<?if(!empty($user_id)):?><?=$user_id;?><?endif;?>' />
  <input type="hidden" name="alert" value="" />
  <button class="send_form" id="jsShowMoreGroupInfo"></button>
</form>

<form method="post" action="" id="form_jsSignedGroup" class="hidden">
  <input type="hidden" name="module" value="class" />
  <input type="hidden" name="component" value="" />
  <input type="hidden" name="group_index" id="jsSignedGroupIndex" value="" />
  <input type="hidden" name="callbackFunc" value="jsSignedCallback" />
  <input type="hidden" name="user_id" id="jsVkUserIdSignedGroup" value='<?if(!empty($user_id)):?><?=$user_id;?><?endif;?>' />
  <input type="hidden" name="opaco" value="1" />
  <input type="hidden" name="alert" value="" />
  <button class="send_form" id="jsSignedGroup"></button>
</form>

<form method="post" action="" id="form_jsGetQuiz" class="hidden">
  <input type="hidden" name="module" value="quiz" />
  <input type="hidden" name="component" value="" />
  <input type="hidden" name="number" value="1" />
  <input type="hidden" name="popupStatus" id="jsPopupStatus" value="1" />
  <input type="hidden" name="quest_name" value="birthday" />
  <input type="hidden" name="tg_id" value="<?if(!empty($tg_id)):?><?=$tg_id;?><?endif;?>" />
  <input type="hidden" name="vk_id" value="<?if(!empty($vk_id)):?><?=$vk_id;?><?endif;?>" />
  <input type="hidden" name="alert" value="" />
  <button type="button" name="next" id="jsGetQuiz" class="send_form"></button>
</form>