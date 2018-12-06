
$(document).ready(function(){
    var data = {"offset": 0, "page_len": 5};

    $.getJSON("serv.php",{})
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
        $.getJSON("serv.php", sqldata)
            .done(function(cities){
                console.log(cities);
                if (cities) {
                    $("#list").empty();
                    $.each(cities, function(index, cityname){ 
                    $("#list").append("<div key="+index+">"+cityname+"</div>");  
                    });
                } else {
                    data.offset -= data.page_len;
                }
            });           
    
    }

});





