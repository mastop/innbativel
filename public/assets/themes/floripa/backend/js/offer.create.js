(function($){
    $('.redactor').redactor({
        lang: 'pt_br',
        linebreaks: true,
        observeLinks: true,
        convertVideoLinks: true,
        plugins: ['fontsize'],
        buttons: ['html', 'formatting',  'bold', 'italic', 'unorderedlist', 'orderedlist', 'image', 'video', 'file', 'table', 'link', 'alignment', 'horizontalrule']
    });
    $.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ]);
//    $('body').on('click', 'input.datepicker', function(event) {
//        $(this).datepicker({
//            showOn: 'focus',
//            numberOfMonths: 2,
//            showButtonPanel: false,
//            minDate: 0
//        }).focus();
//    });
    $('input.datepicker').datepicker({
        numberOfMonths: 2,
        showButtonPanel: false,
        minDate: 0
    });
    $(".select2").select2({allowClear: true});
    $("#offers_includes").select2({maximumSelectionSize: 5});

    $(document).bind('dragover', function (e)
    {
        var dropZone = $('.dropzone'),
            foundDropzone,
            timeout = window.dropZoneTimeout;
        if (!timeout)
        {
            dropZone.addClass('in');
        }
        else
        {
            clearTimeout(timeout);
        }
        var found = false,
            node = e.target;

        do{

            if ($(node).hasClass('dropzone'))
            {
                found = true;
                foundDropzone = $(node);
                break;
            }

            node = node.parentNode;

        }while (node != null);

        dropZone.removeClass('in hover');

        if (found)
        {
            foundDropzone.addClass('hover');
        }

        window.dropZoneTimeout = setTimeout(function ()
        {
            window.dropZoneTimeout = null;
            dropZone.removeClass('in hover');
        }, 100);
    });
    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });
    $('.dropzone').click(function(){
        $(this).parent().find('input[type=file]').click();
    });
    $('div.fileremove button').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        var parent = $(this).parent().parent().parent();
        // Remove o BG do Dropzone
        parent.find('div.dropzone').css("background-image", "none");
        // Exibe o Texto DropInfo
        parent.find('div.dropinfo').show();
        // Zera o valor do input Hidden
        parent.find('input.fileuploaded').val(null);
        // Se esconde
        $(this).parent().hide();
    });
    $( "div.multifiles" ).on( "click", "button", function() {
        $(this).parent().fadeOut('slow').remove();
    });
    $( "div.multifiles" ).sortable({
        placeholder: "dropPlaceHolder",
        connectWith: ".multifiles",
        revert: true
    });
    $( "div.multifiles, div.multifile, div.multifile button").disableSelection();

    $( "div#offerOptionsMain" ).sortable({
        stop: function( event, ui ) {
            resetOfferOptions();
        }
    });
    $( "div#offerOptionsMain" ).disableSelection();

    $('#offer_opt_add').click(function(){
        var div_clone = $('#offerOptionsMain div.offerOptions').last();
        //alert(div_clone.html());
        var div = div_clone.clone().insertAfter(div_clone);
        resetOfferOptions();
        $( "div#offerOptionsMain" ).sortable("refresh");
    });

    $( "div#offerOptionsMain" ).on( "click", "button", function() {
        var total = $('div#offerOptionsMain div.offerOptions').length;
        if(total > 1){
            $(this).parent().parent().fadeOut('slow').remove();
            resetOfferOptions();
        }
    });


    function resetOfferOptions(){
        $('div#offerOptionsMain div.offerOptions').each(function(i){
            var num = i + 1;
            $(this).find('span.offerOptionNumber').html(num);
            $(this).find('[id*="offer_options"]').each(function(){
                var newVal = $(this).attr('id').replace(/\[[0-9]+\]/g, '['+ i +']');
                $(this).attr('id', newVal);
                $(this).attr('name', newVal);
                $(this).removeClass('hasDatepicker');
            });
            $(this).find('label').each(function(){
                var newVal = $(this).attr('for').replace(/\[[0-9]+\]/g, '['+ i +']');
                $(this).attr('for', newVal);
            });
        });
        $('div#offerOptionsMain div.offerOptions input.datepicker').datepicker({
            numberOfMonths: 2,
            showButtonPanel: false,
            minDate: 0
        });
    }
})(jQuery);