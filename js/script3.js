var maxpage = 1;
var page = 1;
var list_len = 5;
$(document).ready(function(){
      
    $("#country").change(function(){
        $("#country option:selected").each(function(){
            var paginator=0;
            var counter = 0;
            $(".country"+$(this).val()).each(function() {
                if (counter%list_len == 0) { paginator++; }
                counter++;
                $(this).addClass("page"+String(paginator));
            });
            maxpage = paginator;
        
        showpage();
        
        
        });
    });

    $("#prev").click(function() {
        page = Math.max(page-1,1);     
        showpage(); 
    });
    $("#next").click(function() {
        page = Math.min(page+1,maxpage);     
        showpage();
    });



});

    

showpage = function(){
        $("#country option:selected").each(function(){

            $(".country").css("display", "none");
            $(".country"+$(this).val()).filter(".page"+page).css("display", "block");
            var len = $(".country"+$(this).val()).length;
            if (len >= list_len) {
                $("#pager").css("display", "block"); 
            }
        });
}
