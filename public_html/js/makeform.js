
//check loaded jQuery
if (typeof jQuery != "undefined"){
    $(function() {

        var bdo = $('.btn-diswitch-off');
        bdo.click(function(e) {
            $(this).parent().parent().hide();
            $(this).parent().prev().val('');
            $(this).parent().parent().next().show();
        });

        $("form").change( function () {
            var err = canSubmit();
            if (err.length == 0) {
                $('#submit-main').removeClass('disabled');
            } else {
                $('#submit-main').addClass('disabled');
            }
        });
        $("form").change();

        function canSubmit() {
            var err = new Array();
            if (!$('#sur-title').val()) err[0] = 'タイトルがありません';
//            if (!$('#sur-description').val()) err[1] = '説明がありません';
            var ava_item_num = 0;
            for (var i = 0; i < 10; i++) {
                if ($('#sur-item' + i).val()) ava_item_num++;
            }
            if (ava_item_num < 2) err[err.length] = '項目が少ないです';
            return err;
        }

        $('button[v=0_0]').click();

        var list = document.getElementsByTagName("input");
        for(var i=0; i<list.length; i++){
            if(list[i].type == 'text' || list[i].type == 'password'){
                list[i].onkeypress = function (event){
                    return submitStop(event);
                };
            }
        }

        // timign buttons
        $(".timing .btn").click(function() {
            // whenever a button is clicked, set the hidden helper
            $("#timing").val($(this).attr('v'));
            $(".timing .active").removeClass('active');
        }); 
    });
}

function submitStop(e){
    if (!e) var e = window.event;
 
    if(e.keyCode == 13)
        return false;
}


