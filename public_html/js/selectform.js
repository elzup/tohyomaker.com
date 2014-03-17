
//check loaded jQuery
if (typeof jQuery != "undefined"){
    $(function() {
//        $("#submit-main").removeClass('disabled');
        $(".btn-item").click(function() {
            $("#vote-value").val($(this).attr('name'));
            $(".btn-item").removeClass('active');
            $(".btn-item").removeClass('btn-warning');
            $(".btn-item").addClass('btn-default');
            $(this).addClass('btn-warning');
            $(this).removeClass('btn-default');
            $("#submit-main").removeClass('disabled');
        }); 
        $(".active.btn-item").click();

        $('#copy-btn').click = function() {

        }
        $('#share-text')
        .focus(function(){
            $(this).select();
        })
        .click(function(){
            $(this).select();
            return false;
        });

        // TODO: copy to clipboard in js
        //        $('#copy-btn').zclip({
        //            path:'../../js/ZeroClipboard.swf',
        //            copy: $(this).parent().prev().val(),
        //        });

    });
}
