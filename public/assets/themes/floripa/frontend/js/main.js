;(function($){

    Innbativel = window.Innbativel || {};

    Innbativel.init = function(){};

    Innbativel.ready = function(){

    };

    Innbativel.load = function(){

        //$('#register').modal('show'); //excluir em produção

        $('#printEULA .control.print').click(function () {
            $('#log').prepend( "daora <br />");
            var printContents = document.getElementById('printEULA').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        });

        $('#header-scroll .navMenuCollapse2').collapse({ toggle:false });
        $('#nav .navMenuCollapse').collapse({ toggle:false });

        $('#header-scroll .navbar-toggle').on('click', function() {
            $('.navbar-collapse').css({ maxHeight: $(window).height() - $('.navbar-header').height() + "px" });
        });

        scrollEvents();

        $(window).scroll(scrollEvents);

        function scrollEvents() {

            var scrollHeight = $(window).scrollTop();

            if( scrollHeight > 130 ) {
                $('#header-scroll').removeClass('out');
                $('#nav .navMenuCollapse').collapse('hide');
            } else {
                $('#header-scroll').addClass('out');
                $('#header-scroll .navMenuCollapse2').collapse('hide');
            }

        }

    };

    $(window).on('ready', Innbativel.ready);
    $(window).on('load', Innbativel.load);

})(jQuery);