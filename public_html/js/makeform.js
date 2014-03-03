
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
            if (!$('#sur-title').val()) err[0] = 'タイトルが設定されていません';
            var ava_item_num = 0;
            for (var i = 0; i < 10; i++) {
                if ($('#sur-item' + i).val()) ava_item_num++;
            }
            if (ava_item_num < 2) err[err.length] = '項目が少ないです';
            return err;
        }

        var list = document.getElementsByTagName("input");
        for(var i=0; i<list.length; i++){
            if(list[i].type == 'text' || list[i].type == 'password'){
                list[i].onkeypress = function (event){
                    return submitStop(event);
                };
            }
        }

    });
}

function submitStop(e){
    if (!e) var e = window.event;
 
    if(e.keyCode == 13)
        return false;
}

