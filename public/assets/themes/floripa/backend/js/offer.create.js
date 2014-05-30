(function($){
    $(".chosen-select").chosen({disable_search_threshold: 5, allow_single_deselect: true, max_selected_options: 5, no_results_text: "Nenhum item encontrado com "});
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
            //alert(ui.item.html());
        }
    });
    $( "div#offerOptionsMain" ).disableSelection();

    $('#offer_opt_add').click(function(){
        var div_clone = $('#offerOptionsMain div.offerOptions').last();
        //alert(div_clone.html());
        var div = div_clone.clone().insertAfter(div_clone);
        resetOfferOptions();
        //div.appendTo($('#offerOptionsMain'));
        $( "div#offerOptionsMain" ).sortable();
        $( "div#offerOptionsMain" ).disableSelection();
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
            });
            $(this).find('label').each(function(){
                var newVal = $(this).attr('for').replace(/\[[0-9]+\]/g, '['+ i +']');
                $(this).attr('for', newVal);
            });
            //console.log(i);
        });
    }
})(jQuery);