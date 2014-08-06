@section('content')

<div class="well widget row-fluid">

    {{ Former::inline_open(route('admin.group.save_order')) }}
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
                                 ->value($group->offer_ids)
                                 ->id('group'.$group->id)
                                 ->class('span12') }}

                        {{ Former::hidden('group_id'.$group->id)
                                 ->value($group->id)
                                 ->id('group_id'.$group->id)
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
    {{ Former::submit('Salvar') }}

    {{ Former::close() }}
    
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
                var group_id=$('#group_id{{ $group->id }}').val();
                if (id!=="") {
                    $.ajax("{{route('ajax-offer-groups')}}", {
                        data: {
                            'id': id,
                            'group_id': group_id
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
        var offerIMGURL = '//{{Configuration::get("s3url")}}/ofertas/'+offer.id+'/'+offer.cover_img;
        if (offer.cover_img !== undefined) {
            markup += "<td class='offer-image'><img src='" + offerIMGURL + "' style='max-width:100px;'/></td>";
        }else{
            markup += "<td class='offer-image'><img src='//{{Configuration::get("s3url")}}/logo-backend.png'/></td>";
        }
        markup += "<td class='offer-info'><div class='offer-title'><b>#"+offer.id+"</b> " + offer.offer_title + " ( "+offer.destname+" )</div>";
        markup += "<div class='offer-sub'>"+offer.offer_subtitle+" - R$ "+offer.price_with_discount+"</div>";
        if (offer.percent_off !== undefined) {
            markup += "<div class='offer-percent_off'>" + offer.percent_off + "% OFF</div>";
        }
        markup += "</td></tr></table>";
        return markup;
    }

    function offerFormatSelection(offer) {
        return "<b>#"+offer.id+"</b> " + offer.offer_title + " ( "+offer.destname+" ) - R$ " + offer.price_with_discount;
    }

</script>

@stop
