
//check loaded jQuery
if (typeof jQuery != "undefined"){
    $(function() {
        $(".btn-item").click(function() {
            $("#vote-value").val($(this).attr('name'));
            $(".btn-item").removeClass('active');
            $('#' + $(this).id).addClass("active");
        }); 
    });
}
