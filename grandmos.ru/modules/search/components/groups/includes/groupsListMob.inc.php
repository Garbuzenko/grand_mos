<?php defined('DOMAIN') or exit(header('Location: /'));?>
<div class="col-md-12 popupTopBorder" style="padding: 15px; height: 550px; overflow-y: auto;">
  
<div class="searchGroupsPopupListTitleDiv mb-2">
 <h5 class="mb-1"><?=$list[0]['level3']?></h5>
 <?=$list[0]['d_level1']?>
</div>
<?foreach($list as $b):?>
  <?if(!empty($b['schedule_2'])):?>
  <?if (empty($b['schedule_2'])) {$b['schedule_2'] = $b['schedule_1'];}
  if (empty($b['schedule_2'])) {$b['schedule_2'] = $b['schedule_3'];}
  $b['schedule_2'] = str_replace(array('. ,','.,'),'|',$b['schedule_2']);
  $b['schedule_2'] = str_replace(array(';',','),'<br>',$b['schedule_2']);
  $b['schedule_2'] = str_replace('|',',',$b['schedule_2']);?>
  <div class="searchGroupsPopupListScheduleDiv mb-2">
  <?=$b['schedule_2'];?>
  </div>
  <?endif;?>
<?endforeach;?>
  
</div>