var maxpage = 1, 
search_str,
page = 0,
page_len = 5;

$(document).ready(function(){
     
    $("button").click(function(){
        page=0;
        search_str = $("#country").val();
        list_len = show_page(search_str, page);
        maxpage = Math.ceil(list_len/page_len);
            $("#pager").css("display", "block"); 
    }); 


    $("#prev").click(function() {
        page = Math.max(page-1,0);  
        show_page(search_str, page); 
    });
    $("#next").click(function() {
        page = Math.min(page+1,maxpage-1);     
        show_page(search_str, page);
    });
});
    
show_page = function(search_str, page) {
   
    let line_no = 0, vlen;
    $(".country").css("display", "none");  
    list_len = $(".country[class*='"+search_str+"'").each(function() {

        if (line_no >= page_len*page & line_no < page_len*(page+1) ) {
            $(this).css("display", "block");
        }
        line_no++;
    }).length;
    return list_len;
}
