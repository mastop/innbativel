@section('content')

    <div class="well widget row-fluid">

        {{ Former::open_for_files()->rules([
        	'name' => 'required|min:5',
            'email' => 'required|email',
            'destiny' => 'required',
            'travel_date' => 'required|date_format:d/m/Y',
            'depoiment' => 'required|min:30',
        ])
        ->setAttribute('files', true) }}

        {{ Former::populate($tellus) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::text('email', 'E-mail')->class('span12') }}
        {{ Former::text('destiny', 'Destino')->class('span12') }}
        {{ Former::text('partner_name', 'Parceiro')->class('span12') }}
        {{ Former::text('travel_date', 'Data da viagem')->class('span12 datepicker') }}
        {{ Former::text('depoiment', 'Depoimento')->class('span12') }}


        @if(isset($tellus->img))
			<figure class="span4 form-file-thumb"><img src="{{ $tellus->img }}"></figure>
		@endif

        {{ Former::file('img', 'Imagem (NN x MM)')->accept('png', 'jpg', 'jpeg')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop


