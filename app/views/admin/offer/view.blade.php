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
    <label for="popup_features" class="control-label">Título curto</label>
    <div class="controls">
        {{ $offer->short_title }}
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
        @endif
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Empresa Parceira</label>
    <div class="controls">
        @if(isset($offer->partner) && isset($offer->partner->profile))
        {{ $offer->partner->profile->first_name . $offer->partner->profile->last_name }}
        @endif
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">ONG para Doação</label>
    <div class="controls">
        @if(isset($offer->ngo))
        {{ $offer->ngo->name }}
        @endif
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Início da Oferta</label>
    <div class="controls">
        {{ $offer->starts_on }}
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Fim da Oferta</label>
    <div class="controls">
        {{ $offer->ends_on }}
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Destaques da Oferta</label>
    <div class="controls">{{ $offer->features }}</div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Destaques Popup</label>
    <div class="controls">{{ $offer->popup_features }}</div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Política de Reagendamento/Cancelamento</label>
    <div class="controls">{{ $offer->rules }}</div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Inclusos</label>
    <div class="controls">
        <ul>
            @foreach ($offer->included as $item)
            <li>{{ $item->icon . $item->title }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Depoimento</label>
    <div class="controls">
        @if(isset($offer->tell_us))
        {{ $offer->tell_us->name . ' (' . $offer->tell_us->destiny . '):' . $offer->tell_us->depoiment }}
        @endif
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Categoria</label>
    <div class="controls">
        @if(isset($offer->category))
        {{ $offer->category->title }}
        @endif
    </div>
</div>

{{ Former::checkbox('is_available', '')
->text('Oferta será publicada')}}
{{ Former::checkbox('is_product', '')
->text('É um <b>produto</b>?') }}


{{ Former::legend('Gêneros') }}

<div class="control-group">
    <label for="popup_features" class="control-label">Gênero 1</label>
    <div class="controls">
        @if(isset($offer->genre))
        {{ $offer->genre->icon . $offer->genre->title }}
        @endif
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Gênero 2</label>
    <div class="controls">
        @if(isset($offer->genre2))
        {{ $offer->genre2->icon . $offer->genre2->title }}
        @endif
    </div>
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
    <label for="popup_features" class="control-label">Newsletter</label>
    <div class="controls">
        @if(isset($offer->newsletter_img))
        <img src="{{ $offer->newsletter_img }}" style="width: 280px; height: 117px;"/>
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
            {{ Former::text('offer_options[0][price_original]', 'Preço Original')->class('span12 currency PriceOriginal required')->required()->prepend('R$') }}
            {{ Former::text('offer_options[0][price_with_discount]', 'Preço com Desconto')->class('span12 currency PriceWithDiscount required')->required()->prepend('R$') }}
            {{ Former::text('offer_options[0][percent_off]', 'Total do Desconto')->class('span4 TotalDiscount required')->required()->append('% OFF')->value('0') }}
            {{ Former::text('offer_options[0][transfer]', 'Repasse ao Parceiro')->class('span12 currency TotalTransfer required')->required()->prepend('R$') }}
            {{ Former::text('offer_options[0][min_qty]', 'Limite Boleto')->class('span4')->append('compras')->value('0') }}
            {{ Former::text('offer_options[0][max_qty]', 'Limite Total')->class('span4')->append('compras')->value('0') }}
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
            {{ Former::text('offer_options['.$k.'][price_original]', 'Preço Original')->class('span12 currency PriceOriginal required')->required()->prepend('R$')->value($offer_options['price_original']) }}
            {{ Former::text('offer_options['.$k.'][price_with_discount]', 'Preço com Desconto')->class('span12 currency PriceWithDiscount required')->required()->prepend('R$')->value($offer_options['price_with_discount']) }}
            {{ Former::text('offer_options['.$k.'][percent_off]', 'Total do Desconto')->class('span4 TotalDiscount required')->required()->append('% OFF')->value($offer_options['percent_off']) }}
            {{ Former::text('offer_options['.$k.'][transfer]', 'Repasse ao Parceiro')->class('span12 currency TotalTransfer required')->required()->prepend('R$')->value($offer_options['transfer']) }}
            {{ Former::text('offer_options['.$k.'][min_qty]', 'Limite Boleto')->class('span4')->append('compradores')->value($offer_options['min_qty']) }}
            {{ Former::text('offer_options['.$k.'][max_qty]', 'Limite Total')->class('span4')->append('compradores')->value($offer_options['max_qty']) }}
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

<div class="control-group">
    <label for="popup_features" class="control-label">Ofertas Adicionais</label>
    <div class="controls">
        <ul>
            @foreach ($offer->offer_additional_offer as $item)
            <li>{{ link_to_route('admin.offer.view', $item->offer->id . ' | ' . (isset($item->offer->destiny) ? $item->offer->destiny->name : $item->offer->title ) . ' | ' . $item->title, ['id' => $item->offer->id]) }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Grupos</label>
    <div class="controls">
        <ul>
            @foreach ($offer->group as $item)
            <li>{{ $item->title }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Tags</label>
    <div class="controls">
        <ul>
            @foreach ($offer->tag as $item)
            <li>{{ $item->title }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Feriados</label>
    <div class="controls">
        <ul>
            @foreach ($offer->holiday as $item)
            <li>{{ $item->title }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="control-group">
    <label for="popup_features" class="control-label">Itens vendidos</label>
    <div class="controls">
        {{ $offer->sold }}
    </div>
</div>

{{ Former::checkbox('is_active', '')
->text('Oferta Ativa do Site')}}

</fieldset>
{{ Former::close() }}

</div>
@stop
