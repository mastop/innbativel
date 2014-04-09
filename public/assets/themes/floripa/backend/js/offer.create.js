(function($){
    $(".chosen-select").chosen({disable_search_threshold: 5, allow_single_deselect: true, max_selected_options: 5, no_results_text: "Nenhum item encontrado com "});
    $(document).bind('dragover', function (e)
    {
        e.preventDefault();
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
    $('.dropzone').click(function(){
        $(this).parent().find('input.fileupload').click();
    });
})(jQuery);