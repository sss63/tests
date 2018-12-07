
$(document).ready(function(){
    // начальные данные для пейджера
    var data = {"offset": 0, "page_len": 5};

    // инициализация карты
    ymaps.ready(function() {maps = new ymaps.Map("map", {center: [0, 0], zoom: 3}); });

    // при вводе буквы
    $("#country").keyup(function(){
        data.country = $(this).val();
        data.offset = 0;
        $("#list").empty();
        getCities(data);
        $("#pager").css("display", "block");
    });    

    // при клике на ссылку "предыдущая страница"
    $("#prev").click(function() {
        data.offset = Math.max(data.offset - data.page_len,0);     
        getCities(data);
    });

    // при клике на ссылку "следующая страница"
    $("#next").click(function() {
        data.offset += data.page_len;
        getCities(data) 
    });

    // функция обращается к серверу за порцией данных о городах, 
    // изменяет сосотояние ссылок Prev Next, 
    // вызывает функ работы с картой setMarks
    getCities = function(sqldata) {
        $.getJSON("serv71.php", sqldata)
            .done(function(cities){
                console.log(cities);
                // если получен не пустой массив
                if (cities) {
                    $("#list").empty();
                    for(let i=0; i<data.page_len; i++) {    
                        // если мы не вышли за пределы массива
                        if (cities[i])
                            $("#list").append("<div key="+i+">"+cities[i]+"</div>");  
                    }

                    if (cities.length>data.page_len)
                        $("#next").css("display", "inline");
                    else
                        $("#next").css("display", "none");
                    if (data.offset)
                        $("#prev").css("display", "inline");
                    else
                        $("#prev").css("display", "none");
            
                    setMarks(cities, data.page_len);    
                }
            })
            .fail(function(){ console.log("error"); });           
    
    }

    // определение координат и работа с картой
    setMarks = function(c, pl) {

            //Делаем массив PlainObject, чтобы передать на сервер
            let plc = {"city": c};
    
            //Отправляем массив городов на сервер и получаем массив координат
            $.getJSON("geocoder.php", plc)
            .done(function(coords) {
 
                console.log(coords);
                
                // Рисуем метки на карте по координатам
                var Collection = new ymaps.GeoObjectCollection();
                for(let i=0; i<pl; i++){

                    let mark = new ymaps.Placemark(coords[i], {hintContent: c[i] }, {preset: "islands#circleDotIcon", iconColor: '#ff0000'});
                    Collection.add(mark);
                 }       
                 maps.geoObjects.removeAll();     
                 maps.geoObjects.add(Collection);
                 maps.setBounds(Collection.getBounds());
            })
            .fail(function(){
                console.log("Error");
            });
        //}
    }   
    

 
});





