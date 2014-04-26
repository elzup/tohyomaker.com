
//check loaded jQuery
if (typeof jQuery != "undefined"){
    $(function() {
        //        $("#submit-main").removeClass('disabled');
        $(".btn-item").click(function() {
            if ($(this).hasClass('active')) {
                $("#vote-value").val('');
                $(".btn-item>i").removeClass('glyphicon glyphicon-ok');
                $("#submit-main").addClass('disabled');
            }
            else {
                $("#vote-value").val($(this).attr('name'));
                $(".btn-item").removeClass('active');
                $(".btn-item>i").removeClass('glyphicon glyphicon-ok');
                $(this).children('i').addClass('glyphicon glyphicon-ok');
                $("#submit-main").removeClass('disabled');
            }
        }); 

        $('.btn-item').parent().next().children('span').click(function() {
            //            console.log('clicked span');
            $(this).parent().prev().children('.btn-item').click();
        });

        //        $(".active.btn-item.btn-static:not").click();

        if ($('.btn.active') != null) {
            $("#submit-main").removeClass('disabled');
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
