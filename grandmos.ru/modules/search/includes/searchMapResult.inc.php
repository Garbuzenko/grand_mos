
<div class="container">
<div id="map" style="width: 100%; height: 600px;"></div>
</div>        

<script>

    ymaps.ready(function () {

        // создаем яндекс-карту с координатами центра Москвы
        var myMap = new ymaps.Map('map', {
            <?if(!empty($userLng)):?>
            center: [<?=$userLat;?>, <?=$userLng;?>],
            <?else:?>
            center: [55.75026, 37.6147],
            <?endif;?>
            zoom: 9,
            controls: ['zoomControl','fullscreenControl','geolocationControl']

        }, {
            searchControlProvider: 'yandex#search'
        }),
        
        
          // добавляем метки с координатами объектов инфраструктуры
          objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: false,
            clusterIconLayout: "default#pieChart"
          });
         
         
          var data = '<?=$json;?>';
         
          myMap.geoObjects.add(objectManager);
          
          objectManager.add(data);
        
          myMap.setBounds(objectManager.getBounds(), {
               checkZoomRange: true
          });
          
          <?if(!empty($userLng)):?>
         var myPlacemark= new ymaps.Placemark([<?=$userLat;?>,<?=$userLng;?>], {
                hintContent: 'Ваш адрес'
               }, {
	             preset: 'islands#redIcon'
               });
        
              myMap.geoObjects.add(myPlacemark);
        <?endif;?>
           
        /*
        // добавляем кнопки на карту
        buttons = {
            heatmap: new ymaps.control.Button({
                data: {
                    content: 'Тепловая карта',
                    image: '/modules/search/img/heatmap_icon.png'
                },
                options: {
                    selectOnClick: true,
                    maxWidth: 250,
                    size: 'large'
                }
            })

        };
        */
        
});


</script>