function jsSignedCallback(group_id) {
    $('#jsSignedBlock'+group_id).html('<strong>Отлично! Мы получили вашу заявку.</strong>');
}

$('body').on('click', '.jsVkClose', function() {
    $(this).parent().parent().parent().remove();
    $('#opaco').fadeOut(300).addClass('hidden');
    return false;
});