$(document).ready(function(){
    $("#country").change(function(){
        $("#country option:selected").each(function(){
            $(".cities").css("display", "none");
            $("#country"+$(this).val()).css("display", "block");
        });
    });
});