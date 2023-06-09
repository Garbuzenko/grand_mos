<?php defined('DOMAIN') or exit(header('Location: /'));?>
<?if($quest['number']==1):?><div id="jsAjaxLoadQuestions" class="main-wrapper"><?endif;?>
<section class="section">
  <div class="container w-100" style="height: <?=$containerHeight;?>; overflow-y: auto;">
  
  <div class="text-center mb-5">
  <!--<h5><?=$quest['number'];?> из <?=$quest['total'];?></h5>-->
  
  </div>
  
  
   <form method="post" action="" id="form_jsGetQuestion">
   <div class="text-center mb-4 quizQuestionDark">
     <?=$quest['question'];?>
     <?if(!empty($quest['description'])):?>
     <div class="searchDistrictDiv"><?=$quest['description'];?></div>
     <?endif;?>
   </div>
   
   <div>
  
   <?if($quest['type']=='input'):?>
   <input type="text" style="font-family: sans-serif;" value="<?if(!empty($answers)):?><?=$answers[0]['answer'];?><?endif;?>" class="form-control quizFormBorder<?if($quest['name']=='birthday'):?> dateMask<?endif;?>" name="answer@" />
   <?endif;?>
   
   <?if( ($quest['type']=='check' || $quest['type']=='radio') && !empty($quest['arr'])):?>
   <div class="row">
   <?$i=1; foreach($quest['arr'] as $key=>$val):?>
     <div class="col-md-<?=$quest['column'];?>">
       <div class="quizAnswerVarDiv mb-4 quizQuestionDark <?if(!empty($answersArr[$key])):?>quizAnswerVarDivActive<?endif;?> <?if($quest['type']=='check'):?>jsQuizCheck<?else:?>jsQuizRadio<?endif;?>" id="check<?=$i;?>" data-value='<?=$key;?>'><?=$val;?><?if(!empty($answersArr[$key])):?><div class="quizCheck">&#10004;</div><?endif;?></div>
     </div>
   <?$i++; endforeach;?>
   </div>
   
   <input type="hidden" name="answer" id="jsAnswer" value='<?if(!empty($answers)):?><?=$answers[0]['answer'];?><?endif;?>' />
   <?endif;?>
   
   </div>
   
   
   <input type="hidden" name="module" value="quiz" />
   <input type="hidden" name="component" value="" />
   <input type="hidden" name="number" value="<?=$nextNumber;?>" />
   <input type="hidden" name="quest_name" value="<?=$quest['name'];?>" />
   <input type="hidden" name="tg_id" value="<?=$tg_id;?>" />
   <input type="hidden" name="vk_id" value="<?=$vk_id;?>" />
   <input type="hidden" name="quiz_id" value="<?=$quiz_id;?>" />
   <input type="hidden" name="alert" value="" />
   <input type="hidden" name="ajaxLoadAnimation" value="jsAjaxLoadQuestions" />
  
   </form>
   </div>
   
   <div class="text-center" style="border-top: 1px solid #d6d4d4; padding-top: 10px;  margin: 20px 0 10px 0; <?if(MOBILE==false):?>height: 84px;<?else:?>height: 15vh;<?endif;?>">
     <?if($quest['number']>1):?>
     <!--<button name="prev" id="jsGetQuestion" class="send_form axil-btn btn-fill-primary quizBtnPrev quizBtn">Назад</button>-->
     <?endif;?>
     <button name="next" id="jsGetQuestion" class="jsShowBtn send_form axil-btn btn-fill-primary quizBtn <?if($quest['type']!='input' && $answers==false):?>hidden<?endif;?>">Далее</button>
   </div>
   
   <div class="progress" style="border-radius: 0;">
    <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: <?=$quest['percent'];?>%" aria-valuenow="<?=$quest['percent'];?>" aria-valuemin="0" aria-valuemax="100"></div>
   </div>
   </section>
<?if($quest['number']==1):?></div><?endif;?>
<?if(!empty($tg_id) || !empty($vk_id)):?>
<script>
$(document).ready(function(){
   $('.popupCloseDiv').addClass('hidden');
});
</script>
<?endif;?>