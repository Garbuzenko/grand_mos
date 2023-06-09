<script src="https://api-maps.yandex.ru/2.1/?apikey=<?=YANDEX_API_KEY;?>&lang=ru_RU"></script>
<?if(!empty($_COOKIE['vk_id'])):?>
<div class="axil-btn btn-fill-primary classVkCloseBtn jsVkClose">
<i class="fa fa-arrow-left" style="margin-right: 5px;"></i> Назад
</div>
<?endif;?>
<div style="height: 100vh; overflow-y: auto;">
        <!--=====================================-->
        <!--=       Расписание       =-->
        <!--=====================================-->
        <section class="section mt-5">
            <div class="container">
              <h5 class="title mb-1" style="padding: 0 20px;"><?=$title;?></h5>
            
              <div class="row" style="padding: 0 20px;">
                <div class="col-md-12" id="schedule">
                  <div class="mt-2"><?=$info[0]['d_level1'];?></div>
                  <div class="mt-2"><?=$info[0]['address'];?></div>
                  
                  <?if (!empty($signedArr)):?>
                  <h5 class="title mt-4 mb-2">Расписание</h5>
                  <div class="classScheduleMainDiv">
                    <?foreach($signedArr as $group_id=>$val):?>
                      <div class="classGroupIdDiv">Группа #<?=$group_id;?></div>
                      <?foreach($val as $k=>$v):?>
                        <?=$v;?>
                      <?endforeach;?>
                      <div id="jsSignedBlock<?=$group_id;?>">
                        <div class="axil-btn btn-fill-primary classSignedBtn jsClickBtn" data-id="jsSignedGroupIndex" data-value="<?=$group_id?>" data-btn="jsSignedGroup">
                          Записаться
                        </div>
                      </div>
                    <?endforeach;?>
                  </div>
                  <?endif;?>
                  
                </div>
                
               <div class="col-md-12">
               
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
        zoom: 10,
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
            
        </section>
</div>