
//check loaded jQuery
if (typeof jQuery != "undefined"){
    $(function() {

        $('.btn-diswitch-on').click(function(e) {
            $(this).prev().show();
            $(this).hide();
        });
        
        var bdo = $('.btn-diswitch-off');
        bdo.click(function(e) {
            $(this).parent().parent().hide();
            $(this).parent().prev().val('');
            $(this).parent().parent().next().show();
        });
        for (var i = bdo.length - 1; i > 3; i--) {
            $('.btn-diswitch-off:eq(' + i + ')').click();
        }
    });
}
