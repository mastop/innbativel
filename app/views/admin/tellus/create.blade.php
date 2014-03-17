@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        	'destiny' => 'required',
        	'partner_name' => 'required',
        	'travel_date' => 'required',
			'depoiment' => 'required',
			'img' => 'required',
        ]) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::text('destiny', 'Destino')->class('span12') }}
        {{ Former::text('partner_name', 'Parceiro')->class('span12') }}
        {{ Former::date('travel_date', 'Data da viagem')->class('span12') }}
        {{ Former::text('depoiment', 'Depoimento')->class('span12') }}
        {{ Former::file('img', 'Imagem (NN x MM)')->accept('png', 'jpg', 'jpeg')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
