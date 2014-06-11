@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        ]) }}

        {{ Former::legend('Dados da Oferta') }}

        {{ Former::text('title', 'Título')->class('span12') }}
        {{ Former::text('subtitle', 'Subtítulo')->class('span12') }}
        {{ Former::text('subsubtitle', 'Subtítulo 2')->class('span12') }}
        {{ Former::text('saveme_title', 'Título SaveMe')->class('span12') }}
        {{ Former::select('destiny_id', 'Destino')->fromQuery(Destiny::all(), 'name')->class('span12 select2') }}

        {{ Former::select('partner_id', 'Empresa Parceira')
        ->addOption(null)
        ->data_placeholder('Selecione uma Empresa Parceira')
        ->fromQuery(User::getAllByRole('parceiro'))
        ->class('span12 select2') }}

        {{ Former::select('ngo_id', 'ONG para Doação')
        ->data_placeholder('Selecione uma ONG')
        ->fromQuery(Ngo::orderBy('name')->get(), 'name')
        ->class('span12 select2')
        }}

        {{ Former::text('starts_on', 'Início da Oferta')->class('span12 datepicker') }}
        {{ Former::text('ends_on', 'Fim da Oferta')->class('span12 datepicker') }}


        {{ Former::textarea('features', 'Destaques')->rows(10)->columns(20)->class('span12 redactor')->placeholder('Insira os Destaques da Oferta') }}
        {{ Former::textarea('summary', 'Descrição Resumida')->rows(5)->columns(20)->class('span12') }}
        {{ Former::textarea('rules', 'Regras')->rows(10)->columns(20)->class('span12 redactor')->placeholder('Insira as Regras da Oferta') }}


        {{ Former::multiselect('offers_includes', 'Inclusos')
        ->fromQuery(Included::orderBy('title')->get())
        ->data_placeholder('Selecione os Itens Inclusos')
        ->class('span12') }}

        {{ Former::select('tell_us_id', 'Depoimento de Cliente')
        ->addOption(null)
        ->fromQuery(TellUs::orderBy('destiny')->get())
        ->data_placeholder('Selecione um Depoimento')
        ->class('span12 select2') }}


        {{ Former::stacked_radios('category_id', 'Categorias')->radios(Category::getAllArray()) }}

        {{ Former::checkbox('display_map', '')
        ->text('Exibir mapa na oferta')
        ->check() }}
        {{ Former::checkbox('is_available', '')
        ->text('Oferta será publicada')
        ->check() }}
        {{ Former::checkbox('is_product', '')
        ->text('É um <b>produto</b>?') }}


        {{ Former::legend('Gêneros') }}

        {{ Former::select('genre_id', 'Gênero 1')
        ->addOption(null)
        ->data_placeholder('Selecione um Gênero')
        ->fromQuery(Genre::orderBy('title')->get())
        ->class('span12 select2')
        }}

        {{ Former::select('genre2_id', 'Gênero 2')
        ->addOption(null)
        ->data_placeholder('Selecione um Gênero')
        ->fromQuery(Genre::orderBy('title')->get())
        ->class('span12 select2')
        }}


        {{ Former::legend('Fotos') }}


        {{-- Macro ImageUpload() está definida em app/start/global.php --}}

        {{HTML::ImageUpload('cover_img', 'Principal')}}
        {{HTML::ImageUpload('offer_old_img', 'Pré-Reservas')}}
        {{HTML::ImageUpload('newsletter_img', 'Newsletter')}}
        {{HTML::ImageUpload('saveme_img', 'Saveme')}}
        {{HTML::ImageUpload('offers_images', 'Demais Imagens', true)}}


        {{ Former::legend('Opções de Venda') }}

        <div id="offerOptionsMain">
            <div class="row-fluid offerOptions">
                <div class="span1">
                    &nbsp;
                </div>
                <div class="span10 offerOption">
                <span class="badge badge-info offerOptionNumber">1</span>
                {{ Former::text('offer_options[0][title]', 'Título')->class('span12') }}
                {{ Former::text('offer_options[0][subtitle]', 'Subtítulo')->class('span12') }}
                {{ Former::text('offer_options[0][price_original]', 'Preço Original')->class('span12 currency PriceOriginal')->prepend('R$') }}
                {{ Former::text('offer_options[0][price_with_discount]', 'Preço com Desconto')->class('span12 currency PriceWithDiscount')->prepend('R$') }}
                {{ Former::text('offer_options[0][percent_off]', 'Total do Desconto')->class('span4 TotalDiscount')->append('% OFF')->value('0') }}
                {{ Former::text('offer_options[0][transfer]', 'Repasse ao Parceiro')->class('span12 currency TotalTransfer')->prepend('R$') }}
                {{ Former::text('offer_options[0][min_qty]', 'Estoque Mínimo')->class('span4')->append('compradores')->value('0') }}
                {{ Former::text('offer_options[0][max_qty]', 'Estoque Máximo')->class('span4')->append('compradores')->value('0') }}
                {{ Former::text('offer_options[0][max_qty_per_buyer]', 'Máximo por Cliente')->class('span4')->append('compras')->value('0') }}
                {{ Former::text('offer_options[0][voucher_validity_start]', 'Início Val. Cupom')->class('span12 datepicker') }}
                {{ Former::text('offer_options[0][voucher_validity_end]', 'Fim Val. Cupom')->class('span12 datepicker') }}
                {{ Former::button('Remover esta Opção de Venda')->class('btn btn-large btn-block btn-danger btnOptRemove') }}
                </div>
                <div class="span1">
                    &nbsp;
                </div>
            </div>

        </div>

        {{ Former::button('Adicionar Opção de Venda')->id('offer_opt_add')->class('btn btn-large btn-block btn-success') }}

        {{ Former::legend('Ofertas Adicionais') }}

        <div class="row-fluid">
            <div class="span1">
                &nbsp;
            </div>
            <div class="span10">
                {{ Former::framework('Nude') }}
                {{ Former::hidden('offers_additional', '')
                ->id('offers_additional')
                ->class('span12') }}
            </div>
            <div class="span1">
                &nbsp;
            </div>
        </div>

        {{ Former::legend('Tags') }}

        <div class="row-fluid">
            <div class="span1">
                &nbsp;
            </div>
            <div class="span10">
                {{ Former::hidden('offers_tags', '')
                //->fromQuery(Tag::orderBy('title')->get(), 'title')
                ->data_placeholder('Digite as Tags da Oferta')
                ->id('offers_tags')
                ->class('span12') }}
            </div>
            <div class="span1">
                &nbsp;
            </div>
        </div>
        {{ Former::framework('TwitterBootstrap') }}
        <div class="row-fluid" style="margin-top: 25px;">
            <div class="span6">
                {{ Former::legend('Grupos') }}
                {{ Former::checkboxes('offers_groups', '')->checkboxes(Group::getAllArray()) }}
            </div>
            <div class="span6">
                {{ Former::legend('Feriados') }}
                {{ Former::checkboxes('offers_holidays', '')->checkboxes(Holiday::getAllArray()) }}
            </div>
        </div>

        {{ Former::legend('Saveme') }}

        <div class="control-group">
            <label for="saveme_sudeste" class="control-label"><input type="checkbox" name="saveme_sudeste_chk" id="saveme_sudeste_chk" checked> Sudeste</label>
            <div class="controls">
                <input class="span12" id="saveme_sudeste" type="text" name="saveme_sudeste" value="2">
            </div>
        </div>
        <div class="control-group">
            <label for="saveme_sul" class="control-label"><input type="checkbox" name="saveme_sul_chk" id="saveme_sul_chk" checked> Sul</label>
            <div class="controls">
                <input class="span12" id="saveme_sul" type="text" name="saveme_sul" value="2">
            </div>
        </div>
        <div class="control-group">
            <label for="saveme_nordeste" class="control-label"><input type="checkbox" name="saveme_nordeste_chk" id="saveme_nordeste_chk" checked> Nordeste</label>
            <div class="controls">
                <input class="span12" id="saveme_nordeste" type="text" name="saveme_nordeste" value="2">
            </div>
        </div>
        <div class="control-group">
            <label for="saveme_norte" class="control-label"><input type="checkbox" name="saveme_norte_chk" id="saveme_norte_chk" checked> Norte</label>
            <div class="controls">
                <input class="span12" id="saveme_norte" type="text" name="saveme_norte" value="2">
            </div>
        </div>
        <div class="control-group">
            <label for="saveme_centrooeste" class="control-label"><input type="checkbox" name="saveme_centrooeste_chk" id="saveme_centrooeste_chk" checked> Centro-Oeste</label>
            <div class="controls">
                <input class="span12" id="saveme_centrooeste" type="text" name="saveme_centrooeste" value="2">
            </div>
        </div>
        <div class="clearfix"></div>
        @foreach (Saveme::orderBy('title')->get() as $saveme)
        <div class="control-group">
            <div class="controls">
                <input type="checkbox" name="offers_saveme[]" id="offers_saveme[]" value="{{$saveme->id}}" checked> <input class="input-small" id="offers_saveme{{$saveme->id}}" type="text" name="offers_saveme{{$saveme->id}}" value="2"> {{$saveme->title}}
            </div>
        </div>
        @endforeach

        {{ Former::hidden('is_active', '')->value(1) }}



        <br>
        <div id="files" class="files"></div>



        {{ Former::actions()
          ->primary_submit('Criar Oferta')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}


        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/load-image.min.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/canvas-to-blob.min.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.iframe-transport.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload-process.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/plugins/file-upload/js/jquery.fileupload-image.js') }}"></script>
        <script src="{{ asset('assets/themes/floripa/backend/js/offer.create.js') }}"></script>
        <script>
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
                        imageMaxWidth: 800,
                        //disableImageResize: false,
                        imageMaxHeight: 600,
                        previewMaxWidth: formWidth,
                        previewMaxHeight: 150,
                        //previewMinWidth: 200,
                        //imageCrop: true,
                        previewCrop: true,
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
                // Tags
                $('#offers_tags').select2({tags:[@foreach (DB::table('tags')->lists('title', 'id') as $id => $tag) {"id": {{$id}}, "text" : "{{$tag}}"}, @endforeach],tokenSeparators: [",", " "]});
                // Ofertas Adicionais
                $("#offers_additional").select2({
                    placeholder: "Procurar Ofertas",
                    minimumInputLength: 1,
                    multiple: true,
                    ajax: {
                        url: "{{route('ajax-offers')}}",
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
                            $.ajax("{{route('ajax-offer')}}", {
                                data: {
                                    'id': id
                                },
                                dataType: "jsonp"
                            }).done(function(data) { callback(data.offers); });
                        }
                    },
                    formatResult: offerFormatResult,
                    formatSelection: offerFormatSelection,
                    dropdownCssClass: "bigdrop",
                    escapeMarkup: function (m) { return m; }
                });
                $("#offers_additional").on("change", function() { $("#offers_additional_val").html($("#offers_additional").val()); $("#offers_additional").select2("container").find("ul.select2-choices").sortable('refresh')});

                $("#offers_additional").select2("container").find("ul.select2-choices").sortable({
                    containment: 'parent',
                    start: function() { $("#offers_additional").select2("onSortStart"); },
                    update: function() { $("#offers_additional").select2("onSortEnd"); }
                });
                function offerFormatResult(offer) {
                    var markup = "<table class='offer-result'><tr>";
                    if (offer.cover_img !== undefined) {
                        markup += "<td class='offer-image'><img src='" + offer.cover_img + "' style='max-width:100px;'/></td>";
                    }else{
                        markup += "<td class='offer-image'><img src='{{asset('assets/themes/floripa/backend/img/logo.png')}}'/></td>";
                    }
                    markup += "<td class='offer-info'><div class='offer-title'><b>#"+offer.ofid+"</b> " + offer.offer_title + " ( "+offer.destname+" )</div>";
                    if (offer.optitle !== undefined) {
                        markup += "<div class='offer-sub'>Opção: " + offer.optitle + " - "+offer.opsubtitle+" - R$ "+offer.price_with_discount+"</div>";
                    }
                    else if (offer.percent_off !== undefined) {
                        markup += "<div class='offer-percent_off'>" + offer.percent_off + "% OFF</div>";
                    }
                    markup += "</td></tr></table>";
                    return markup;
                }

                function offerFormatSelection(offer) {
                    return "<b>#"+offer.ofid+"</b> " + offer.offer_title + " ( "+offer.destname+" ) - Opção: " + offer.optitle;
                }
            });
        </script>

    </div>

@stop