@section('content')
<div class="well widget row-fluid">

{{ Former::horizontal_open()->rules([
'title' => 'required',
'destiny_id' => 'required',
'partner_id' => 'required',
'starts_on' => 'required',
'ends_on' => 'required',
'rules' => 'required',
'category_id' => 'required',
'ngo_id' => 'required',
'genre_id' => 'required',
])->id('formOffer')->populate($offer) }}

{{ Former::populateField('offers_included', $offer->included()->lists('included_id')) }}
{{ Former::populateField('offers_additional', implode(',', $offer->offer_additional()->lists('offer_additional_id'))) }}
{{ Former::populateField('offers_tags', implode(',', $offer->tag()->lists('tag_id'))) }}

{{ Former::legend('Dados da Oferta') }}

{{ Former::text('title', 'Título')->class('span12') }}
{{ Former::text('subtitle', 'Subtítulo')->class('span12') }}

{{ Former::select('destiny_id', 'Destino')
->addOption(null)
->data_placeholder('Selecione um Destino')
->fromQuery(Destiny::all(), 'name')
->class('span12 select2') }}

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
{{ Former::textarea('popup_features', 'Destaques Popup')->rows(10)->columns(20)->class('span12 redactor')->placeholder('Insira os Destaques que aparecerão como Popup')}}
{{ Former::textarea('rules', 'Regras')->rows(10)->columns(20)->class('span12 redactor')->placeholder('Insira as Regras da Oferta') }}


{{ Former::multiselect('offers_included', 'Inclusos')
->fromQuery(Included::getAllArray())
->data_placeholder('Selecione os Itens Inclusos')
->class('span12') }}

{{ Former::select('tell_us_id', 'Depoimento de Cliente')
->addOption(null)
->fromQuery(TellUs::orderBy('destiny')->get())
->data_placeholder('Selecione um Depoimento')
->class('span12 select2') }}


{{ Former::stacked_radios('category_id', 'Categoria')->radios(Category::getAllArray()) }}

{{ Former::checkbox('display_map', '')
->text('Exibir mapa na oferta')}}
{{ Former::checkbox('is_available', '')
->text('Oferta será publicada')}}
{{ Former::checkbox('is_product', '')
->text('É um <b>produto</b>?') }}


{{ Former::legend('Gêneros') }}

{{ Former::select('genre_id', 'Gênero 1')
->addOption(null)
->data_placeholder('Selecione um Gênero')
->fromQuery(Genre::getAllArray())
->class('span12')
}}

{{ Former::select('genre2_id', 'Gênero 2')
->addOption(null)
->data_placeholder('Selecione um Gênero')
->fromQuery(Genre::getAllArray())
->class('span12')
}}


{{ Former::legend('Fotos')->id('OfferImagesLegend') }}


{{-- Macro ImageUpload() está definida em app/start/global.php --}}

{{HTML::ImageUpload('cover_img', 'Principal', false, false, '753x314')}}
{{HTML::ImageUpload('newsletter_img', 'Newsletter', false, false, '280x117')}}
{{HTML::ImageUpload('offers_images', 'Demais Imagens', true, $offer->offer_image()->get(['offer_id', 'url'])->lists('url'), '753x314')}}


{{ Former::legend('Opções de Venda') }}

<div id="offerOptionsMain">
    @if(!Input::old('offer_options', $offer->offer_option()->get()->toArray()))
    <div class="row-fluid offerOptions">
        <div class="span1">
            &nbsp;
        </div>
        <div class="span10 offerOption">
            <span class="badge badge-info offerOptionNumber">1</span>
            {{ Former::text('offer_options[0][title]', 'Título')->class('span12 required')->required() }}
            {{ Former::text('offer_options[0][subtitle]', 'Subtítulo')->class('span12') }}
            {{ Former::text('offer_options[0][price_original]', 'Preço Original')->class('span12 currency PriceOriginal required')->required()->prepend('R$') }}
            {{ Former::text('offer_options[0][price_with_discount]', 'Preço com Desconto')->class('span12 currency PriceWithDiscount required')->required()->prepend('R$') }}
            {{ Former::text('offer_options[0][percent_off]', 'Total do Desconto')->class('span4 TotalDiscount required')->required()->append('% OFF')->value('0') }}
            {{ Former::text('offer_options[0][transfer]', 'Repasse ao Parceiro')->class('span12 currency TotalTransfer required')->required()->prepend('R$') }}
            {{ Former::text('offer_options[0][min_qty]', 'Limite Boleto')->class('span4')->append('compras')->value('0') }}
            {{ Former::text('offer_options[0][max_qty]', 'Limite Total')->class('span4')->append('compras')->value('0') }}
            {{ Former::text('offer_options[0][voucher_validity_start]', 'Início Val. Cupom')->class('span12 datepicker required')->required() }}
            {{ Former::text('offer_options[0][voucher_validity_end]', 'Fim Val. Cupom')->class('span12 datepicker required')->required() }}
            {{ Former::button('Remover esta Opção de Venda')->class('btn btn-large btn-block btn-danger btnOptRemove') }}
        </div>
        <div class="span1">
            &nbsp;
        </div>
    </div>
    @else
    @foreach (Input::old('offer_options', $offer->offer_option()->get()->toArray()) as $k => $offer_options)
    <div class="row-fluid offerOptions">
        <div class="span1">
            &nbsp;
        </div>
        <div class="span10 offerOption">
            <span class="badge badge-info offerOptionNumber">{{$k+1}}</span>
            {{ Former::hidden('offer_options['.$k.'][id]')->id('offer_options['.$k.'][id]')->value($offer_options['id']) }}
            {{ Former::text('offer_options['.$k.'][title]', 'Título')->class('span12 required')->required()->value($offer_options['title']) }}
            {{ Former::text('offer_options['.$k.'][subtitle]', 'Subtítulo')->class('span12')->value($offer_options['subtitle']) }}
            {{ Former::text('offer_options['.$k.'][price_original]', 'Preço Original')->class('span12 currency PriceOriginal required')->required()->prepend('R$')->value($offer_options['price_original']) }}
            {{ Former::text('offer_options['.$k.'][price_with_discount]', 'Preço com Desconto')->class('span12 currency PriceWithDiscount required')->required()->prepend('R$')->value($offer_options['price_with_discount']) }}
            {{ Former::text('offer_options['.$k.'][percent_off]', 'Total do Desconto')->class('span4 TotalDiscount required')->required()->append('% OFF')->value($offer_options['percent_off']) }}
            {{ Former::text('offer_options['.$k.'][transfer]', 'Repasse ao Parceiro')->class('span12 currency TotalTransfer required')->required()->prepend('R$')->value($offer_options['transfer']) }}
            {{ Former::text('offer_options['.$k.'][min_qty]', 'Limite Boleto')->class('span4')->append('compradores')->value($offer_options['min_qty']) }}
            {{ Former::text('offer_options['.$k.'][max_qty]', 'Limite Total')->class('span4')->append('compradores')->value($offer_options['max_qty']) }}
            {{ Former::text('offer_options['.$k.'][voucher_validity_start]', 'Início Val. Cupom')->class('span12 datepicker required')->required()->value($offer_options['voucher_validity_start']) }}
            {{ Former::text('offer_options['.$k.'][voucher_validity_end]', 'Fim Val. Cupom')->class('span12 datepicker required')->required()->value($offer_options['voucher_validity_end']) }}
            {{ Former::button('Remover esta Opção de Venda')->class('btn btn-large btn-block btn-danger btnOptRemove') }}
        </div>
        <div class="span1">
            &nbsp;
        </div>
    </div>
    @endforeach
    @endif

</div>

{{ Former::button('Adicionar Opção de Venda')->id('offer_opt_add')->class('btn btn-large btn-block btn-success') }}

{{ Former::legend('Ofertas Adicionais') }}

<div class="row-fluid">
    <div class="span1">
        &nbsp;
    </div>
    <div class="span10">
        {{ Former::framework('Nude') }}
        {{ Former::hidden('offers_additional')
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
        {{ Former::hidden('offers_tags')
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
        {{--
        Isso está deste jeito porque a BOSTA do Former tem um bug
        que não repopula os checkboxes agrupados
        --}}
        <div class="control-group">
            <div class="controls">
                @foreach(Group::getAllArray() as $g => $grupo)
                <label for="offers_groups_{{$g}}" class="checkbox">
                    <input value="{{$g}}" id="offers_groups_{{$g}}" type="checkbox" name="offers_groups[]"
                    @if(is_array(Input::get('offers_groups', Input::old('offers_groups', $groups))) && in_array($g, Input::get('offers_groups', Input::old('offers_groups', $groups))))
                    checked
                    @endif
                    > {{$grupo}}</label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="span6">
        {{ Former::legend('Feriados') }}
        <div class="control-group">
            <div class="controls">
                @foreach(Holiday::getAllArray() as $f => $feriado)
                <label for="offers_holidays_{{$f}}" class="checkbox">
                    <input value="{{$f}}" id="offers_holidays_{{$f}}" type="checkbox" name="offers_holidays[]"
                    @if(is_array(Input::get('offers_holidays', Input::old('offers_holidays', $holidays))) && in_array($f, Input::get('offers_holidays', Input::old('offers_holidays', $holidays))))
                    checked
                    @endif
                    > {{$feriado}}</label>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{ Former::text('sold', 'Itens Vendidos')->class('span12') }}
{{ Former::checkbox('is_active', '')
->text('Oferta Ativa do Site')}}



<br>
<div id="files" class="files"></div>



{{ Former::actions()
->primary_submit('Atualizar Oferta')
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
                imageMaxWidth: 753,
                imageMinWidth: 753,
                disableImageResize: false,
                imageMaxHeight: 314,
                imageMinHeight: 314,
                imageForceResize: true,
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
                var fileURL = ($(this).val().substring(0, 2) == '//') ? $(this).val() : url + 'temp/'+$(this).val();
                $(this).parent().find('div.dropzone').css("background-image", "url('"+fileURL+"')").css("background-position", "center center").css("background-repeat", "no-repeat");
                $(this).parent().find('div.fileremove').show();
                $(this).parent().find('div.dropinfo').hide();
            }else if($(this).parent().data('img') != undefined){
                // Multi files
                var fileURL = ($(this).parent().data('img').substring(0, 2) == '//') ? $(this).parent().data('img') : url + 'temp/'+$(this).parent().data('img');
                $(this).parent().css("background-image", "url('"+fileURL+"')").css("background-position", "center center").css("background-repeat", "no-repeat");
                $(this).val($(this).parent().data('img'));
                $(this).parent().fadeIn();
                $(this).parent().sortable({connectWith: ".multifiles"});
            }
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
                        'id': id,
                        'offer_id': {{ $offer->id }}
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
    }).sortable('refresh');
    function offerFormatResult(offer) {
        var markup = "<table class='offer-result'><tr>";
        var offerIMGURL = '//{{Configuration::get("s3url")}}/ofertas/'+offer.ofid+'/'+offer.cover_img;
        if (offer.cover_img !== undefined) {
            markup += "<td class='offer-image'><img src='" + offerIMGURL + "' style='max-width:100px;'/></td>";
        }else{
            markup += "<td class='offer-image'><img src='//innbativel.s3.amazonaws.com/logo-backend.png'/></td>";
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