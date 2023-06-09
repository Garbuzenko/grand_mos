<section class="section section-padding-3 mt-2" id="jsAjaxLoadSearchResult" style="z-index: 0;">
  <?=$searchResult;?>
</section>
        
<form method="post" action="" id="form_jsShowGroupsList" class="hidden">
<input type="hidden" name="module" value="search" />
<input type="hidden" name="component" value="groups" />
<input type="hidden" name="groups" id="jsGroupsArr" value='' />
<button id="jsShowGroupsList" class="send_form"></button>
</form>