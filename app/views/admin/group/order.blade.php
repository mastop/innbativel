@section('content')

<div class="well widget row-fluid">

    <div id="TabContainer">
        <ul>
            @foreach ($groups as $group)
            <li>
                <hr>
                <div class="row-fluid">
                    {{ Former::legend($group->title) }}
                    <div class="span1">
                        &nbsp;
                    </div>
                    <div class="span10">
                        {{ Former::framework('Nude') }}
                        {{ Former::hidden('group['.$group->id.']')
                                 ->id('group'.$group->id)
                                 ->class('span12') }}
                    </div>
                    <div class="span1">
                        &nbsp;
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    
</div>

<script type="text/javascript">

    $('#TabContainer').tabs();
    $('#TabContainer .ui-tabs-nav').sortable();

    @foreach ($groups as $group)

        // Ofertas Adicionais
        $("#group{{ $group->id }}").select2({
            placeholder: "Procurar Ofertas",
            minimumInputLength: 1,
            multiple: true,
            ajax: {
                url: "{{route('ajax-offer')}}",
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
        $("#group{{ $group->id }}").on("change", function() { $("#group{{ $group->id }}_val").html($("#group{{ $group->id }}").val()); $("#group{{ $group->id }}").select2("container").find("ul.select2-choices").sortable('refresh')});

        $("#group{{ $group->id }}").select2("container").find("ul.select2-choices").sortable({
            containment: 'parent',
            start: function() { $("#group{{ $group->id }}").select2("onSortStart"); },
            update: function() { $("#group{{ $group->id }}").select2("onSortEnd"); }
        }).sortable('refresh');

    @endforeach

    function offerFormatResult(offer) {
        var markup = "<table class='offer-result'><tr>";
        if (offer.cover_img !== undefined) {
            markup += "<td class='offer-image'><img src='" + offer.cover_img + "' style='max-width:100px;'/></td>";
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

</script>

@stop
