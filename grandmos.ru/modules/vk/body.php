<script>
$(document).ready(function(){
   var user_id = document.location.hash;
   $('#jsVkUserId').val(user_id);
   $('#jsGetContent').click();
});
</script>

<?php require $_SERVER['DOCUMENT_ROOT'].'/modules/tg/includes/autoload.inc.php';?>