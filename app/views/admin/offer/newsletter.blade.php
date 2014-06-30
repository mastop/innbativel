@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Gerar HTML da Newsletter</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.offer.create') }}" title="Criar Oferta" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.offer.sort') }}" title="Ordenar Ofertas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
				<a href="{{ route('admin.offer.newsletter') }}" title="Gerar Newsletter" class="dropdown-toggle navbar-icon"><i class="icon-envelope"></i></a>
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
        <div id="groups">
            <div class="group">
            {{ Former::legend('Grupo 1') }}
            {{ Former::text('title', 'Título do Grupo')->class('span12') }}
            {{ Former::text('link', 'Link do Botão')->class('span12') }}
            {{ Former::text('link', 'Texto do Botão')->class('span12') }}

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
            markup += "<td class='offer-image'><img src='//innbativel.s3.amazonaws.com/logo-backend.png'/></td>";
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
        alert(offersValue);
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
</script>
@stop
