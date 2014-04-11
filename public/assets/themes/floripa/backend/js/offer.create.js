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
})(jQuery);