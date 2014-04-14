if (typeof jQuery != "undefined") {
    $(function() {

        // Create string to check for mobile device User Agent String
        $.browser.device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));

        // If we detect that string, we will add the fixed class to our .navbar-header with jQuery
        if ($.browser.device) {
            $('.navbar-header').addClass('.navbar-fixed-to-top');
        }
    });
}
