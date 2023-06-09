function jsVkLoadContent(html) {
   
   if (isJSON(html) != true) {
        return false;
    }
    
    var data = $.parseJSON(html);
    
    $('#jsAjaxLoadVkMainBlock').html(data['content']);
    $('#jsVkUserIdShowMore').val(data['user_id']);
    $('#jsVkUserIdSignedGroup').val(data['user_id']);
    
    if (data['first'] == 1) {
        $('#jsGetMessagePopup').click();
    }
    
    else {
         $('#opaco').fadeOut(550).addClass('hidden');
    }
}
