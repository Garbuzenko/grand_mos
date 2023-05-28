$('body').on('click', '#jsToggleMap', function() {
  var t = $(this);  
  
  if (t.hasClass('btn-switch-inactive')) {
     t.removeClass('btn-switch-inactive').addClass('btn-switch-active').html('<i class="fa fa-list"></i> Список');
     $('#jsMapSetting').val('1');
  }
  
  else {
    t.removeClass('btn-switch-active').addClass('btn-switch-inactive').html('<i class="fas fa-map-marker-alt"></i> Карта');
    $('#jsMapSetting').val('0');
  }
  
  $('#searchGroups').click();
});

$('body').on('change', '.jsAjaxLoadClick', function() {
   $('#searchGroups').click();
});

$('body').on('click', '#jsShowBottomWindow', function() {
    var h = $(document).outerHeight(true);
    $('#opaco').height(h).fadeIn(200).removeClass('hidden');
    $('#jsBoottomPopupFormFilter').slideDown("slow").removeClass('hidden'); 
});

$('body').on('click', '.jsClosePopupWindowFilter', function() {
    $('#jsBoottomPopupFormFilter').slideUp('slow').addClass('hidden'); 
    $('#opaco').fadeOut(300).addClass('hidden');
});

$('body').on('click', '.jsLikeGroup', function() {
    var t = $(this);
    var groupIndex = t.attr('data-id');
    var status = 'del';
    
    if (t.hasClass('searchNotLike')) {
        t.removeClass('searchNotLike').addClass('searchActiveClass');
        status = 'add';
    }
    
    else {
        t.removeClass('searchActiveClass').addClass('searchNotLike');
    }
    
    $('#jsGroupIndex').val(groupIndex);
    $('#jsGroupStatus').val(status);
    $('#getLike').click();
});

$('body').on('keyup', '#jsSearchStr', function() {
    
    var t = $(this);
    var obj = t.attr('id');
    var search = $('#' + obj).val();
    
    if ( search.length > 3 ) {
        $('#jsSearchStrText').val(search);
        $('#jsGetSearchText').click();
    }
});

function jsMobSearchFunc(data) {
   $('#jsBoottomPopupFormFilter').slideUp('slow').addClass('hidden'); 
   $('#opaco').fadeOut(300).addClass('hidden');
}