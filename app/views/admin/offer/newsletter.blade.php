@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Gerar HTML da Newsletter</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.offer.create') }}" title="Criar Oferta" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
                <a href="{{ route('admin.offer.sort') }}" title="Ordenar Ofertas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
                <a href="{{ route('admin.offer.newsletter') }}" title="Gerar Newsletter" class="dropdown-toggle navbar-icon"><i class="icon-envelope"></i></a>
                <a href="{{ route('admin.offer.deleted') }}" title="Ofertas antigas" class="dropdown-toggle navbar-icon"><i class="icon-folder-open-alt"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
        {{ Former::horizontal_open()->id('formNewsletter') }}

        {{ Former::select('system', 'Sistema')
        ->addOption('Sendy', 'sendy')
        ->addOption('GetResponse', 'getresponse')
        }}

        {{HTML::ImageUpload('banner', 'Banner', false, false, '600x*')}}
        {{ Former::text('banner_link', 'Link do Banner')->class('span12') }}

        <div id="groups">
            <div class="group">
            {{ Former::legend('Grupo 1') }}
            {{ Former::text('group_title[]', 'Título do Grupo')->class('span12') }}
            {{ Former::text('group_link[]', 'Link do Botão')->class('span12') }}
            {{ Former::text('group_text[]', 'Texto do Botão')->class('span12') }}

            <div class="control-group">
                <label class="control-label">Ofertas</label>
                <div class="controls ofertas">
                    {{ Former::framework('Nude') }}
                    {{ Former::hidden('group_offers[]')
                    ->class('span12 group_offers') }}
                </div>
            </div>
            </div>
        </div>

        {{ Former::button('Adicionar Grupo')->id('group_add')->class('btn btn-large btn-block btn-success') }}

        {{ Former::framework('TwitterBootstrap') }}

        {{ Former::actions()
        ->primary_submit('Gerar HTML')
        ->inverse_reset('Limpar') }}

        {{ Former::close() }}
	</div>
</div>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/load-image.min.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/canvas-to-blob.min.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset_timed('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload-image.js') }}"></script>
<script type="text/javascript">
    // Ofertas Adicionais
    $("input.group_offers").select2({
        placeholder: "Procurar Ofertas",
        minimumInputLength: 1,
        multiple: true,
        ajax: {
            url: "{{route('ajax-offers-groups')}}",
            dataType: 'jsonp',
            data: function (term, page) {
                return {
                    q: term, // termo
                    page_limit: 20
                };
            },
            results: function (data, page) {
                return {results: data.offers};
            }
        },
        initSelection: function(element, callback) {
            // O input já tem valores que apontam para ids de OfferOptions
            // Esta função transforma o id em um objeto que o select2 pode renderizar
            // usando o formatSelection
            var id=$(element).val();
            if (id!=="") {
                $.ajax("{{route('ajax-offer-groups')}}", {
                    data: {
                        'id': id
                    },
                    dataType: "jsonp"
                }).done(function(data) { callback(data.offers); });
            }
        },
        formatResult: offerFormatResult,
        formatSelection: offerFormatResult,
        dropdownCssClass: "bigdrop",
        escapeMarkup: function (m) { return m; }
    });
    $("input.group_offers").on("change", function() { $(this).find('input.select2-input').html($(this).val()); $(this).select2("container").find("ul.select2-choices").sortable('refresh')});

    $("input.group_offers").select2("container").find("ul.select2-choices").sortable({
        containment: 'parent',
        start: function() { $("input.group_offers").select2("onSortStart"); },
        update: function() { $("input.group_offers").select2("onSortEnd"); }
    });
    function offerFormatResult(offer) {
        var markup = "<table class='offer-result'><tr>";
        var offerIMGURL = '//{{Configuration::get("s3url")}}/ofertas/'+offer.id+'/'+offer.cover_img;
        if (offer.cover_img !== undefined) {
            markup += "<td class='offer-image'><img src='" + offerIMGURL + "' style='max-width:100px;'/></td>";
        }else{
            markup += "<td class='offer-image'><img src='//{{Configuration::get("s3url")}}/logo-backend.png'/></td>";
        }
        markup += "<td class='offer-info'><div class='offer-title'><b>#"+offer.id+"</b> " + offer.destname+"</div>";
        if (offer.price_with_discount !== undefined) {
            markup += "<div class='offer-sub'>R$ "+offer.price_with_discount+" (" + offer.percent_off + "% OFF)</div>";
        }
        markup += "</td></tr></table>";
        return markup;
    }

    function offerFormatSelection(offer) {
        return "<b>#"+offer.id+"</b> " + offer.offer_title + " ( "+offer.destname+" ) - Opção: " + offer.optitle;
    }
    $('#group_add').click(function(){
        var div_clone = $('#groups div.group').last();
        //alert(div_clone.html());
        var div = div_clone.clone().insertAfter(div_clone);
        var grupoNum = $('#groups div.group').length;
        div.find('legend').html('Grupo '+grupoNum+' <button class="remove btn btn-danger">Remover</button>');
        var offersValue = div.find('div.ofertas input.group_offers').val();
        div.find('div.ofertas').html('<input class="span12 group_offers" type="hidden" name="group_offers[]" value="'+offersValue+'">');
        $("input.group_offers", div).select2({
            placeholder: "Procurar Ofertas",
            minimumInputLength: 1,
            multiple: true,
            ajax: {
                url: "{{route('ajax-offers-groups')}}",
                dataType: 'jsonp',
                data: function (term, page) {
                    return {
                        q: term, // termo
                        page_limit: 20
                    };
                },
                results: function (data, page) {
                    return {results: data.offers};
                }
            },
            initSelection: function(element, callback) {
                // O input já tem valores que apontam para ids de OfferOptions
                // Esta função transforma o id em um objeto que o select2 pode renderizar
                // usando o formatSelection
                var id=$(element).val();
                if (id!=="") {
                    $.ajax("{{route('ajax-offer-groups')}}", {
                        data: {
                            'id': id
                        },
                        dataType: "jsonp"
                    }).done(function(data) { callback(data.offers); });
                }
            },
            formatResult: offerFormatResult,
            formatSelection: offerFormatResult,
            dropdownCssClass: "bigdrop",
            escapeMarkup: function (m) { return m; }
        });
        $("input.group_offers", div).on("change", function() { $(this).find('input.select2-input').html($(this).val()); $(this).select2("container").find("ul.select2-choices").sortable('refresh')});

        $("input.group_offers", div).select2("container").find("ul.select2-choices").sortable({
            containment: 'parent',
            start: function() { $("input.group_offers").select2("onSortStart"); },
            update: function() { $("input.group_offers").select2("onSortEnd"); }
        });
    });
    $('#groups').on('click', 'button.remove', function(event) {
        event.preventDefault();
        $(this).parent().parent().fadeOut('slow').remove();
    });
    // Banners
    $(function () {
        var $progress = null;
        var $bar = null;
        var url = 'https://{{$s3bucket}}.s3.amazonaws.com/';
        var formWidth = $('div.dropzone').first().width();
        $('.fileupload').each(function(){
            $(this).fileupload({
                paramName: 'file',
                url: url,
                dropZone: $(this).parent().find('div.dropzone'),
                dataType: 'xml',
                previewMaxWidth: formWidth,
                previewMaxHeight: 150,
                //previewMinWidth: 200,
                //imageCrop: true,
                previewCrop: false,
                maxFileSize: 5000000,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                autoUpload: true,
                done: function (e, data) {
                    $progress.removeClass('active').hide();
                    var file = data.files[0];
                    var fileName = '{{$uid}}_'+$(this).next().attr('id')+'_'+file.name;
                    var fileURL = url + 'temp/'+fileName;
                    //console.log(data.files);
                    if($(this).attr('multiple')){
                        var multifiles = $(this).parent().find('div.multifiles');
                        var multifile = multifiles.find('div.multifile').first();
                        var multiclone = multifile.clone().sortable({connectWith: ".multifiles"}).insertAfter(multifile);
                        if(file.preview){
                            multiclone.css("background-image", "url("+file.preview.toDataURL("image/png")+")").css("background-position", "center center").css("background-repeat", "no-repeat");
                        }else{
                            multiclone.css("background-image", "url("+fileURL+")").css("background-position", "center center").css("background-repeat", "no-repeat");
                        }
                        multiclone.find('input.fileuploaded').val(fileName);
                        multiclone.fadeIn();
                        $(this).parent().find('div.dropinfo').show();
                    }else{
                        if(file.preview){
                            $(this).parent().find('div.dropzone').css("background-image", "url("+file.preview.toDataURL("image/png")+")").css("background-position", "center center").css("background-repeat", "no-repeat");
                        }else{
                            $(this).parent().find('div.dropzone').css("background-image", "url("+fileURL+")").css("background-position", "center center").css("background-repeat", "no-repeat");
                        }
                        $(this).parent().find('input.fileuploaded').val(fileName);
                        $(this).parent().find('div.fileremove').show();
                    }
                    $bar.css('width', '0%');
                },
                send: function (e, data) {
                    $progress = $(this).parent().find('div.progress');
                    $(this).parent().find('div.dropinfo').hide();
                    $progress.addClass('active').show();
                },
                progressall: function (e, data) {
                    $bar = $progress.find('div.bar');
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $bar.css('width', progress + '%');
                }
            }).on('fileuploadadd', function (e, data) {
                var filename = "temp/{{$uid}}_"+$(this).next().attr('id')+"_${filename}";
                $(this).parent().find('div.dropzone').css("background-image", "none");
                if(!(data.files[0].type.indexOf('image/') == 0)) {
                    alert('Formato de arquivo inválido! Envie apenas imagens.');
                    return false;
                }
                $(this).fileupload(
                    'option',
                    {
                        formData: {
                            key: filename,
                            acl: "public-read",
                            AWSAccessKeyId: "{{ $s3access }}",
                            policy: "{{ $policy }}",
                            signature: "{{ $signature }}",
                            'Content-type': data.files[0].type,
                            'Cache-Control':'max-age=315360000',
                            'Expires':'{{$expires}}',
                            success_action_status:200
                        },
                        sequentialUploads: true
                    }
                );
            });
        });
        // Caso imagens já estejam pré-selecionadas
        $('input.fileuploaded').each(function(){
            if($(this).val() != ''){
                // Single file
                var fileURL = url + 'temp/'+$(this).val();
                $(this).parent().find('div.dropzone').css("background-image", "url('"+fileURL+"')").css("background-position", "center center").css("background-repeat", "no-repeat");
                $(this).parent().find('div.fileremove').show();
                $(this).parent().find('div.dropinfo').hide();
            }else if($(this).parent().data('img') != undefined){
                // Multi files
                var fileURL = url + 'temp/'+$(this).parent().data('img');
                $(this).parent().css("background-image", "url('"+fileURL+"')").css("background-position", "center center").css("background-repeat", "no-repeat");
                $(this).val($(this).parent().data('img'));
                $(this).parent().fadeIn();
                $(this).parent().sortable({connectWith: ".multifiles"});
            }
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
    });
</script>
@stop
