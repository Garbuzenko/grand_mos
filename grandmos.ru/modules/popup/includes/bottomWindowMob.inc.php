<?php defined('DOMAIN') or exit(header('Location: /'));?>
<div class="col-md-12 popupTopBorder">
  
  <div class="col-md-12 mb-2" style="height: 40px; border: 1px solid red;">	
    <select class="selectpicker" name="format[]" title="Формат" id="type" multiple aria-label="size 3 select example">
      <option value="0">Офлайн</option>
      <option value="1">Онлайн</option>
    </select>
  </div>
             
  <div class="col-md-12 mb-2">	
    <select class="selectpicker" name="districts[]" title="Расположение" id="select-district lstFruits" multiple aria-label="size 3 select example" data-live-search="true">
    <?foreach($districts as $val):?>
      <option value="<?=$val['district_id'];?>"><?=$val['district'];?></option>
    <?endforeach;?>
    </select>
  </div>
             
  <div class="col-md-12 mb-2">	
    <select class="selectpicker" name="type[]" title="Вид" id="vid" multiple aria-label="size 3 select example">
      <option value="1">Для ума</option>
      <option value="2">Для тела</option>
      <option value="3">Для души</option>
     </select>
  </div>
             
  <div class="col-md-12 mb-2">	
    <select class="selectpicker" name="direction[]" title="Направление" id="select-district lstFruits" multiple aria-label="size 3 select example" data-live-search="true">
    <?foreach($direction as $val):?>
    <option value="<?=$val['level3_id'];?>"><?=$val['level3'];?></option>
    <?endforeach;?>
    </select>
  </div>
            
  <div class="col-md-12 mb-2">	
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