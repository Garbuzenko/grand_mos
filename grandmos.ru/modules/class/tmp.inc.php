<section class="banner banner-style-2">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="banner-content" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="100">
                            <h1 class="title" style="font-size: <?if(MOBILE==false):?>40px<?else:?>20px<?endif;?>;">«<?=$title;?>»</h1>
                            <a href="#schedule" class="axil-btn btn-fill-white btn-large">Расписание</a>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="list-unstyled shape-group-18" heig>
                <li class="shape shape-1" data-sal="slide-left" data-sal-duration="1000" data-sal-delay="100"><img width="65%" src="https://static2.mos.ru/upload/motilda/version-2b88b93dca22dd879dfeb7e810a9354f/Frame_117_1.png" alt="Shape"></li>
                <!-- <li class="shape shape-2" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="100"><img width="50%" src="https://static2.mos.ru/upload/motilda/version-2b88b93dca22dd879dfeb7e810a9354f/Frame_117_1.png" alt="Shape"></li> -->
                <li class="shape shape-3" data-sal="zoom-in" data-sal-duration="500" data-sal-delay="600"><img src="/template/assets/media/others/bubble-16.png" alt="Shape"></li>
                <li class="shape shape-4" data-sal="zoom-in" data-sal-duration="500" data-sal-delay="600"><img src="/template/assets/media/others/bubble-15.png" alt="Shape"></li>
                <li class="shape shape-5" data-sal="zoom-in" data-sal-duration="500" data-sal-delay="600"><img src="/template/assets/media/others/bubble-14.png" alt="Shape"></li>
                <li class="shape shape-6" data-sal="zoom-in" data-sal-duration="500" data-sal-delay="600"><img src="/template/assets/media/others/bubble-16.png" alt="Shape"></li>
                <li class="shape shape-7" data-sal="slide-down" data-sal-duration="500" data-sal-delay="600"><img src="/template/assets/media/others/bubble-26.png" alt="Shape"></li>
          </ul>
</section>
        <!--=====================================-->
        <!--=       Расписание       =-->
        <!--=====================================-->
        <section class="section mt-5">
            <div class="container">
              <h5 class="title mb-1" style="padding: 0 20px;"><?=$title;?></h5>
            
              <div class="row" style="padding: 0 20px;">
                <div class="col-md-6" id="schedule">
                  <div class="mt-2"><?=$info[0]['d_level1'];?></div>
                  <div class="mt-2"><?=$info[0]['address'];?></div>
                  <?if(!empty($schedule)):?>
                  <h5 class="title mt-4 mb-2">Расписание</h5>
                  <div class="classScheduleMainDiv">
                  <?=$schedule;?>
                  </div>
                  <?endif;?>
                </div>
                
               <div class="col-md-6">
               
               <div id="map" class="w-100 mt-2" style="height: 500px;"></div>
               <?if($userInfo!=false):?>
               <script>
               function init() {
    
                // Задаём точки мультимаршрута.
                var pointB = [<?=$info[0]['lat'];?>,<?=$info[0]['lng'];?>];
    
    
                 var pointA = [<?=$userInfo[0]['lat'];?>,<?=$userInfo[0]['lng'];?>],
                 /**
                 * Создаем мультимаршрут.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/multiRouter.MultiRoute.xml
                */
                  multiRoute = new ymaps.multiRouter.MultiRoute({
                  referencePoints: [pointA,pointB],
                  params: {
                 //Тип маршрутизации - пешеходная маршрутизация.
                 routingMode: 'pedestrian'
                 }
                 }, {
                 // Автоматически устанавливать границы карты так, чтобы маршрут был виден целиком.
                // boundsAutoApply: true,
                // Внешний вид линии активного маршрута.
                routeActiveStrokeWidth: 8,
                routeActiveStrokeStyle: 'solid',
                routeActiveStrokeColor: "#008000"
                });
        
              // Подпишемся на событие готовности отображения маршрута.
              multiRoute.events.add('update', function() {
              // Получение списка построенных маршрутов.
             var routes = multiRoute.getRoutes();
             // Проход по коллекции маршрутов.
             // Для каждого маршрута подпишемся на события
            // 'mouseenter' и 'mouseleave'.
          routes.each(function(route) {
           route.events.add('mouseenter', function() {
           // Получение ссылки на активный маршрут.
           var active = multiRoute.getActiveRoute();
            route.options.set('strokeWidth', 10);
            // Активный маршрут будет перекрашиваться в черный цвет.
            if (active === route) {
                route.options.set('strokeColor', "#000000");
            } else {
                route.options.set('strokeColor', "#00ff00");
            }
        });
        route.events.add('mouseleave', function() {
            route.options.unset('strokeWidth');
            route.options.unset('strokeColor');
        });
    });  
});
    
    // Создаем карту с добавленной на нее кнопкой.
    var myMap = new ymaps.Map('map', {
        center: [<?=$info[0]['lat'];?>, <?=$info[0]['lng'];?>],
        zoom: 14,
        controls: ['zoomControl']
    }, {
    });
    

    
    // Добавляем мультимаршрут на карту.
    myMap.geoObjects.add(multiRoute);
}

ymaps.ready(init);


</script>
               <?else:?>
               <script type="text/javascript">
               ymaps.ready(init);		
               function init() {
	   
               var myMap = new ymaps.Map("map", {
		        center: [<?=$info[0]['lat'];?>, <?=$info[0]['lng'];?>],
		        zoom: 16
	           }, {
		       searchControlProvider: 'yandex#search'
	           });
	
               var myPlacemark= new ymaps.Placemark([<?=$info[0]['lat'];?>,<?=$info[0]['lng'];?>], {
	            iconCaption: '<?=$info[0]['address'];?>',
                hintContent: '<?=$info[0]['address'];?>'
               }, {
	             preset: 'islands#darkGreenIcon'
               });
        
              myMap.geoObjects.add(myPlacemark); 
              }
              </script>
              <?endif;?>
               </div>
              </div>
  
                 
                </div>
            <ul class="shape-group-7 list-unstyled">
                <li class="shape shape-1"><img src="/template/assets/media/others/circle-2.png" alt="circle"></li>
                <li class="shape shape-2"><img src="/template/assets/media/others/bubble-2.png" alt="Line"></li>
                <li class="shape shape-3"><img src="/template/assets/media/others/bubble-1.png" alt="Line"></li>
            </ul>
        </section>

        <!--=====================================-->
        <!--=       Рекомендации для Вас      =-->
        <!--=====================================-->
        <?if(!empty($similar)):?>
        <h3 class="title mb-1" style="<?if(MOBILE==false):?>padding: 0 50px;<?else:?>padding: 25px 0 0 20px;<?endif;?>">Похожие курсы</h3>
        <section class="section section-padding-3 mt-5" id="jsAjaxLoadSearchResult" style="z-index: 0;">
          <?=$similar;?>
        </section>
        <?endif;?>