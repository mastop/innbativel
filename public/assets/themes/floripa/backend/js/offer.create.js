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
    $('input.currency').maskMoney({
        thousands: '.',
        decimal:    ','
    }).maskMoney('mask');

    $(".select2").select2({allowClear: true});
    $("#offers_included").select2({
        maximumSelectionSize: 5,
        formatResult: formatGenre,
        formatSelection: selectIncluded,
        escapeMarkup: function(m) { return m; }
    });

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
    //$( "div#offerOptionsMain span" ).disableSelection();

    $('#offer_opt_add').click(function(){
        var div_clone = $('#offerOptionsMain div.offerOptions').last();
        //alert(div_clone.html());
        var div = div_clone.clone().insertAfter(div_clone);
        div.find('input[type="hidden"]').val('');
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
        $('div#offerOptionsMain div.offerOptions input.currency').maskMoney({
            thousands: '.',
            decimal:    ','
        });
    }
    // Para calcular o %OFF
    $('#offerOptionsMain').on('keyup', 'input.PriceWithDiscount,input.PriceOriginal', function(event) {
        var PriceOriginal = $(this).closest('div.offerOption').find('input.PriceOriginal').maskMoney('unmasked')[0];
        var PriceWithDiscount = $(this).closest('div.offerOption').find('input.PriceWithDiscount').maskMoney('unmasked')[0];
        var TotalDiscount = $(this).closest('div.offerOption').find('input.TotalDiscount');
        if(PriceOriginal > 0){
            var discount = (PriceOriginal - PriceWithDiscount) / PriceOriginal * 100;
                TotalDiscount.val(Math.round(discount));
        }
    });
    // Para reclamar se o repasse ao parceiro for maior que o valor com desconto
    $('#offerOptionsMain').on('blur', 'input.TotalTransfer', function(event) {
        var PriceWithDiscount = $(this).closest('div.offerOption').find('input.PriceWithDiscount').maskMoney('unmasked')[0];
        var TotalTransfer = $(this).maskMoney('unmasked')[0];
        if(TotalTransfer > PriceWithDiscount){
            alert('O repasse ao parceiro não pode ser maior que o preço com desconto!');
            $(this).val(0);
            $(this).focus();
            return false;
        }
    });
    // Função para ajudar a validar os campos vazios
    // Retorna true se for vazio, false se não for
    function isEmpty(field){
        var c = $('#'+field);
        var cVal = c.val().trim();
        if(c.attr('type') == 'radio'){
            cVal = $('input[name='+field+']:checked', '#formOffer').val();
            if(cVal === undefined){
                cVal = "";
            }
        }
        var t = c.closest('div.control-group').find('label:first').text();
        if(cVal == ''){
            c.focus();
            alert('O campo "'+t+'" é obrigatório');
            return true;
        }
        return false;
    }
    // Validação do envio da Oferta
    $( "#formOffer" ).submit(function( e ) {
        // Valida título
        if(isEmpty('title')){
            return false;
        }
        // Valida título curto
        if(isEmpty('short_title')){
            return false;
        }
        // Valida Destino
        if(isEmpty('destiny_id')){
            return false;
        }
        // Valida Empresa Parceira
        if(isEmpty('partner_id')){
            return false;
        }
        // Valida Início da Oferta
        if(isEmpty('starts_on')){
            return false;
        }
        // Valida Fim da Oferta
        if(isEmpty('ends_on')){
            return false;
        }
        // Valida Regras
        if(isEmpty('rules')){
            return false;
        }
        // Valida Categoria
        if(isEmpty('category_id')){
            return false;
        }
        // Valida Gênero 1
        if(isEmpty('genre_id')){
            return false;
        }
        // Valida a imagem principal da oferta
        if($('#cover_img').val() == ""){
            alert('Envie a imagem principal da oferta');
            $('html, body').animate({
                scrollTop: $("#OfferImagesLegend").offset().top
            }, 1000);
            return false;
        }
        // Valida Opções de Venda
        var optionEmpty = false;
        $('div#offerOptionsMain input.required').each(function(){
            if($(this).val() == ""){
                var optionNumber = $(this).closest('div.offerOption').find('span.offerOptionNumber').text();
                var optionTitle = $(this).closest('div.control-group').find('label:first').text();
                alert('Preencha o campo "'+optionTitle+'" da Opção de Venda '+optionNumber);
                $(this).focus();
                optionEmpty = true;
                return false;
            }
        });
        if(optionEmpty) return false;
        return true;
    });
    $("#genre_id, #genre2_id").select2({
        allowClear: true,
        formatResult: formatGenre,
        formatSelection: selectGenre,
        escapeMarkup: function(m) { return m; }
    });
    function formatGenre(data) {
        var originalOption = data.element;
        return "<span class='entypo entypo-"+$(originalOption).data('icon')+"' style='margin-top:10px'></span>" + data.text;
    }
    function selectGenre(data) {
        var originalOption = data.element;
        return "<span class='entypo entypo-"+$(originalOption).data('icon')+"' style='margin-top:13px'></span>" + data.text;
    }
    function selectIncluded(data) {
        var originalOption = data.element;
        return "<span class='entypo entypo-"+$(originalOption).data('icon')+"' style='margin-top:7px; font-size:1.9em;'></span>" + data.text;
    }
})(jQuery);