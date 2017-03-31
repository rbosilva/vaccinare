/*!
 * Start Bootstrap - SB Admin 2 v3.3.7+1 (http://startbootstrap.com/template-overviews/sb-admin-2)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
//Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }
        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    $('body').on('click', '.sidebar a[data-object], .quick-actions button, .breadcrumb a[data-object]', function (e) {
        e.preventDefault();
        var objeto = $(this).data('object'),
            ucObjeto = objeto.charAt(0).toUpperCase() + objeto.substr(1);
        $('.sidebar li').removeClass('active');
        $('.sidebar li a[data-object=' + objeto + ']').parent().addClass('active');
        requirejs(['assets/js/objects/' + ucObjeto], function () {
            window[ucObjeto].init();
        });
    }).on('click', '.cancelar', function (e) {
        e.preventDefault();
        $('.sidebar li.active a').click();
    });
});
