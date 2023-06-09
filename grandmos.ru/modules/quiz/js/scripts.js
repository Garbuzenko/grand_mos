$('body').on('click', '.jsQuizRadio', function() {
  var t = $(this);
  
  $('.quizAnswerVarDiv').removeClass('quizAnswerVarDivActive');
  $('.quizCheck').remove();
  
  if (t.hasClass('quizAnswerVarDivActive') == false) {
     t.addClass('quizAnswerVarDivActive').append('<div class="quizCheck">&#10004;</div>');
     var value = t.attr('data-value');
     $('#jsAnswer').val(value);
     $('.jsShowBtn').css("display", "none").fadeIn(400);
  }
  
});

$('body').on('click', '.jsQuizCheck', function() {
  var t = $(this);
  var id = t.attr('id');
  var values = '';
  
  if (t.hasClass('quizAnswerVarDivActive') == false) {
     t.addClass('quizAnswerVarDivActive').append('<div class="quizCheck">&#10004;</div>');
  }
  
  else {
     $('#'+id).removeClass('quizAnswerVarDivActive').children('.quizCheck').remove();
  }
  
  $('.quizAnswerVarDivActive').each(function(i,value) {
    values += $(value).attr('data-value')+'|';
  });
  
  $('#jsAnswer').val(values);
  
  if (values != '') {
    $('.jsShowBtn').fadeIn(400);
  }
  
  else {
    $('.jsShowBtn').addClass('hidden').fadeOut(400);
  }
  
});