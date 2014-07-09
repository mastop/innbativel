@section('content')
<div class="well widget row-fluid">

{{ Former::horizontal_open()->populate($offer) }}

<fieldset disabled="disabled">

{{ Former::legend('Dados da Oferta') }}

<div class="control-group">
    <label for="popup_features" class="control-label">Título</label>
    <div class="controls">
        {{ $offer->title }}
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Subtítulo</label>
    <div class="controls">
        {{ $offer->subtitle }}
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Destino</label>
    <div class="controls">
        @if(isset($offer->destiny))
        {{ $offer->destiny->name }}
        @else
        --
        @endif
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Destaques da Oferta</label>
    <div class="controls">{{ $offer->features }}</div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Política de Reagendamento/Cancelamento</label>
    <div class="controls">{{ $offer->rules }}</div>
</div>

{{ Former::legend('Fotos')->id('OfferImagesLegend') }}


<div class="control-group">
    <label for="popup_features" class="control-label">Principal</label>
    <div class="controls">
        @if(isset($offer->cover_img))
        <img src="{{ $offer->cover_img }}" style="width: 753px; height: 314px;"/>
        @endif
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Demais Imagens</label>
    <div class="controls">
        <ul>
            @foreach ($offer->offer_image as $item)
            <li><img src="{{ $item->url }}" style="width: 753px; height: 314px;"/></li>
            @endforeach
        </ul>
    </div>
</div>

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
            {{ Former::text('offer_options[0][price_with_discount]', 'Preço')->class('span12 currency PriceWithDiscount required')->required()->prepend('R$') }}
            {{ Former::text('offer_options[0][transfer]', 'Repasse ao Parceiro')->class('span12 currency TotalTransfer required')->required()->prepend('R$') }}
            {{ Former::text('offer_options[0][voucher_validity_start]', 'Início Val. Cupom')->class('span12 datepicker required')->required() }}
            {{ Former::text('offer_options[0][voucher_validity_end]', 'Fim Val. Cupom')->class('span12 datepicker required')->required() }}
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
            {{ Former::text('offer_options['.$k.'][price_with_discount]', 'Preço')->class('span12 currency PriceWithDiscount required')->required()->prepend('R$')->value($offer_options['price_with_discount']) }}
            {{ Former::text('offer_options['.$k.'][transfer]', 'Repasse ao Parceiro')->class('span12 currency TotalTransfer required')->required()->prepend('R$')->value($offer_options['transfer']) }}
            {{ Former::text('offer_options['.$k.'][voucher_validity_start]', 'Início Val. Cupom')->class('span12 datepicker required')->required()->value($offer_options['voucher_validity_start']) }}
            {{ Former::text('offer_options['.$k.'][voucher_validity_end]', 'Fim Val. Cupom')->class('span12 datepicker required')->required()->value($offer_options['voucher_validity_end']) }}
        </div>
        <div class="span1">
            &nbsp;
        </div>
    </div>
    @endforeach
    @endif

</div>

</fieldset>
{{ Former::close() }}

</div>
@stop
