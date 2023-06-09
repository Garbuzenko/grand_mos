
<?if(!empty($searchResult)):?>
<section class="section section-padding-3 mt-2" style="z-index: 0;">
   <div class="container">
   <div class="col-md-12" style="padding: 0 3%;">
     <h5 class="title">Курсы, на которые вы записались</h5>
   </div>
   <?=$searchResult;?>
   </div>
   
   <?if(!empty($actualGroups)):?>
   <div class="col-md-12 mb-3" style="padding: 0 5%;">
     <h5 class="title">Эти же курсы на карте</h5>
     <div id="map" class="w-100" style="height: 600px;"></div>
   </div>
   
   
   
   <script>
function init() {
   
    // Задаём точки мультимаршрута.
    var pointB = [<?=$xc['userInfo'][0]['lat'];?>,<?=$xc['userInfo'][0]['lng'];?>];
    
    <?$i=1; foreach($actualGroups as $b):?>
        var pointA<?=$i?> = [<?=$b['lat'];?>,<?=$b['lng'];?>],
        /**
         * Создаем мультимаршрут.
         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/multiRouter.MultiRoute.xml
         */
        multiRoute<?=$i;?> = new ymaps.multiRouter.MultiRoute({
            referencePoints: [pointA<?=$i;?>,pointB],
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
            routeActiveStrokeColor: "<?=$colorsRoute[$i];?>"
        });
        
        // Подпишемся на событие готовности отображения маршрута.
multiRoute<?=$i;?>.events.add('update', function() {
    // Получение списка построенных маршрутов.
    var routes = multiRoute<?=$i;?>.getRoutes();
    // Проход по коллекции маршрутов.
    // Для каждого маршрута подпишемся на события
    // 'mouseenter' и 'mouseleave'.
    routes.each(function(route) {
        route.events.add('mouseenter', function() {
           // Получение ссылки на активный маршрут.
           var active = multiRoute<?=$i;?>.getActiveRoute();
            route.options.set('strokeWidth', 10);
            // Активный маршрут будет перекрашиваться в черный цвет.
            if (active === route) {
                route.options.set('strokeColor', "#000000");
            } else {
                route.options.set('strokeColor', "#FFFFFF");
            }
        });
        route.events.add('mouseleave', function() {
            route.options.unset('strokeWidth');
            route.options.unset('strokeColor');
        });
    });  
});
    <?$i++; endforeach;?>
    // Создаем карту с добавленной на нее кнопкой.
    var myMap = new ymaps.Map('map', {
        center: [<?=$xc['userInfo'][0]['lat'];?>, <?=$xc['userInfo'][0]['lng'];?>],
        zoom: 14,
        controls: ['zoomControl']
    }, {
    });
    
    // Добавляем мультимаршрут на карту.
    <?$i=1; foreach($actualGroups as $b):?>
    myMap.geoObjects.add(multiRoute<?=$i;?>);
    <?$i++; endforeach;?>
    
    // добавляем метки с координатами объектов инфраструктуры
    objectManager = new ymaps.ObjectManager({
      // Чтобы метки начали кластеризоваться, выставляем опцию.
      clusterize: true,
      // ObjectManager принимает те же опции, что и кластеризатор.
      gridSize: 32,
      clusterDisableClickZoom: false,
      clusterIconLayout: "default#pieChart"
    });
         
    myMap.geoObjects.add(objectManager);
}

ymaps.ready(init);


</script>
<?endif;?>
   
   
</section>
<?endif;?>

<?if(!empty($thisYearGroups)):?>
<section class="section section-padding-3 mt-2" style="z-index: 0;">
   <div class="container">
   <div class="col-md-12" style="padding: 0 3%;">
     <h5 class="title">Курсы, которые вы посещали в этом году</h5>
   </div>
   <?=$thisYearGroups;?>
   </div>
   
   <?if(!empty($lastGroups)):?>
   <div class="col-md-12 mb-3" style="padding: 0 5%;">
     <h5 class="title">Эти же курсы на карте</h5>
     <div id="map2" class="w-100" style="height: 600px;"></div>
   </div>
   
   
   
   <script>
function init() {
   
    // Задаём точки мультимаршрута.
    var pointB = [<?=$xc['userInfo'][0]['lat'];?>,<?=$xc['userInfo'][0]['lng'];?>];
    
    <?$i=1; foreach($lastGroups as $b):?>
        var pointA<?=$i?> = [<?=$b['lat'];?>,<?=$b['lng'];?>],
        /**
         * Создаем мультимаршрут.
         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/multiRouter.MultiRoute.xml
         */
        multiRoute<?=$i;?> = new ymaps.multiRouter.MultiRoute({
            referencePoints: [pointA<?=$i;?>,pointB],
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
            routeActiveStrokeColor: "<?=$colorsRoute[$i];?>"
        });
        
        // Подпишемся на событие готовности отображения маршрута.
multiRoute<?=$i;?>.events.add('update', function() {
    // Получение списка построенных маршрутов.
    var routes = multiRoute<?=$i;?>.getRoutes();
    // Проход по коллекции маршрутов.
    // Для каждого маршрута подпишемся на события
    // 'mouseenter' и 'mouseleave'.
    routes.each(function(route) {
        route.events.add('mouseenter', function() {
           // Получение ссылки на активный маршрут.
           var active = multiRoute<?=$i;?>.getActiveRoute();
            route.options.set('strokeWidth', 10);
            // Активный маршрут будет перекрашиваться в черный цвет.
            if (active === route) {
                route.options.set('strokeColor', "#000000");
            } else {
                route.options.set('strokeColor', "#FFFFFF");
            }
        });
        route.events.add('mouseleave', function() {
            route.options.unset('strokeWidth');
            route.options.unset('strokeColor');
        });
    });  
});
    <?$i++; endforeach;?>
    // Создаем карту с добавленной на нее кнопкой.
    var myMap = new ymaps.Map('map2', {
        center: [<?=$xc['userInfo'][0]['lat'];?>, <?=$xc['userInfo'][0]['lng'];?>],
        zoom: 14,
        controls: ['zoomControl']
    }, {
    });
    

    
    // Добавляем мультимаршрут на карту.
    <?$i=1; foreach($lastGroups as $b):?>
    myMap.geoObjects.add(multiRoute<?=$i;?>);
    <?$i++; endforeach;?>
    
    // добавляем метки с координатами объектов инфраструктуры
    objectManager = new ymaps.ObjectManager({
      // Чтобы метки начали кластеризоваться, выставляем опцию.
      clusterize: true,
      // ObjectManager принимает те же опции, что и кластеризатор.
      gridSize: 32,
      clusterDisableClickZoom: false,
      clusterIconLayout: "default#pieChart"
    });
         
    myMap.geoObjects.add(objectManager);
}

ymaps.ready(init);


</script>
<?endif;?>
</section>
<?endif;?>