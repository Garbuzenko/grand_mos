$('body').on('click', '.jsToggleModule', function() {
    
        var t = $(this);
        var id = t.attr('data-id');
        var module = t.attr('data-module');
        var act = t.attr('data-action');
        var menu = t.attr('data-menu');
        
        var formData = new FormData();
        
        formData.append('action', 'ajax');
        formData.append('shop_id', shop_id);
        formData.append('act', act);
        formData.append('module', module);
        formData.append('id', id);
        
        $.ajax({
           url: "/bots/telegram/bots/shop/modules/web/index.php",
           type: "POST",
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function(html) {
              
              if (html != '') {
              
                $('#content').html(html);
                
                if (menu == 1) {
                    $(".classy-menu").removeClass("menu-on");
                    $(".navbarToggler").removeClass("active");
                }
                
              }  
                     
           }
        });
        
        return false;
});