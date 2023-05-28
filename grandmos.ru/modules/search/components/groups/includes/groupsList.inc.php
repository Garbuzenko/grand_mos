<?php defined('DOMAIN') or exit(header('Location: /'));?>

<div class="searchGroupsPopupListDiv">
<div class="searchGroupsPopupListTitleDiv mb-1">
 <h5><?=$list[0]['level3']?></h5>
 <?=$list[0]['d_level1']?>
</div>
<?foreach($list as $b):?>
  <?if(!empty($b['schedule_2'])):?>
  <?if (empty($b['schedule_2'])) {$b['schedule_2'] = $b['schedule_1'];}
  if (empty($b['schedule_2'])) {$b['schedule_2'] = $b['schedule_3'];}
  $b['schedule_2'] = str_replace(array('. ,','.,'),'|',$b['schedule_2']);
  $b['schedule_2'] = str_replace(array(';',','),'<br>',$b['schedule_2']);
  $b['schedule_2'] = str_replace('|',',',$b['schedule_2']);?>
  <div class="searchGroupsPopupListScheduleDiv">
  <?=$b['schedule_2'];?>
  </div>
  <?endif;?>
<?endforeach;?>

</div>