var maxpage = 1, 
    search_str,
    page = 1,
    list_len = 5;

$(document).ready(function(){
      
    $("button").click(function(){
        page = 1;
        search_str = $("#country").val();
        let paginator=0;
        let counter = 0;                                            console.log(search_str);
        $(".country[class*='"+search_str+"'").each(function() {
                if (counter%list_len == 0) { paginator++; }
                counter++;
                //$(".country").removeClass()
                $(this).addClass("page"+String(paginator));
            });
        maxpage = paginator;
        
        showpage();
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
    $(".country").css("display", "none");
    $(".country[class*='"+search_str+"'").filter(".page"+page).css("display", "block");
    let len = $(".country[class*='"+search_str+"'").length;
    if (len >= list_len) {
        $("#pager").css("display", "block"); 
    }
}
