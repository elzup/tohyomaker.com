
//check loaded jQuery
if (typeof jQuery != "undefined"){
    $(function() {
//        $("#submit-main").removeClass('disabled');
        $(".btn-item").click(function() {
            $("#vote-value").val($(this).attr('name'));
            $(".btn-item").removeClass('active');
            $('#' + $(this).id).addClass("active");
            $("#submit-main").removeClass('disabled');
        }); 
        $(".active.btn-item").click();
    });
}
