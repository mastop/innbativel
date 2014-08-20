@section('content')
<div class="widget">
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.offer.save_sort')) }}

		<div id="TabContainer" style="padding: 10px;">
			<ul>
				@foreach ($offers as $offer)
                <li class="select2-results-dept-0 select2-result select2-result-selectable select2-highlighted" role="presentation">
                    <div class="select2-result-label" role="option">
                        <table class="offer-result">
                            <tbody>
                            <tr>
                                <td class="offer-image"><img src="{{$offer->thumb}}" style="max-width:100px;"></td>
                                <td class="offer-info">
                                    <div class="offer-title"><b>#{{$offer->id}}</b> {{$offer->category->title}} / {{$offer->destiny->name}}</div>
                                    <div class="offer-sub">R$ {{$offer->price_with_discount}} ({{$offer->percent_off}}% OFF)</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    {{ Former::hidden('offers[]')->value($offer->id) }}
                </li>
				@endforeach
			</ul>
		</div>

        {{ Former::hidden('cat')->value($cat) }}

        {{ Former::actions()
        ->primary_submit('Ordenar')
        ->inverse_link('Resetar', route('admin.offer.sort')) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop
