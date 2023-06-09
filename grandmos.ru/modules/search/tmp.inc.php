  <!--=====================================-->
        <!--= Project Area Start =----------->
        <!--===============================-->      
        <?if($xc['telegram'] == false):?>
        <?if(MOBILE==false):?>
        <form method="post" action="" id="form_searchGroups">
        <section class="section section-padding-1 mb-3">
          <div class="container">
             <div class="row d-flex justify-content-center align-items-center">
             
             <div class="banner-content sal-animate mb-1" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="100">
               <h1 class="title" style="font-size: 40px;"><?=$level2Title;?></h1>
             </div>
             
             <input type="hidden" name="module" value="search" />
             <input type="hidden" name="component" value="" />
             <input type="hidden" name="noBlackout" value="1" />
             <input type="hidden" name="ajaxLoad" value="jsAjaxLoadSearchResult" />
             <input type="hidden" name="preloader" value="jsMyPreloader" />
             <input type="hidden" name="map" id="jsMapSetting" value="0" />
             <input type="hidden" name="user_id" value="<?=$user_id;?>" />
             <input type="hidden" name="alert" value="" />
             <button class="send_form hidden" id="searchGroups"></button>
             
             <div class="col-md-2 mb-2">	
             <select class="selectpicker jsAjaxLoadClick" name="format[]" title="Формат" id="type" multiple aria-label="size 3 select example">
               <option value="0">Офлайн</option>
               <option value="1">Онлайн</option>
             </select>
			 </div>
             
             <div class="col-md-2 mb-2">	
             <select class="selectpicker jsAjaxLoadClick" name="districts[]" title="Расположение" id="select-district lstFruits" multiple aria-label="size 3 select example" data-live-search="true">
               <?foreach($districts as $val):?>
               <option value="<?=$val['district_id'];?>"><?=$val['district'];?></option>
               <?endforeach;?>
             </select>
			</div>
             
             <div class="col-md-2 mb-2">	
             <select class="selectpicker jsAjaxLoadClick" name="type[]" title="Вид" id="vid" multiple aria-label="size 3 select example">
               <option value="1">Для ума</option>
               <option value="2">Для тела</option>
               <option value="3">Для души</option>
             </select>
			 </div>
             
             <div class="col-md-4 mb-2">	
             <select class="selectpicker jsAjaxLoadClick" name="direction[]" title="Направление" id="select-district lstFruits" multiple aria-label="size 3 select example" data-live-search="true">
               <?foreach($direction as $val):?>
               <option value="<?=$val['level3_id'];?>"><?=$val['level3'];?></option>
               <?endforeach;?>
             </select>
			 </div>
            
             <div class="col-md-2 mb-2">	
             <select class="selectpicker" title="День недели" id="day" multiple aria-label="size 3 select example">
               <option value="1">Понедельник</option>
               <option value="2">Вторник</option>
               <option value="3">Среда</option>
               <option value="4">Четверг</option>
               <option value="5">Пятница</option>
               <option value="6">Суббота</option>
               <option value="7">Воскресенье</option>
             </select>
			 </div>
             
             </div>
          </div>
		</section>
        
        <section class="section section-padding-1 mb-3" style="z-index: 0;">
            <div class="container">
             <div class="row d-flex justify-content-center align-items-center">
               <div class="col-md-10 mb-2">
                        <div class="search">
                          <i class="fa fa-search"></i>
                          <input type="text" class="form-control" id="jsSearchStr" placeholder="Направление, район или улица. Например: Пение Измайлово">
                        </div>
               </div>
               
               <!--
               <div class="col-md-2 mb-2 searchMainBtn">
                 <button class="btn btn-primary w-100">Показать</button>
               </div>
               -->
               
               <div class="col-md-2">
                 <div class="row w-100" style="margin-right: 0; margin-left:0;">
                   <!--<div class="col-md-5 btn btn-switch-active mb-2 w-50">Список</div>-->
                   <div id="jsToggleMap" class="col-md-5 btn btn-switch-inactive mb-2 w-100 mainMapBtn"><i class="fas fa-map-marker-alt"></i> Карта</div>
                 </div>
               </div>
                      
             </div>
            </div>
        </section>
        <?endif;?>
        </form>
        
        <?if(MOBILE==true):?>
        <section class="section section-padding-1 mb-3">
            <div class="container">
             <div class="row d-flex justify-content-center align-items-center">
               <div class="col-9 mb-2" style="padding-right: 7px;">
                        <div class="searchMob">
                          <i class="fa fa-search"></i>
                          <input type="text" class="form-control" id="jsSearchStr" placeholder="Например: гимнастика">
                        </div>
                        
               </div>
               
               <div class="col-3 searchFilterBtnDiv mb-2" >
               <button class="btn btn-primary axil-btn btn-fill-primary quizBtn searchMobFilterBtn" id="jsShowBottomWindow">
                <i class="fa fa-filter"></i>
               </button>
               </div>
             </div>
             
            </div>
        </section>
        
         <div class="md-modal main-wrapper popupWindowsBottom hidden" id="jsBoottomPopupFormFilter" style="width: 100%; height: 80%; overflow: visible !important; z-index: 10000;">
          <div class="md-content">
          <div class="popupCloseDivBottom jsClosePopupWindowFilter mainMobCloseBtn" style="z-index: 200;">&times;</div>
          <div>
            <div class="col-md-12 popupTopBorder searchPopupFilterPadding">
  
   <div class="col-md-12 mt-2">
     <div class="row w-100" style="margin-right: 0; margin-left:0;">
        <div id="jsToggleMap" class="col-md-5 btn btn-switch-inactive mb-2 w-100 mainMapBtn"><i class="fas fa-map-marker-alt"></i> Карта</div>
     </div>
   </div>
  
  <form method="post" action="" id="form_searchGroups">
  
  <input type="hidden" name="module" value="search" />
  <input type="hidden" name="component" value="" />
  <input type="hidden" name="noBlackout" value="1" />
  <input type="hidden" name="ajaxLoad" value="jsAjaxLoadSearchResult" />
  <input type="hidden" name="map" id="jsMapSetting" value="0" />
  <input type="hidden" name="preloader" value="jsMyPreloader" />
  <input type="hidden" name="callbackFunc" value="jsMobSearchFunc" />
  <input type="hidden" name="user_id" value="<?=$user_id;?>" />
  <input type="hidden" name="alert" value="" />
  
  <div class="col-md-12 mb-3">	
    <select class="selectpicker" name="format[]" title="Формат" id="type" multiple aria-label="size 3 select example">
      <option value="0">Офлайн</option>
      <option value="1">Онлайн</option>
    </select>
  </div>
             
  <div class="col-md-12 mb-3">	
    <select class="selectpicker" name="districts[]" title="Расположение" id="select-district" multiple aria-label="size 3 select example" data-live-search="true">
    <?foreach($districts as $val):?>
      <option value="<?=$val['district_id'];?>"><?=$val['district'];?></option>
    <?endforeach;?>
    </select>
  </div>
             
  <div class="col-md-12 mb-3">	
    <select class="selectpicker" name="type[]" title="Вид" id="vid" multiple aria-label="size 3 select example">
      <option value="1">Для ума</option>
      <option value="2">Для тела</option>
      <option value="3">Для души</option>
     </select>
  </div>
             
  <div class="col-md-12 mb-3">	
    <select class="selectpicker jsCloseSelect" name="direction[]" title="Направление" id="direction" multiple aria-label="size 3 select example" data-live-search="true" data-close="true">
    <?foreach($direction as $val):?>
    <option value="<?=$val['level3_id'];?>"><?=$val['level3'];?></option>
    <?endforeach;?>
    </select>
  </div>
            
  <div class="col-md-12 mb-3">	
    <select class="selectpicker" title="День недели" id="day" multiple aria-label="size 3 select example">
    <option value="1">Понедельник</option>
    <option value="2">Вторник</option>
    <option value="3">Среда</option>
    <option value="4">Четверг</option>
    <option value="5">Пятница</option>
    <option value="6">Суббота</option>
    <option value="7">Воскресенье</option>
    </select>
   </div>
   
   <div class="col-md-12 mb-3">
     <button class="send_form btn btn-primary searchBtnMob mainMapBtn" id="searchGroups">Применить</button>
     <button class="btn btn-primary clearBtnMob mainMapBtn" id="jsClearFilter">Очистить</button>
   </div>
   </form>
   
   
</div>
          
          </div>
          </div>
         </div>
        
        <?endif;?>
        <?endif;?>
        <div id="jsMyPreloader" class="hidden searchPreloaderDiv">
          <img src="<?=DOMAIN;?>/img/main/preloader.gif" />
        </div>
        <section class="section section-padding-3 mt-2" id="jsAjaxLoadSearchResult" style="z-index: 0;">
        <?=$searchResult;?>
        </section>
        
<form method="post" action="" id="form_jsShowGroupsList" class="hidden">
<input type="hidden" name="module" value="search" />
<input type="hidden" name="component" value="groups" />
<input type="hidden" name="groups" id="jsGroupsArr" value='' />
<button id="jsShowGroupsList" class="send_form"></button>
</form>