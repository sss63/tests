
$(document).ready(function(){
    var data = {"offset": 0, "page_len": 5};

    $.getJSON("serv51.php",{})
        .done(function(countries) {
            console.log(countries);
            $.each(countries, function(code, countryname){
                $("#country").append("<option value="+code+">"+countryname+"</option>"); 
            });    
  
    });

    $("#country").change(function(){
        $("#country option:selected").each(function(){
            data.country = $(this).text();
            data.offset = 0;
            $("#list").empty();
            getCities(data);
            $("#pager").css("display", "block");
        });    

    });

    $("#prev").click(function() {
        data.offset = Math.max(data.offset - data.page_len,0);     
        getCities(data);
    });

    $("#next").click(function() {
        data.offset += data.page_len;
        getCities(data) 
    });

 
    getCities = function(sqldata) {
        $.getJSON("serv51.php", sqldata)
            .done(function(cities){
                console.log(cities);
                if (cities) {
                    $("#list").empty();
//                    $.each(cities, function(index, cityname){ // здесь можно сделать for по кол-ву строк и пустые строки добавить для смещения prev|next 
//                      $("#list").append("<div key="+index+">"+cityname+"</div>");  // а еще искать на 1 больше чем выводить. изпользуя длину массива как индикатор того, надо ли показывать кнопку next 
//                    });
                    for(let i=0; i<data.page_len; i++) {    
                        if (cities[i])
                            $("#list").append("<div key="+i+">"+cities[i]+"</div>");  // а еще искать на 1 больше чем выводить. изпользуя длину массива как индикатор того, надо ли показывать кнопку next 
                    }

                    if (cities.length>data.page_len)
                        $("#next").css("display", "inline");
                    else
                        $("#next").css("display", "none");
                    if (data.offset)
                        $("#prev").css("display", "inline");
                    else
                        $("#prev").css("display", "none");
            

//                } else {
//                    data.offset -= data.page_len;
                }
            });           
    
    }

});





